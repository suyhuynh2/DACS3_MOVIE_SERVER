@extends('layout')
@section('admin_content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('all-movie-ui') }}" class="btn btn-sm btn-secondary shadow-sm mr-3">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
        </a>
        <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa phim</h1>
    </div>
</div>

<div class="card o-hidden border-0 shadow-lg">
    <div class="card-body p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <form method="POST" action="{{ route('update-movie', $movie->movie_id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tên phim</label>
                            <input type="text" name="title" id="title" class="form-control"
                                value="{{ old('title', $movie->title) }}" placeholder="Tên phim" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Mô tả phim</label>
                            <textarea name="description" id="description" class="form-control" rows="5"
                                placeholder="Mô tả phim"
                                required>{{ old('description', $movie->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="actors">Diễn viên</label>
                            <input type="text" name="actors" id="actors" class="form-control"
                                value="{{ old('actors', $movie->actors) }}"
                                placeholder="Diễn viên (cách nhau bởi dấu phẩy)">
                        </div>

                        <div class="form-group">
                            <label for="country">Quốc gia</label>
                            <input type="text" name="country" id="country" class="form-control"
                                value="{{ old('country', $movie->country) }}" placeholder="Quốc gia">
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3">
                                <label for="release_year">Năm phát hành</label>
                                <input type="text" name="release_year" id="release_year" class="form-control"
                                    value="{{ old('release_year', $movie->release_year) }}" placeholder="Năm phát hành">
                            </div>
                            <div class="col-sm-6">
                                <label for="duration">Thời lượng</label>
                                <input type="text" name="duration" id="duration" class="form-control"
                                    value="{{ old('duration', $movie->duration) }}"
                                    placeholder="Thời lượng (ví dụ: 120 phút)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="trailer_url">Link trailer</label>
                            <input type="text" name="trailer_url" id="trailer_url" class="form-control"
                                value="{{ old('trailer_url', $movie->trailer_url) }}"
                                placeholder="Link trailer (trailer_url)">
                        </div>

                        <div class="form-group">
                            <label for="video_url">Link video</label>
                            <input type="text" name="video_url" id="video_url" class="form-control"
                                value="{{ old('video_url', $movie->video_url) }}" placeholder="Link video (video_url)">
                        </div>

                        <div class="form-group">
                            <label for="poster">Chọn ảnh poster:</label>
                            <input type="file" class="form-control" id="poster" name="poster_file" accept="image/*"
                                onchange="previewPoster(event)">
                            <input type="text" id="poster-url" class="form-control mt-2"
                                value="{{ old('poster_url', $movie->poster_url) }}"
                                placeholder="Hoặc dán link hình ảnh từ mạng" onchange="previewPosterUrl()">
                            <input type="hidden" name="poster_url" id="poster-url-hidden"
                                value="{{ old('poster_url', $movie->poster_url) }}">
                            <img id="poster-preview" class="mt-3 d-block mx-auto"
                                src="{{ Str::startsWith($movie->poster_url, ['http://', 'https://']) ? $movie->poster_url : asset($movie->poster_url) }}"
                                style="max-width: 100%; height: auto;">
                        </div>

                        <div class="form-group row">
                            <!-- Thể loại nhiều lựa chọn -->
                            <div class="col-sm-6 mb-3">
                                <label for="genre-select">Thể loại</label>
                                <select id="genre-select" class="form-control">
                                    <option value="">-- Chọn thể loại --</option>
                                    @foreach($genres as $genre)
                                    <option value="{{ $genre->name }}">{{ $genre->name }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="genres" id="genres"
                                    value="{{ old('genres', $movie->genres->pluck('name')->implode(',')) }}">
                                <div id="selected-genres" class="mt-2 d-flex flex-wrap"></div>
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-sm-6">
                                <label for="status">Trạng thái</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="1" @selected($movie->status == 1)>VIP</option>
                                    <option value="0" @selected($movie->status == 0)>FREE</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" style="font-weight: bold;">
                            CẬP NHẬT PHIM
                        </button>
                    </form>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview ảnh và xử lý thể loại -->
<script>
    function previewPoster(event) {
        const input = event.target;
        const reader = new FileReader();
        reader.onload = function () {
            const img = document.getElementById('poster-preview');
            img.src = reader.result;
        }
        if (input.files && input.files[0]) {
            reader.readAsDataURL(input.files[0]);
            // Xóa giá trị link URL nếu người dùng chọn file
            document.getElementById('poster-url').value = '';
            document.getElementById('poster-url-hidden').value = '';
        }
    }

    function previewPosterUrl() {
        const url = document.getElementById('poster-url').value;
        const img = document.getElementById('poster-preview');
        const hiddenInput = document.getElementById('poster-url-hidden');

        if (url) {
            img.src = url;
            hiddenInput.value = url; // Gán giá trị vào hidden input khi dán link
            document.getElementById('poster').value = ''; // Xóa file input nếu dùng link
        } else {
            img.src = '{{ Str::startsWith($movie->poster_url, ['http://', 'https://']) ? $movie->poster_url : asset($movie->poster_url) }}';
            hiddenInput.value = '{{ $movie->poster_url }}';
        }
    }

    // Xử lý chọn nhiều thể loại
    const genreSelect = document.getElementById('genre-select');
    const genreHiddenInput = document.getElementById('genres');
    const selectedGenresContainer = document.getElementById('selected-genres');
    
    // Khởi tạo danh sách thể loại từ dữ liệu phim
    let selectedGenres = @json($movie->genres->pluck('name')->toArray());

    // Cập nhật giao diện khi tải trang
    document.addEventListener('DOMContentLoaded', function () {
        updateGenres();
    });

    genreSelect.addEventListener('change', function () {
        const value = this.value;
        if (value && !selectedGenres.includes(value)) {
            selectedGenres.push(value);
            updateGenres();
        }
        this.value = '';
    });

    function updateGenres() {
        // Cập nhật hidden input
        genreHiddenInput.value = selectedGenres.join(',');

        // Xóa toàn bộ tag cũ trước khi render lại
        selectedGenresContainer.innerHTML = '';

        // Render từng tag thể loại
        selectedGenres.forEach((genre, index) => {
            const tag = document.createElement('span');
            tag.className = 'badge badge-primary m-1 d-flex align-items-center';
            tag.style.cursor = 'default';

            tag.innerHTML = `
                ${genre}
                <button type="button" class="ml-2 btn btn-sm btn-light py-0 px-1" style="font-size: 12px;" onclick="removeGenre(${index})">×</button>
            `;

            selectedGenresContainer.appendChild(tag);
        });
    }

    function removeGenre(index) {
        selectedGenres.splice(index, 1);
        updateGenres();
    }
</script>

@endsection