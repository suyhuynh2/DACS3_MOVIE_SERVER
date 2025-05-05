<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Repositories\Favorite_Repository;
use Illuminate\Http\Request;


class Favorite_API extends Controller
{
    protected $favoriteRepository;

    public function __construct(Favorite_Repository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function createFavorite(Request $request)
    {
        $data = $request->all();

        if ($this->favoriteRepository->exists($data['firebase_uid'], $data['movie_id'])) {
            return response()->json(['message' => 'Đã yêu thích phim này rồi'], 409);
        }

        $favorite = $this->favoriteRepository->create($data);
        return response()->json([
            'message' => 'Thêm vào danh sách yêu thích thành công',
            'data' => $favorite
        ], 201);
    }

    public function checkFavorite($firebase_uid, $movie_id)
    {
        try {
            $isFavorite = $this->favoriteRepository->isFavorite($firebase_uid, $movie_id);
            return response()->json(['is_favorite' => $isFavorite], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function removeFavorite(Request $request)
    {
        $firebase_uid = $request->input('firebase_uid');
        $movie_id = $request->input('movie_id');

        $deleted = $this->favoriteRepository->removeFavorite($firebase_uid, $movie_id);

        if ($deleted) {
            return response()->json(['message' => 'Đã xóa khỏi danh sách yêu thích'], 200);
        }

        return response()->json(['message' => 'Không tìm thấy mục yêu thích'], 404);
    }

    public function getFavoritesByUser($firebase_uid)
    {
        try {
            $favorites = $this->favoriteRepository->getFavoritesByUserId($firebase_uid);

            // Kiểm tra dữ liệu trả về
            if ($favorites->isEmpty()) {
                return response()->json(['message' => 'Không có yêu thích nào'], 404);
            }

            $movies = $favorites->map(function ($favorite) {
                $movie = $favorite->movie; // Lấy thông tin movie từ quan hệ

                // Đảm bảo averageRating được tính đúng
                $movie->averageRating = round(optional($movie->ratings)->avg('score') ?? 0, 1);

                return $movie;
            });

            return response()->json($movies, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
