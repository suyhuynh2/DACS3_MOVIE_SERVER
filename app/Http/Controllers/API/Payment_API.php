<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;
use App\Events\UserUpdated;
use App\Repositories\Users_Repository;

use App\Models\Users;

class Payment_API extends Controller
{

    protected $usersRepository;

    public function __construct(Users_Repository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    // Tạo yêu cầu thanh toán
    public function createPayment(Request $request)
    {
        $firebase_uid = $request->input('firebase_uid');

        // Mã đơn hàng ngẫu nhiên, bạn có thể đổi cách tạo theo ý muốn
        $orderCode = rand(100000, 999999);

        $amount = 2000; // số tiền (đơn vị: VNĐ)
        $description = 'Thanh toán nâng cấp';

        $cancelUrl = env('APP_URL_NGROK') . '/payment/cancel';
        $returnUrl = env('APP_URL_NGROK') . '/payment/return';

        // Tạo chuỗi dữ liệu đúng format để tạo chữ ký (signature)
        $data = "amount={$amount}&cancelUrl={$cancelUrl}&description={$description}&orderCode={$orderCode}&returnUrl={$returnUrl}";

        // Tạo chữ ký HMAC SHA256 với key bí mật PAYOS_CHECKSUM_KEY
        $signature = hash_hmac('sha256', $data, env('PAYOS_CHECKSUM_KEY'));

        // Lưu đơn hàng vào DB (trạng thái chưa thanh toán)
        Payment::create([
            'firebase_uid' => $firebase_uid,
            'amount' => $amount,
            'content' => $description,
            'status' => 'unpaid',
            'order_code' => $orderCode,
        ]);

        // Gửi request tạo payment tới PayOS
        $response = Http::withHeaders([
            'x-client-id' => env('PAYOS_CLIENT_ID'),
            'x-api-key' => env('PAYOS_API_KEY'),
        ])->post('https://api-merchant.payos.vn/v2/payment-requests', [
            'orderCode' => $orderCode,
            'amount' => $amount,
            'description' => $description,
            'returnUrl' => $returnUrl,
            'cancelUrl' => $cancelUrl,
            'signature' => $signature,
        ]);

        // Trả về response JSON từ PayOS cho client
        return response()->json($response->json());
    }


    // Xử lý khi người dùng thanh toán thành công, redirect về
    public function returnPayment(Request $request)
    {
        // Bạn có thể thêm logic kiểm tra, xác nhận đơn hàng tại đây nếu muốn

        return response()->json([
            'message' => 'Giao dịch thành công',
            'data' => $request->all(),
        ]);
    }

    // Xử lý khi người dùng hủy giao dịch
    public function cancelPayment(Request $request)
    {
        return response()->json(['message' => 'Giao dịch bị hủy']);
    }

    // Webhook nhận thông báo thanh toán từ PayOS

    public function webhook(Request $request)
    {
        $payload = $request->all();
        Log::info('PayOS Webhook - Raw payload: ' . json_encode($payload));

        if (isset($payload['code']) && $payload['code'] === '00') {
            $orderCode = $payload['data']['orderCode'] ?? null;

            // Tìm payment theo orderCode cùng với user liên kết
            $payment = Payment::with('user')->where('order_code', $orderCode)->first();

            if ($payment) {
                // Cập nhật trạng thái payment
                $payment->status = 'paid';
                $payment->save();

                // Kiểm tra và cập nhật user thông qua relationship
                if ($payment->user) {
                    $payment->user->role = 'VIP';
                    $payment->user->save();
                    Log::info("Updated user to VIP: {$payment->user->firebase_uid}");

                    $updatedUser = $this->usersRepository->findById($payment->user->firebase_uid);
                    event(new UserUpdated($updatedUser, 'updated'));
                } else {
                    Log::error("User not found for payment: {$orderCode}");
                }



                return response()->json(['success' => true]);
            }

            return response()->json(['error' => 'Payment not found'], 404);
        }

        return response()->json(['error' => 'Payment failed'], 400);
    }
}
