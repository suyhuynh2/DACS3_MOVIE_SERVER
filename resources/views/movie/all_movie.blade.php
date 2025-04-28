@extends('layout')
@section('admin_content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <h1 class="h3 mb-0 text-gray-800">Danh sách phim</h1>
    </div>
    <a href="{{ route('add-movie-ui')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> THÊM PHIM
    </a>
</div>



<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"
                style="min-width: 1500px; table-layout: fixed;">
                <thead>
                    <tr>
                        <th style="width: 150px; text-align: center">Tên phim</th>
                        <th style="width: 120px; text-align: center">Thể loại</th>
                        <th style="width: 120px; text-align: center">Diễn viên</th>
                        <th style="width: 250px; text-align: center">Mô tả</th>
                        <th style="width: 110px; text-align: center">Ảnh poster</th>
                        <th style="width: 120px; text-align: center">Trailer Url</th>
                        <th style="width: 120px; text-align: center">Video Url</th>
                        <th style="width: 90px; text-align: center">Năm</th>
                        <th style="width: 110px; text-align: center">Thời lượng</th>
                        <th style="width: 100px; text-align: center">Quốc gia</th>
                        <th style="width: 100px; text-align: center">Lượt xem</th>
                        <th style="width: 110px; text-align: center">Trạng thái</th>
                        <th style="width: 140px; text-align: center">Thao tác</th>


                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="text-align: center">Tên phim</th>
                        <th style="text-align: center">Thể loại</th>
                        <th style="text-align: center">Diễn viên</th>
                        <th style="text-align: center">Mô tả</th>
                        <th style="text-align: center">Ảnh poster</th>
                        <th style="text-align: center">Trailer Url</th>
                        <th style="text-align: center">Video Url</th>
                        <th style="text-align: center">Năm</th>
                        <th style="text-align: center">Thời lượng</th>
                        <th style="text-align: center">Quốc gia</th>
                        <th style="text-align: center">Lượt xem</th>
                        <th style="text-align: center">Trạng thái</th>
                        <th style="text-align: center">Thao tác</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($movies as $movie)
                    <tr>
                        <td class="text-center">{{ $movie->title }}</td>
                        <td class="text-center">
                            @foreach ($movie->genres as $genre)
                            <span>{{ $genre->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $movie->actors }}</td>
                        <td>{{ $movie->description }}</td>
                        <td class="text-center">
                            <img src="{{ asset($movie->poster_url) }}" alt="{{ $movie->title }}" width="80" height="120"
                                style="object-fit: cover;">

                        </td>
                        <td>{{ $movie->trailer_url }}</td>
                        <td>{{ $movie->video_url }}</td>
                        <td class="text-center">{{ $movie->release_year }}</td>
                        <td class="text-center">{{ $movie->duration }}</td>
                        <td class="text-center">{{ $movie->country }}</td>
                        <td class="text-center">{{ number_format($movie->views) }}</td>
                        <td class="text-center">{{ $movie->status == 1 ? 'VIP' : 'FREE' }}</td>
                        <td style="text-align: center">
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{ route('edit-movie-ui', $movie->movie_id) }}" class="btn btn-sm btn-warning"
                                    style="margin-right: 15px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('delete-movie', $movie->movie_id) }}"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Xóa phim này?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>


            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            scrollX: true,
            pageLength: 5,
            autoWidth: false
        });
    });
</script>
@endpush