<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = User::find($id);

        if (!$user) {
            return false;
        }
        return $user->delete();
    }

    public function all()
    {
        return User::all();
    }
}
