<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\BO\UserBO;
use App\Models\User;
use Illuminate\Support\Facades\Cache;


class UserService
{
    protected $repository;
    protected $bo;

    public function __construct(UserRepository $repository, UserBO $bo)
    {
        $this->repository = $repository;
        $this->bo = $bo;
    }

    public function createUser(array $data): User
    {
        Cache::forget('users.all');
        $processed = $this->bo->processBeforeCreate($data);
        return $this->repository->create($processed);
    }

    public function updateUser(User $user, array $data): bool
    {
        Cache::forget('users.all');
        $processed = $this->bo->processBeforeUpdate($data);
        return $this->repository->update($user, $processed);
    }

    public function deleteUser(int $id): ?bool
    {
        Cache::forget('users.all');
        return $this->repository->delete($id);
    }

    public function getUser(int $id): ?User
    {
        return $this->repository->find($id);
    }

    public function listUsers()
    {
        
        return Cache::remember('users.all', 60, function () {
        
            $data = $this->repository->all();
            $processed = $this->bo->processAfterGetList($data);
            return $processed;
        });
    }
}

?>