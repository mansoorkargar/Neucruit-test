<?php

declare (strict_types = 1);

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * LoginTest class
 */
class LoginTest extends TestCase
{
    /**
     * Faker User object for using in test cases
     *
     * @property static $user
     */
    protected static $user;

    /**
     * Faker User Password
     *
     * @property static $password
     */
    protected static $password;

    /**
     * Auth token for cases required authentication
     *
     * @property static $token
     */
    protected static $token;

    public function setUp(): void
    {
        parent::setUp();
        if (!self::$user) {
            self::$password = Str::random();
            self::$user = User::factory()->create([
                'password' => Hash::make(self::$password),
            ]);
        }
    }

    /**
     * Test Lgoin
     *
     * Case with valid credentials
     *
     * @return void
     */
    public function test_login_valid_email_and_password(): void
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => self::$user->email,
            'password' => self::$password,
        ])->assertOk();

        $data = $response->json();
        self::$token = $data['token'];

        $this->assertArrayHasKey('token', $data);
        $this->assertArrayHasKey('user', $data);
        $this->assertEquals($data['user'], self::$user->toArray());
    }

    /**
     * Test Logout
     *
     * Case logout with valid auth token
     *
     * @return void
     */
    public function test_logout_with_valid_token()
    {
        $response = $this->postJson('/api/auth/logout', [
            'email' => self::$user->email,
            'password' => self::$password,
        ], [
            'Authorization' => 'Bearer ' . self::$token,
        ]);

        $response->assertStatus(204);
    }

    /**
     * Test Logout
     *
     * Case logout with invalid token.
     * Invalid token is the token that already used for logout
     *
     * @return void
     */
    public function test_logout_with_invalid_token()
    {
        $response = $this->postJson('/api/auth/logout', [
            'email' => self::$user->email,
            'password' => self::$password,
        ], [
            'Authorization' => 'Bearer ' . self::$token,
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test Lgoin
     *
     * Case with valid credentials
     *
     * @return void
     */
    public function test_login_valid_email_incorrect_password()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => self::$user->email,
            'password' => 'random',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test Lgoin
     *
     * Case with incorrect email format
     *
     * @return void
     */
    public function test_login_invalid_email()
    {
        $email = 'random'; // invalid email format
        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => 'random',
        ]);

        $response->assertStatus(422);
        $data = $response->json();

        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('email', $data['errors']);
    }

    /**
     * Test Lgoin
     *
     * Case with empty email format
     *
     * @return void
     */
    public function test_login_empty_email()
    {
        $email = ''; // empty
        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => 'random',
        ]);

        $response->assertStatus(422);
        $data = $response->json();

        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('email', $data['errors']);
    }

    /**
     * Test Lgoin
     *
     * Case with empty password
     *
     * @return void
     */
    public function test_login_empty_password()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => self::$user->email,
            'password' => '',
        ]);

        $response->assertStatus(422);
        $data = $response->json();

        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('password', $data['errors']);
    }
}
