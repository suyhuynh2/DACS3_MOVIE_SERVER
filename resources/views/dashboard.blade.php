@extends('layout')
@section('admin_content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bảng điều khiển</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Tổng SỐ NGƯỜI DÙNG</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            TỔNG PHIM</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMovies }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-film fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">DOANH
                            THU
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalRevenueVND }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            TỔNG SỐ LƯỢT XEM</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalViews }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-eye fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Row -->

<div class="row">
    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Tổng quan thể loại phim</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2 d-flex justify-content-center">
                    <canvas id="myPieChart"></canvas>
                </div>
                <div class="mt-4 text-center small" id="genre-legend">
                    {{-- Legend sẽ được render tự động --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Rankings -->
    <div class="col-xl-8 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Các xếp hạng của phim</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Cột Top lượt xem -->
                    <div class="col-md-6">
                        <h5 class="text-sm font-weight-bold">Top 5 phim có lượt xem cao nhất</h5>
                        <ol type="1">
                            @foreach($topViews as $i => $movie)
                            <li>{{ $movie->title }} ({{ $movie->views }})</li>
                            @endforeach
                        </ol>
                    </div>

                    <!-- Cột Top yêu thích -->
                    <div class="col-md-6">
                        <h5 class="text-sm font-weight-bold">Top 5 phim được yêu thích nhất</h5>
                        <ol type="1">
                            @foreach($topFavorites as $i => $movie)
                            <li>{{ $movie->title }} ({{ $movie->favored_by_users_count }})</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const genreChartData = @json($genreChartData);

const ctx = document.getElementById('myPieChart').getContext('2d');
const labels = genreChartData.map(item => item.name);
const data = genreChartData.map(item => item.count);

const backgroundColors = [
    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69', '#f8f9fc'
];

const myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            data: data,
            backgroundColor: backgroundColors,
            hoverBackgroundColor: backgroundColors,
            borderColor: "#fff",
        }],
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'bottom',
            }
        }
    }
});
</script>
@endsection