<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;

class AuthRepository implements AuthRepositoryInterface
{
  public function createUser(array $data)
  {
    return User::create($data);
  }

  public function findUserByEmail(string $email): User
  {
    return User::where('email', $email)->firstOrFail();
  }
}
