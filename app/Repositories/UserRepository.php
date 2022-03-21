<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct((new User()));
    }

    public function customCreate(array $data): Model
    {
        $creationData = [
            'name' => Str::random(10),
            'phone' => Str::random(15),
            'email' => Str::random(30),
            'role_id' => $data['role'],
            'employee_number' => $data['employee_number'],
            'password' => Hash::make($data['password'])
        ];
        return $this->create($creationData);
    }
}
