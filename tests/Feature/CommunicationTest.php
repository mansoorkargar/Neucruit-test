<?php

namespace Tests\Feature;

use App\Models\Communication;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CommunicationTest extends TestCase
{

    private $token;
    private $communication;


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
     * Test for get communications
     */
    public function test_get_communications()
    {
        $this->authMethod();
        $studyId = $this->json('GET', 'api/study/1', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])['id'];
        $this->json('GET', "api/study/{$studyId}/communications", ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([]);
    }

    /**
     * Test get communication by id
     */
    public function test_get_communication_by_id()
    {
        $this->authMethod();
        Schema::disableForeignKeyConstraints();
        Communication::query()->delete();
        Schema::enableForeignKeyConstraints();

        $studyId = $this->json('GET', 'api/study/1', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])['id'];
        $communication = Communication::query()->create([
            'study_id' => $studyId,
            'template_name' => 'template_name',
            'email_subject' => 'email_subject',
            'file' => '',
            'enabled' => 1,
            'content' => 'content',
            'communication_trigger_id' => 1,
        ]);

        $this->json('GET', "api/study/{$studyId}/communications/{$communication['id']}", ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([]);
    }

    /**
     * Test for update form
     */
    public function test_successful_update_communication()
    {
        $this->authMethod();
        Schema::disableForeignKeyConstraints();
        Communication::query()->delete();
        Schema::enableForeignKeyConstraints();

        $studyId = $this->json('GET', 'api/study/1', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])['id'];
        $communication = [
            'id' => 1,
            'template_name' => 'template name',
            'email_subject' => 'email subject',
            'enabled' => 0,
            'content' => '<p>test!!</p>',
            'file' => UploadedFile::fake()->image('file.png', 600, 600)
        ];

        $this->communication = $this->json('POST',"api/study/{$studyId}/communications/{$communication['id']}", $communication, ['Authorization '=> 'Bearer' . $this->token, 'Accept' =>'application/json'])
            ->assertJsonStructure([]);
    }

    /**
     * Test for update column
     */
    public function test_successful_update_communication_column()
    {
        $this->authMethod();
        Schema::disableForeignKeyConstraints();
        Communication::query()->delete();
        Schema::enableForeignKeyConstraints();

        $studyId = $this->json('GET', 'api/study/1', ['Authorization ' => 'Bearer' . $this->token, 'Accept' => 'application/json'])['id'];
        $communication = [
            'id' => 1,
            'enabled' => 0,
        ];

        $this->communication = $this->json('POST',"api/study/{$studyId}/communications/{$communication['id']}", $communication, ['Authorization '=> 'Bearer' . $this->token, 'Accept' =>'application/json'])
            ->assertJsonStructure([]);
    }
}
