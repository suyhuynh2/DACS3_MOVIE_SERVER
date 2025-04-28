<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Genres_Repository;
use App\Events\GenreUpdated;

class Genres_Controller extends Controller
{
    protected $genresRepository;

    public function __construct(Genres_Repository $genresRepository)
    {
        $this->genresRepository = $genresRepository;
    }

    public function all_genres_ui()
    {
        $all_genres = $this->genresRepository->all();
        return view('genres.all_genres', compact('all_genres'));
    }

    public function save_genres(Request $request)
    {
        $data = array();
        $data['name'] = $request->input('name');
        $data['description'] = $request->input('description');

        $genres = $this->genresRepository->create($data);

        event(new GenreUpdated($genres, 'create'));

        return redirect()->back()->with('success', 'Thêm thể loại thành công');
    }

    public function edit_genres($genres_id)
    {
        $genres = $this->genresRepository->findById($genres_id);
        return view('genres.edit_genres', compact('genres'));
    }

    public function update_genres(Request $request, $genres_id)
    {
        $data = array();
        $data['name'] = $request->input('name');
        $data['description'] = $request->input('description');

        $this->genresRepository->update($genres_id, $data);

        $genres = $this->genresRepository->findById($genres_id);

        event(new GenreUpdated($genres, 'update'));

        return redirect()->route('all-genres-ui')->with('success', 'Cập nhật thể loại thành công');
    }

    public function delete_genres($genres_id)
    {
        $genres = $this->genresRepository->findById($genres_id);

        event(new GenreUpdated($genres, 'delete'));

        $this->genresRepository->delete($genres_id);
        return redirect()->back()->with('success', 'Xóa thể loại thành công');
    }
}
