<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\StudyController;
use App\Http\Controllers\MakeDesignController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\StudyUsersController;
use App\Http\Controllers\API\ParticipantsController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\StudyCampaignsController;
use App\Http\Controllers\API\StudyInvitationsController;
use App\Http\Controllers\API\StudyParticipantsController;
use App\Http\Controllers\API\StudyCommunicationsController;
use App\Http\Controllers\API\ChangePasswordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/register-invited', [AuthController::class, 'registerInvitedUser']);
Route::post('/auth/get-register-invited', [AuthController::class, 'getInvitedUser']);
Route::post('/auth/forget-password', [ResetPasswordController::class, 'forgetPasswordLink']);
Route::post('/auth/reset-password', [ResetPasswordController::class, 'resetPassword']);
Route::post('/question', [QuestionController::class, 'store']);
Route::get('/get-question-list', [QuestionController::class, 'list']);
Route::get('/get-question-types', [QuestionController::class, 'listOfTypes']);
Route::post('/answers', [QuestionController::class, 'storeAnswers']);

Route::middleware(['auth:sanctum', 'isSuperUser'])->group(function () {

    // Skip study check middlware
    Route::group([], function () {
        Route::get('/me', [ProfileController::class, 'index']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);
    });

    Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);

    /* Studies */
    Route::get('/studies', [StudyController::class, 'list']);
    Route::get('/study/{study}', [StudyController::class, 'show']);

    /* Invitations */
    Route::get('/study/{study}/invitations', [StudyInvitationsController::class, 'index']);
    Route::post('/study/{study}/invitations', [StudyInvitationsController::class, 'invite']);
    Route::post('/study/{study}/invitations/{invitation}/resend', [StudyInvitationsController::class, 'resend']);
    Route::delete('/study/{study}/invitations/{invitation}', [StudyInvitationsController::class, 'destroy']);

    /* Users */
    Route::get('/study/{study}/users', [StudyUsersController::class, 'index']);
    Route::delete('/study/{study}/users/{user}', [StudyUsersController::class, 'destroy']);

    /* Participants */
    Route::get('/study/{study}/participants', [StudyParticipantsController::class, 'list']);
    Route::get('/study/{study}/participants/export', [StudyParticipantsController::class, 'export']);
    Route::get('/study/{study}/all-participants', [StudyParticipantsController::class, 'allParticipantList']);
    Route::get('/study/{study}/participants/status', [StudyParticipantsController::class, 'listWithStatus']);
    Route::get('/study/{study}/participants-countries', [StudyParticipantsController::class, 'participantsCountries']);
    Route::post('/study/{study}/participants/status/{participant:id}', [StudyParticipantsController::class, 'changeParticipantStatus']);

    Route::get('/participant/{participant_id}', [ParticipantsController::class, 'show']);

    Route::get('/participants-statuses', [ParticipantsController::class, 'statusList']);
    Route::get('/participants-filters', [ParticipantsController::class, 'filterFields']);
    Route::get('/participants-gender', [ParticipantsController::class, 'genderList']);

    Route::post('/participants-filter', [ParticipantsController::class, 'filteredList']);
    Route::post('/all-participants-filter', [ParticipantsController::class, 'filteredAllList']);

    Route::get('/participant-emails/{participant_id}', [ParticipantsController::class, 'showParticipantEmails']);

    /* Communications */
    Route::get('/study/{study}/communications', [StudyCommunicationsController::class, 'index']);
    Route::get('/study/{study}/communications/{communication:id}', [StudyCommunicationsController::class, 'show']);
    Route::post('/study/{study}/communications/{communication:id}', [StudyCommunicationsController::class, 'update']);
    Route::put('/study/{study}/communications/{communication:id}', [StudyCommunicationsController::class, 'updateColumn']);

    /* Campaigns */
    Route::get('/study/{study}/campaigns', [StudyCampaignsController::class, 'index']);

    /* Design */
    Route::get('/make-design/{id}', [MakeDesignController::class, 'showByStudy']);
    Route::get('/get-design/{id}', [MakeDesignController::class, 'show']);
    Route::post('/make-design', [MakeDesignController::class, 'store']);
});

/* Embed participants */
Route::post('/study/{nonAuthStudy}/participants', [StudyParticipantsController::class, 'store']);
