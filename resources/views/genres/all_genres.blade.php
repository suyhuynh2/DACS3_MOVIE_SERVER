@extends('layout')
@section('admin_content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <h1 class="h3 mb-0 text-gray-800">Danh sách thể loại phim</h1>
    </div>
    <a href="{{ route('add-genres-ui')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> THÊM THỂ LOẠI
    </a>
</div>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="min-width: 1000px">
                <thead>
                    <tr>
                        <th style="text-align: center">STT</th>
                        <th style="text-align: center">Tên thể loại</th>
                        <th style="text-align: center">Mô tả</th>
                        <th style="text-align: center">Thao tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="text-align: center">STT</th>
                        <th style="text-align: center">Tên thể loại</th>
                        <th style="text-align: center">Mô tả</th>
                        <th style="text-align: center">Thao tác</th>
                </tfoot>
                <tbody>
                    @foreach ($all_genres as $index => $genre)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $genre->name }}</td>
                        <td>{{ $genre->description }}</td>
                        <td style="text-align: center">
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{ route('edit-genres', $genre->genres_id) }}" class="btn btn-sm btn-warning"
                                    style="margin-right: 15px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" style="display:inline;"
                                    action="{{ route('delete-genres', $genre->genres_id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Xóa thể loại này?')">
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