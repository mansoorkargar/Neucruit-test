<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    private $token;

    /**
     * User auth method
     * set Token
     */
    public function authMethod()
    {
        Schema::disableForeignKeyConstraints();
        User::query()->truncate();
        Schema::enableForeignKeyConstraints();
        $user = User::query()->create([
            'id' => 1,
            'name' => 'name',
            'last_name' => 'last name',
            'phone_number' => 5455554,
            'company' => 'company',
            'email' => 'test@gmail.com',
            'info_checked' => 0,
            'remember_token' => '',
            'password' => bcrypt('test@gmail.com'),
        ]);

        $loginData = ['email' => $user->email, 'password' => 'test@gmail.com'];

        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json']);

        $this->token = auth()->user()->createToken('auth_token')->plainTextToken;
    }

    /**
     * Test change password
     */
    public function test_change_password_request()
    {
        $this->authMethod();

        $data = [
            'old_password' => bcrypt('test@gmail.com'),
            'password' => '1111qqqq',
            'password_confirmation' => '1111qqqq',
        ];

        $this->json('POST', 'api/change-password', $data, ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200);
    }

    public function test_if_passwords_not_match()
    {
        $this->authMethod();

        $data = [
            'old_password' => bcrypt('test@gmail.com'),
            'password' => '111111',
            'password_confirmation' => '1111qqqq',
        ];

        $this->json('POST', 'api/change-password', $data, ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
               'errors',
               'message'
            ]);
    }

    public function test_if_ol_password_is_wrong()
    {
        $this->authMethod();

        $data = [
            'old_password' => bcrypt('test@gmail.commm'),
            'password' => '1111qqqq',
            'password_confirmation' => '1111qqqq',
        ];

        $this->json('POST', 'api/change-password', $data, ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message'
            ]);
    }
}
