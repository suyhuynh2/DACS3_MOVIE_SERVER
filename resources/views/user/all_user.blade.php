@extends('layout')
@section('admin_content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <h1 class="h3 mb-0 text-gray-800">Danh sách người dùng</h1>
    </div>
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
                        <th style="text-align: center">firebase_uid</th>
                        <th style="text-align: center">Tên người dùng</th>
                        <th style="text-align: center">Email</th>
                        <th style="text-align: center">Vai trò</th>
                        <th style="text-align: center">Đăng nhập bằng</th>
                        <th style="text-align: center">Thao tác</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th style="text-align: center">firebase_uid</th>
                        <th style="text-align: center">Tên người dùng</th>
                        <th style="text-align: center">Email</th>
                        <th style="text-align: center">Vai trò</th>
                        <th style="text-align: center">Đăng nhập bằng</th>
                        <th style="text-align: center">Thao tác</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->firebase_uid }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>{{ $user->provider ?? 'Tài khoản hệ thống' }}</td>
                        <td style="text-align: center">
                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{ route('edit-user-ui', ['firebase_uid' => $user->firebase_uid]) }}"
                                    class="btn btn-sm btn-warning" style="margin-right: 15px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('delete-user', ['firebase_uid' => $user->firebase_uid]) }}"
                                    method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Xóa người dùng này?')">
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