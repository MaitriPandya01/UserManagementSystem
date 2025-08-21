<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\Models\User;


class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('users.index');
    }

    public function list(Request $request)
    {
        $users = $this->service->listUsers();

        // if($users)
            return response()->json(['success' => true, 'data' => $users]);
        // else
        //     return response()->json(['success' => false]);
    }

    public function store(StoreUserRequest $request)
    {
        // dd($request);
        $this->service->createUser($request->validated());
        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function delete($id)
    {
        $this->service->deleteUser((int)$id);
        return response()->json(['success' => true,'message' => 'Row deleted successfully !!!']);
    }

    public function update($id)
    {
        // dd($id);
        $data = $this->service->getUser($id);
        return view('users.create', compact('data'));
    }

    public function edit(UpdateUserRequest $request, User $user)
    {
        $this->service->updateUser($user, $request->validated());
        return response()->json([
            'success' => true,
            'redirect' => route('users.index'), // Laravel route
        ]);
    }
            
}
