<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Users_Repository;

class Users_API extends Controller
{

    protected $usersRepository;

    public function __construct(Users_Repository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function createUser(Request $request)
    {

        try {

            $data = $request->all();
            $existUser = $this->usersRepository->findById($data['firebase_uid']);

            if ($existUser) {
                return response()->json([
                    'firebase_uid' => $existUser->firebase_uid,
                    'name' => $existUser->name,
                    'email' => $existUser->email,
                    'provider' => $existUser->provider,
                    'role' => $existUser->role,
                ], 200);
            }

            $data['role'] = 'FREE';

            $user = $this->usersRepository->create($data);
            return response()->json([
                'firebase_uid' => $user->firebase_uid,
                'name' => $user->name,
                'email' => $user->email,
                'provider' => $user->provider,
                'role' => $user->role,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
