<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /***********************************************************************
     * Test Case 1
     *
     * Function:
     * test_user_can_register()
     *
     * Purpose:
     * Check whether a new user can register successfully.
     *
     * API:
     * POST /api/register
     *
     * Input:
     * {
     *   "name":"Arvind",
     *   "email":"arvind@gmail.com",
     *   "password":"12345678",
     *   "password_confirmation":"12345678"
     * }
     *
     * PASS:
     * HTTP Status : 201
     * User inserted into database
     * JWT Token returned
     *
     * FAIL:
     * Status != 201
     * Validation Error
     ***********************************************************************/
    public function test_user_can_register()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Arvind',
            'email' => 'arvindTest@gmail.com',
            'password' => '12345678',
            'password_confirmation' => '12345678',
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user',
                'token'
            ]
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'arvindTest@gmail.com'
        ]);
    }

    /***********************************************************************
     * Test Case 2
     *
     * Function:
     * test_user_can_login()
     *
     * Purpose:
     * Verify existing user can login.
     *
     * API:
     * POST /api/login
     *
     * Input:
     * email
     * password
     *
     * PASS:
     * HTTP 200
     * Access Token Generated
     *
     * FAIL:
     * Wrong Password
     * User Not Found
     ***********************************************************************/
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345678')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '12345678',
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user',
                'token'
            ]
        ]);
    }

    /***********************************************************************
     * Test Case 3
     *
     * Function:
     * test_user_cannot_login_with_wrong_password()
     *
     * Purpose:
     * Verify login should fail with wrong password.
     *
     * API:
     * POST /api/login
     *
     * PASS:
     * HTTP 422
     * Invalid email or password
     *
     * FAIL:
     * User gets logged in.
     ***********************************************************************/
    public function test_user_cannot_login_with_wrong_password()
    {
        $user = User::factory()->create([
            'password' => bcrypt('12345678')
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(422);
    }

    /***********************************************************************
     * Test Case 4
     *
     * Function:
     * test_user_can_view_profile()
     *
     * Purpose:
     * Verify authenticated user can access profile.
     *
     * API:
     * GET /api/profile
     *
     * PASS:
     * HTTP 200
     * User data returned
     *
     * FAIL:
     * HTTP 401
     ***********************************************************************/
    public function test_user_can_view_profile()
    {
        $user = User::factory()->create();

        $token = $user->createToken('auth-api')->accessToken;

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ])
            ->getJson('/api/profile');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'success',
            'data'
        ]);
    }

    /***********************************************************************
     * Test Case 5
     *
     * Function:
     * test_guest_cannot_view_profile()
     *
     * Purpose:
     * Verify profile API cannot be accessed without token.
     *
     * API:
     * GET /api/profile
     *
     * PASS:
     * HTTP 401 Unauthorized
     *
     * FAIL:
     * Profile data visible.
     ***********************************************************************/
    public function test_guest_cannot_view_profile()
    {
        $response = $this->getJson('/api/profile');

        $response->assertStatus(401);
    }

    /***********************************************************************
     * Test Case 6
     *
     * Function:
     * test_user_can_logout()
     *
     * Purpose:
     * Verify authenticated user can logout.
     *
     * API:
     * POST /api/logout
     *
     * PASS:
     * HTTP 200
     * Token Revoked
     *
     * FAIL:
     * HTTP 401
     ***********************************************************************/
    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('auth-api')->accessToken;

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json'
            ])
            ->postJson('/api/logout');

        $response->assertStatus(200);
    }

    /***********************************************************************
     * Test Case 7
     *
     * Function:
     * test_user_cannot_access_profile_after_logout()
     *
     * Purpose:
     * Verify revoked token cannot access protected APIs.
     *
     * Flow:
     * Login
     * ↓
     * Logout
     * ↓
     * Profile
     *
     * PASS:
     * HTTP 401
     *
     * FAIL:
     * HTTP 200
     ***********************************************************************/
    public function test_user_cannot_access_profile_after_logout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('auth-api')->accessToken;

        $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ])->postJson('/api/logout');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json'
        ])->getJson('/api/profile');

        $response->assertStatus(401);
    }
}
