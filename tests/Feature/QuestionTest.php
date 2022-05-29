<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class QuestionTest extends TestCase
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
        $user = User::factory()->create([
            'name' => 'name',
            'email' => 'test@gmail.com',
            'password' => bcrypt('test@gmail.com'),
        ]);

        $loginData = ['email' => $user->email, 'password' => 'test@gmail.com'];

        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json']);

        $this->token = auth()->user()->createToken('auth_token')->plainTextToken;
    }

    /**
     * Test for all fields
     */
    public function test_must_enter_all_fields()
    {
        $this->authMethod();
        $this->json('POST','api/question', ['Authorization '=> 'Bearer' . $this->token, 'Accept' =>'application/json'])

            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'recruiting' => ["The recruiting field is required."],
                    'studyQuestion' => ["The study question field is required."],
                    'studyDescription' => ["The study description field is required."],
                    'studyLink' => ["The study link field is required."],
                    'studyMinutes' => ["The study minutes field is required."],
                    'studyStart' => ["The study start field is required."],
                    'studyEnd' => ["The study end field is required."],
                    'participants' => ["The participants field is required."],
                    'lookingFor' => ["The looking for field is required."],
                    'studyPart' => ["The study part field is required."],
                    'questions' => ["The questions field is required."]
                ]
            ]);

    }

    /**
     * Test for save form
     */
    public function test_successful_save_form()
    {
        $this->authMethod();

        Schema::disableForeignKeyConstraints();
        Question::query()->delete();
        Schema::enableForeignKeyConstraints();

        $question = [
            'question' => 'Example of a text question',
            'type_id' => '1',
            'options' => 'Option 1;Option 2;Option 3',
            'is_required' => 1,
        ];

        $this->json('POST','api/question', $question, ['Authorization '=> 'Bearer' . $this->token, 'Accept' =>'application/json'])
            ->assertJsonStructure([]);
    }
}
