<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StudiesTest extends TestCase
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
     * Test for get studies
     */
    public function test_get_studies()
    {
        $this->authMethod();
        $this->json('GET', 'api/studies', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([]);
    }

    /**
     * Test for get study by id
     */
    public function test_get_study_by_id()
    {
        $this->authMethod();
        $this->json('GET', 'api/study/1', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([]);
    }
}
