<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Users_Repository;
use App\Http\Controllers\Controller;

class Users_Controller extends Controller
{
    protected $usersRepository;

    public function __construct(Users_Repository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function all_users_ui()
    {
        $users = $this->usersRepository->all();
        return view('user.all_user', compact('users'));
    }
    public function save_user(Request $request)
    {
        $data = [];
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['password'] = bcrypt($request->input('password'));
        $data['role'] = $request->input('role');

        $this->usersRepository->create($data);

        return redirect()->back()->with('success', 'Thêm người dùng thành công');
    }
    public function edit_user_ui($firebase_uid)
    {
        $user = $this->usersRepository->findById($firebase_uid);
        return view('user.edit_user', compact('user'));
    }

    public function update_user(Request $request, $firebase_uid)
    {
        $data = [];
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['role'] = $request->input('role');
        $data['provider'] = $request->input('provider');

        $this->usersRepository->update($firebase_uid, $data);

        return redirect()->route('all-users-ui')->with('success', 'Cập nhật người dùng thành công');
    }

    public function delete_user($firebase_uid)
    {
        $this->usersRepository->delete($firebase_uid);
        return redirect()->back()->with('success', 'Xóa người dùng thành công');
    }
}
