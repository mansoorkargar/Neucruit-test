<?php

namespace Tests\Feature;

use App\Models\Advocates;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class AdvocatesTest extends TestCase
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
     * Test for get advocates
     */
    public function test_get_advocates()
    {
        $this->authMethod();
        $this->json('GET', 'api/advocates', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    'success',
                    'data',
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]);
    }

    /**
     * Test for get advocates with query param
     */
    public function test_get_advocates_with_query_param()
    {
        $this->authMethod();

        Schema::disableForeignKeyConstraints();
        Advocates::query()->truncate();
        Schema::enableForeignKeyConstraints();

        Advocates::query()->create([
            'name' => 'test',
            'specialty' => 1,
            'study_id' => 1,
            'status' => '',
            'role' => '',
            'country' => '',
            'state' => '',
            'city' => '',
            'contact_number' => '',
            'email' => 'mail@mail.ru',
            'board_certification' => '',
            'board' => '',
            'handle' => '',
            'reach' => '',
            'image_reference' => '',
            'notes' => '',
        ]);


        $this->json('GET', 'api/advocates?search=tes', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data' => [
                    'success',
                    'data',
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]);
    }
}
