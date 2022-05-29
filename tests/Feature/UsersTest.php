<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class UsersTest extends TestCase
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
     * Test for get users with studies
     */
    public function test_get_users_with_studies()
    {
        $this->authMethod();
        $studyId = $this->json('GET', 'api/study/1', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])['id'];
        $this->json('GET', "api/study/{$studyId}/users", ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([]);
    }
}
