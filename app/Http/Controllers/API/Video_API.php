<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Video_API extends Controller
{
    public function stream($videoName)
    {
        // Đường dẫn đến thư mục video
        $videoPath = 'C:/Users/ADMIN/Videos/movie-trailer/' . urldecode($videoName);

        // Kiểm tra file tồn tại
        if (!file_exists($videoPath)) {
            return response()->json(['error' => 'Video not found'], 404);
        }

        // Lấy thông tin file
        $fileSize = filesize($videoPath);
        $mimeType = mime_content_type($videoPath);

        // Xử lý byte-range requests
        $start = 0;
        $end = $fileSize - 1;
        $length = $fileSize;

        $headers = [
            'Content-Type' => $mimeType,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline; filename="' . basename($videoPath) . '"'
        ];

        if (request()->headers->has('Range')) {
            preg_match('/bytes=(\d+)-(\d+)?/', request()->header('Range'), $matches);
            $start = intval($matches[1]);
            if (isset($matches[2])) {
                $end = intval($matches[2]);
            }
            $length = $end - $start + 1;

            $headers['Content-Range'] = "bytes $start-$end/$fileSize";
            $headers['Content-Length'] = $length;

            $status = 206; // Partial Content
        } else {
            $headers['Content-Length'] = $length;
            $status = 200;
        }

        // Stream response
        return response()->stream(function () use ($videoPath, $start, $length) {
            $stream = fopen($videoPath, 'rb');
            fseek($stream, $start);
            $bytesSent = 0;
            $buffer = 1024 * 8;

            while (!feof($stream) && $bytesSent < $length) {
                $readLength = min($buffer, $length - $bytesSent);
                echo fread($stream, $readLength);
                flush();
                $bytesSent += $readLength;
            }

            fclose($stream);
        }, $status, $headers);
    }
}
