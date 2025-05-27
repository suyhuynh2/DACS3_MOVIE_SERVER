<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Movie_Repository;
use App\Repositories\Genres_Repository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Events\MovieUpdate;

class Movie_Controller extends Controller
{

    protected $movieRepository;
    protected $genresRepository;

    public function __construct(Movie_Repository $movieRepository, Genres_Repository $genresRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->genresRepository = $genresRepository;
    }

    public function all_movie_ui()
    {
        $movies = $this->movieRepository->all();
        return view('movie.all_movie', compact('movies'));
    }

    public function add_movie_ui()
    {
        $genres = $this->genresRepository->all();
        return view('movie.add_movie', compact('genres'));
    }

    public function save_movie(Request $request)
    {
        $poster_url = null;

        // Kiểm tra nếu có file ảnh được upload từ máy tính
        if ($request->hasFile('poster_file')) {
            $file = $request->file('poster_file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/poster', $file_name);
            $poster_url = 'storage/poster/' . $file_name;
        } elseif ($request->filled('poster_url')) {
            $poster_url = $request->input('poster_url');
        }

        if (!$poster_url) {
            return redirect()->back()->with('error', 'Vui lòng chọn ảnh poster!');
        }

        $data = [];
        $data['title'] = $request->input('title');
        $data['actors'] = $request->input('actors');
        $data['description'] = $request->input('description');
        $data['trailer_url'] = $request->input('trailer_url');
        $data['poster_url'] = $poster_url;
        $data['video_url'] = $request->input('video_url');
        $data['release_year'] = $request->input('release_year');
        $data['duration'] = $request->input('duration');
        $data['country'] = $request->input('country');
        $data['status'] = $request->input('status');

        $movie = $this->movieRepository->create($data);

        // Xử lý thể loại
        $genresNames = array_filter(explode(',', $request->input('genres')), function ($value) {
            return trim($value) !== '';
        });
        $genreIds = [];
        foreach ($genresNames as $genresName) {
            $genre = $this->genresRepository->findByName(trim($genresName));
            if ($genre) {
                $genreIds[] = $genre->genres_id;
            }
        }

        if (!empty($genreIds)) {
            $movie->genres()->attach($genreIds);
        }


        $movie->load(['genres']);

        event(new MovieUpdate($movie, 'create'));

        return redirect()->back()->with('success', 'Thêm phim thành công');
    }

    public function edit_movie_ui($movie_id)
    {
        $movie = $this->movieRepository->findById($movie_id);
        $genres = $this->genresRepository->all();
        return view('movie.edit_movie', compact('movie', 'genres'));
    }

    public function update_movie(Request $request, $movie_id)
    {
        // Tìm phim theo ID
        $movie = $this->movieRepository->findById($movie_id);
        if (!$movie) {
            return redirect()->back()->with('error', 'Phim không tồn tại!');
        }

        $poster_url = $movie->poster_url; // Giữ nguyên poster hiện tại nếu không có thay đổi

        // Xử lý ảnh poster
        if ($request->hasFile('poster_file')) {
            $file = $request->file('poster_file');
            $file_name = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/poster', $file_name);
            $poster_url = 'storage/poster/' . $file_name;
        } elseif ($request->filled('poster_url')) {
            $poster_url = $request->input('poster_url');
        }

        // Kiểm tra nếu không có poster_url
        if (!$poster_url) {
            return redirect()->back()->with('error', 'Vui lòng chọn ảnh poster!');
        }

        // Dữ liệu cập nhật
        $data = [];
        $data['title'] = $request->input('title');
        $data['actors'] = $request->input('actors');
        $data['description'] = $request->input('description');
        $data['trailer_url'] = $request->input('trailer_url');
        $data['poster_url'] = $poster_url;
        $data['video_url'] = $request->input('video_url');
        $data['release_year'] = $request->input('release_year');
        $data['duration'] = $request->input('duration');
        $data['country'] = $request->input('country');
        $data['status'] = $request->input('status');

        // Cập nhật phim qua repository
        $updated = $this->movieRepository->update($movie_id, $data);

        if ($updated) {
            // Xử lý thể loại
            $genresNames = array_filter(explode(',', $request->input('genres')), function ($value) {
                return trim($value) !== '';
            });
            $genreIds = [];
            foreach ($genresNames as $genresName) {
                $genre = $this->genresRepository->findByName(trim($genresName));
                if ($genre) {
                    $genreIds[] = $genre->genres_id;
                }
            }

            // Xóa các thể loại cũ và gắn lại thể loại mới
            $movie->genres()->sync($genreIds);

            event(new MovieUpdate($movie, 'update'));

            return redirect()->route('all-movie-ui')->with('success', 'Cập nhật phim thành công!');
        }

        return redirect()->back()->with('error', 'Cập nhật phim thất bại!');
    }

    public function delete_movie($movie_id)
    {
        $movie = $this->movieRepository->findById($movie_id);
        if ($movie) {
            event(new MovieUpdate($movie, 'delete'));
            $this->movieRepository->delete($movie_id);
            return redirect()->back()->with('success', 'Xóa phim thành công!');
        }

        return redirect()->back()->with('error', 'Phim không tồn tại!');
    }
}
