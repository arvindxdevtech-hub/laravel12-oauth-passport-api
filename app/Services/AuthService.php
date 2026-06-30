<?php

namespace App\Services;

use App\Interfaces\AuthRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthService
{
  protected AuthRepositoryInterface $authRepository;

  public function __construct(AuthRepositoryInterface $authRepository)
  {
    $this->authRepository = $authRepository;
  }

  public function register(array $data): array
  {
    // Hash Password
    $data['password'] = Hash::make($data['password']);

    // Create User
    $user = $this->authRepository->createUser($data);

    $user_info = [
      'id'    => $user->id,
      'name'  => $user->name,
      'email' => $user->email,
    ];

    // Generate Passport Token
    $token = $user->createToken('auth-api')->accessToken;

    return [
      'user' => $user_info,
      'token' => $token,
    ];
  }

  public function login(array $data): array
  {
    // Step 1 - Find User
    $user = $this->authRepository->findUserByEmail($data['email']);

    // Step 2 - Check User & Password
    // Dhyan dena ki Hash::check($plainPassword, $hashedPassword) me pehla argument plain password aur dusra hashed password hota hai.
    if (!$user || !Hash::check($data['password'], $user->password)) {
      throw ValidationException::withMessages([
        'email' => ['Invalid email or password.'],
      ]);
    }

    // Step 3 - Generate New Token
    $token = $user->createToken('auth-api')->accessToken;

    $user_info = [
      'id'    => $user->id,
      'name'  => $user->name,
      'email' => $user->email,
    ];

    // Step 4 - Return Response
    return [
      'user' => $user_info,
      'token' => $token,
    ];
  }

  public function logout(Request $request): void
  {
    $request->user()->token()->revoke();
  }
}
