<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->listUsers();
        return response()->json($users, 200);
    }

    public function show($id)
    {
        $user = $this->userService->getUser($id);
        return response()->json($user, 200);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->createUser($request->validated());
        return response()->json(['message' => 'User added successfully !!!'], 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->userService->updateUser($user, $request->validated());
        return response()->json($user, 200);
    }
}
