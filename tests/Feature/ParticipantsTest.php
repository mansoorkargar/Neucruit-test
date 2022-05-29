<?php

namespace Tests\Feature;

use App\Models\Gender;
use App\Models\Participant;
use App\Models\Participants;
use App\Models\Statuses;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ParticipantsTest extends TestCase
{
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
     * Test for get participants
     */
    public function test_get_participants()
    {
        $this->authMethod();
        Schema::disableForeignKeyConstraints();
        Participant::query()->truncate();
        Statuses::query()->truncate();
        Gender::query()->truncate();
        Schema::enableForeignKeyConstraints();

        $studyId = $this->json('GET', 'api/study/1', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])['id'];

        $this->json('GET', "api/study/{$studyId}/participants", ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([]);
    }

    /**
     * Test for get participants statuses
     */
    public function test_get_participants_statuses()
    {
        $this->authMethod();
        Schema::disableForeignKeyConstraints();
        Statuses::query()->truncate();
        Schema::enableForeignKeyConstraints();

        Statuses::query()->create([
            'name' => 'name',
            'slug' => 'slug'
        ]);

        $this->json('GET', 'api/participants-statuses', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    0 => [
                        'created_at',
                        'deleted_at',
                        'id',
                        'name',
                        'slug',
                        'updated_at'
                    ]
                ]
            ]);
    }

    /**
     * Test for get participants gender
     */
    public function test_get_participants_gender()
    {
        $this->authMethod();
        Schema::disableForeignKeyConstraints();
        Gender::query()->truncate();
        Schema::enableForeignKeyConstraints();

        Gender::query()->create([
            'name' => 'name',
            'slug' => 'slug'
        ]);

        $this->json('GET', 'api/participants-gender', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    0 => [
                        'created_at',
                        'deleted_at',
                        'id',
                        'name',
                        'slug',
                        'updated_at'
                    ]
                ]
            ]);
    }

    /**
     * Test for get participants fields
     */
    public function test_get_participants_fields()
    {
        $this->authMethod();
        Schema::disableForeignKeyConstraints();
        Participant::query()->truncate();
        Statuses::query()->truncate();
        Gender::query()->truncate();
        Schema::enableForeignKeyConstraints();

        $this->json('GET', 'api/participants-filters', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'ages',
                    'ethnicities'
                ]
            ]);
    }

    /**
     * Test for get participants fields
     */
    public function test_get_participants_filtered_list()
    {
        $this->authMethod();
        Schema::disableForeignKeyConstraints();
        Participant::query()->truncate();
        Statuses::query()->truncate();
        Gender::query()->truncate();
        Schema::enableForeignKeyConstraints();

        $allFilters = [
            'filters' =>
                ['filters' =>
                    [
                        'age' => 22,
                        'status' => null,
                        'ethnicity' => null,
                        'gender' => 22,
                    ]
                ]
        ];

        $this->json('POST', 'api/participants-filter', $allFilters, ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);
    }
}
