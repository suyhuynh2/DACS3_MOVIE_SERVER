<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\History_Repository;
use Illuminate\Http\Request;

class History_API extends Controller
{
    protected $historyRepository;

    public function __construct(History_Repository $historyRepository)
    {
        $this->historyRepository = $historyRepository;
    }

    public function getHistoryByUser($firebase_uid)
    {
        $history = $this->historyRepository->getByUser($firebase_uid);
        return response()->json($history);
    }

    public function store(Request $request)
    {
        $data = $request->only(['firebase_uid', 'movie_id', 'progress', 'watched_at']);

        if ($this->historyRepository->exists($data['firebase_uid'], $data['movie_id'])) {
            $this->historyRepository->updateProgress($data['firebase_uid'], $data['movie_id'], $data['progress'], $data['watched_at']);
        } else {
            $this->historyRepository->create($data);
        }

        return response()->json(['message' => 'Lịch sử xem được lưu thành công'], 200);
    }

    public function updateHistoryProgress(Request $request, $firebase_uid, $movie_id)
    {
        $progress = $request->input('progress');

        if (!$progress) {
            return response()->json(['message' => 'Thiếu thông tin progress'], 400);
        }

        $updated = $this->historyRepository->updateProgress($firebase_uid, $movie_id, $progress);

        if ($updated) {
            return response()->json(['message' => 'Đã cập nhật lịch sử xem'], 200);
        } else {
            return response()->json(['message' => 'Không tìm thấy lịch sử phù hợp'], 404);
        }
    }

    public function checkHistory($firebase_uid, $movie_id)
    {
        try {
            $isHistory = $this->historyRepository->exists($firebase_uid, $movie_id);
            return response()->json(['is_history' => $isHistory], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getInfoHistory($firebase_uid, $movie_id)
    {
        try {
            $history = $this->historyRepository->getByUserAndMovie($firebase_uid, $movie_id);
            return response()->json($history, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
