@extends('layout')
@section('admin_content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('all-genres-ui') }}" class="btn btn-sm btn-secondary shadow-sm mr-3">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
        </a>
        <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa thể loại</h1>
    </div>
</div>

<div class="card o-hidden border-0 shadow-lg">
    <div class="card-body p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <form method="POST" action="{{ route('update-genres', $genres->genres_id) }}">
                        @csrf
                        <div class="form-group row">
                            <div class="form-group col-sm-6 mb-3">
                                <input type="text" name="name" class="form-control" placeholder="Tên thể loại"
                                    value="{{ $genres->name }}" required>
                            </div>

                            <div class="form-group col-sm-6 mb-3">
                                <input type="text" name="description" class="form-control" placeholder="Mô tả"
                                    value="{{ $genres->description }}" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" style="font-weight: bold;">
                            CẬP NHẬT
                        </button>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection