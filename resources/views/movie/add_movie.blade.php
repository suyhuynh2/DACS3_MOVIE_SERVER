@extends('layout')
@section('admin_content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div class="d-flex align-items-center">
        <a href="{{ route('all-movie-ui') }}" class="btn btn-sm btn-secondary shadow-sm mr-3">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
        </a>
        <h1 class="h3 mb-0 text-gray-800">Thêm phim</h1>
    </div>
</div>

<div class="card o-hidden border-0 shadow-lg">
    <div class="card-body p-0">
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <form method="POST" action="{{ route('save-movie') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <input type="text" name="title" class="form-control" placeholder="Tên phim" required>
                        </div>

                        <div class="form-group">
                            <textarea name="description" class="form-control" rows="5" placeholder="Mô tả phim"
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <input type="text" name="actors" class="form-control"
                                placeholder="Diễn viên (cách nhau bởi dấu phẩy)">
                        </div>

                        <div class="form-group">
                            <input type="text" name="country" class="form-control" placeholder="Quốc gia">
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3">
                                <input type="text" name="release_year" class="form-control" placeholder="Năm phát hành">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="duration" class="form-control"
                                    placeholder="Thời lượng (ví dụ: 120 phút)">
                            </div>
                        </div>

                        <div class="form-group">
                            <input type="text" name="trailer_url" class="form-control"
                                placeholder="Link trailer (trailer_url)">
                        </div>

                        <div class="form-group">
                            <input type="text" name="video_url" class="form-control"
                                placeholder="Link video (video_url)">
                        </div>

                        <div class="form-group">
                            <label for="poster">Chọn ảnh poster:</label>
                            <input type="file" class="form-control" id="poster" name="poster_file" accept="image/*"
                                onchange="previewPoster(event)">

                            <input type="text" id="poster-url" class="form-control mt-2"
                                placeholder="Hoặc dán link hình ảnh từ mạng" onchange="previewPosterUrl()">

                            <input type="hidden" name="poster_url" id="poster-url-hidden">

                            <img id="poster-preview" class="mt-3 d-block mx-auto"
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
                                <input type="hidden" name="genres" id="genres">
                                <div id="selected-genres" class="mt-2 d-flex flex-wrap"></div>
                            </div>

                            <!-- Trạng thái -->
                            <div class="col-sm-6">
                                <label for="status">Trạng thái</label>
                                <select name="status" class="form-control" id="status">
                                    <option value="">-- Chọn trạng thái --</option>
                                    <option value="1">VIP</option>
                                    <option value="0">FREE</option>
                                </select>
                            </div>
                        </div>


                        <button type="submit" class="btn btn-primary btn-block" style="font-weight: bold;">
                            THÊM PHIM
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
            hiddenInput.value = url;
            document.getElementById('poster').value = '';
        } else {
            img.src = '';
            hiddenInput.value = '';
        }
    }

    // Xử lý chọn nhiều thể loại
    const genreSelect = document.getElementById('genre-select');
    const genreHiddenInput = document.getElementById('genres');
    const selectedGenresContainer = document.getElementById('selected-genres');

    let selectedGenres = [];

    genreSelect.addEventListener('change', function () {
        const value = this.value.trim();
        if (value && !selectedGenres.includes(value)) {
            selectedGenres.push(value);
            updateGenres();
        }
        this.value = '';
    });

    function updateGenres() {
        // Lọc bỏ giá trị rỗng và cập nhật hidden input
        selectedGenres = selectedGenres.filter(genre => genre);
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