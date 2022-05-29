<?php


namespace App\Services;

use Exception;
use App\Models\User;
use App\Models\Answer;
use App\Enums\RoleEnum;
use Illuminate\Http\Request;
use App\Mail\RegisterNoticeMail;

use App\Models\SignUpQuestionType;
use Illuminate\Support\Facades\Mail;
use App\Models\Question;use App\Models\SignUpQuestion;
use App\Classes\Contracts\Services\QuestionService as RegistrationServiceContract;

class QuestionService implements RegistrationServiceContract
{
    /**
     * @return array
     */
    public function list(): array
    {
        try {
            return [
                'success' => true,
                'data' => SignUpQuestion::query()->with('type')->get()
            ];
        } catch (Exception $exception) {
            return [
                'success' => false,
                'data' => $exception
            ];
        }
    }

    /**
     * @return array
     */
    public function listOfTypes(): array
    {
        try {
            return [
                'success' => true,
                'data' => SignUpQuestionType::query()->get()
            ];
        } catch (Exception $exception) {
            return [
                'success' => false,
                'data' => $exception
            ];
        }
    }

    public function storeAnswers(Request $request): array
    {
        try {
            $token = $request->token ?? null;
            if (!$token) {
                return [
                    'success' => false
                ];
            }

            $user = User::whereToken($token)->firstOrFail();

            foreach ($request->all() as $req) {
                if (is_array($req)) {
                    Answer::query()->firstOrCreate([
                        'user_id' => $user->id,
                        'question_id' => $req['question_id']
                    ])->update([
                        'answer' => $req['answer'],
                    ]);
                }
            }

            /* Send notificaiton */
            $users = User::whereRoleId(RoleEnum::SUPERUSER)->get();
            foreach ($users as $user) {
                Mail::to($user)->send(new RegisterNoticeMail($user));
            } 

            return [
                'success' => true
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * @inheritDoc
     */
    public function store(array $data, User $user): Question
    {
        return $user->questions()->create([
            'recruiting'        => $data['recruiting'],
            'study_question'    => $data['studyQuestion'],
            'study_description' => $data['studyDescription'],
            'copy_paste'        => $data['copyPaste'],
            'study_link'        => $data['studyLink'],
            'study_minutes'     => $data['studyMinutes'],
            'study_start'       => $data['studyStart'],
            'study_end'         => $data['studyEnd'],
            'participants'      => $data['participants'],
            'looking_for'       => $data['lookingFor'],
            'study_part'        => $data['studyPart'],
            'notes'             => $data['notes'],
            'questions'         => $data['questions'],
        ]);
    }
}
