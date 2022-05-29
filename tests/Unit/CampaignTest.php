<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CampaignTest extends TestCase
{
    private $token;
    private $campaign;

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
     * Test for getting resources without authorization.
     *
     * @return void
     */
    public function test_get_campaigns_without_authorization()
    {
        $response = $this->getJson('/api/campaigns');
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    /**
     * Test to create a new resource without authorization.
     *
     * @return void
     */
    public function test_create_campaign_without_authorization()
    {
        $response = $this->postJson('/api/campaigns', Campaign::factory()->make()->toArray());
        $response->assertStatus(401);
        $response->assertJson(['message' => "Unauthenticated."]);
    }

    /**
     * Test for getting resources by authenticated users.
     *
     * @return void
     */
    public function test_get_campaigns_with_authorization()
    {
        $this->authMethod();

        $response = $this->getJson('/api/campaigns')->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'campaign_type_id',
                    'end_date',
                    'start_date',
                    'status',
                    'type'
                ]
            ]
        ]);
    }

    /**
     * Test to create a new resource by authenticated users.
     *
     * @return void
     */
    public function test_create_campaign_with_authorization()
    {
        $this->authMethod();

        $studyId = $this->json('GET', 'api/study/1', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])['id'];
        $requestData = Campaign::factory()->make()->toArray();
        $this->campaign = $this->json('POST',"/api/study/{$studyId}/campaigns", $requestData, ['Authorization '=> 'Bearer' . $this->token, 'Accept' =>'application/json'])
            ->assertJsonStructure([]);
    }

}
