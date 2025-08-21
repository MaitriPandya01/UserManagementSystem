<?php

namespace App\BO;
use Illuminate\Support\Collection;

class UserBO
{
    public function processBeforeCreate(array $data): array
    {
        // Business rules can be applied here
        $data['name'] = ucfirst($data['name']);
        return $data;
    }

    public function processBeforeUpdate(array $data): array
    {
        // You can apply more business logic
        $data['name'] = ucfirst($data['name']);
        return $data;
    }

    public function processAfterGetList(Collection $data): array
    {
        // You can apply more business logic
        $data = $data->map(function ($user) {
        return [
            'id'         => $user->id,
            'name'       => $user->name,
            'email'      => $user->email,
            'created_at' => $user->created_at->format('d-M-Y'), // or any format you want
        ];
        });
        return $data->toArray(); // Add toArray for get data in array form
    }
}
