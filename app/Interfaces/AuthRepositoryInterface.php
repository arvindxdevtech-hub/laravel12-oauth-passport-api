<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{
  public function createUser(array $data);

  public function findUserByEmail(string $email): User;
}
