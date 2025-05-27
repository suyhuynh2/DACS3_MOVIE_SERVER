<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Favorite_Repository;
use App\Repositories\Genres_Repository;
use Illuminate\Http\Request;
use App\Repositories\Movie_Repository;
use App\Repositories\Users_Repository;

class Dashboard_Controller extends Controller
{
    protected $movieRepo;
    protected $userRepo;
    protected $genresRepo;
    protected $favoriteRepo;

    public function __construct(Movie_Repository $movieRepo, Users_Repository $userRepo, Genres_Repository $genresRepo, Favorite_Repository $favoriteRepo)
    {
        $this->movieRepo = $movieRepo;
        $this->userRepo = $userRepo;
        $this->genresRepo = $genresRepo;
        $this->favoriteRepo = $favoriteRepo;
    }

    public function index()
    {
        $totalMovies = $this->movieRepo->all()->count();
        $totalUsers = $this->userRepo->all()->count();
        $totalViews = $this->movieRepo->all()->sum('views');

        // Lấy dữ liệu cho Pie Chart
        $genres = $this->genresRepo->all();
        $genreChartData = [];
        foreach ($genres as $genre) {
            $genreChartData[] = [
                'name' => $genre->name,
                'count' => $genre->movies()->count(),
            ];
        }

        // Tính tổng doanh thu từ user VIP
        $vipCount = $this->userRepo->countByRole('VIP');
        $totalRevenue = $vipCount * 70000;
        $totalRevenueVND = number_format($totalRevenue, 0, ',', '.') . ' VNĐ';
        $topViews = $this->movieRepo->topByViews(5);
        $topFavorites = $this->favoriteRepo->topByFavorites(5);

        return view('dashboard', compact(
            'totalMovies',
            'totalUsers',
            'totalViews',
            'genreChartData',
            'totalRevenueVND',
            'topViews',
            'topFavorites'
        ));
    }
}
