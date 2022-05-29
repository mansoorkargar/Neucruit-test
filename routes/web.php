<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/landing-page/{id}/{campaign?}', function () {
    $design = \App\Models\Design::whereStudyId(request()->route('id'))->orderBy('updated_at', 'DESC')->firstOrFail();

    $sessionId = session()->getId();
    $campaign  = $design->study->campaigns()->whereSlug(request()->route('campaign'))->first();
    $design->study->analytics()->firstOrCreate(['session_id' => $sessionId, 'channel_id' => $campaign->id ?? null, 'action' => 'view']);

    $questions     = $design->study->study_questions()->get();
    $questionsData = [];
    $questionsPage = 0;
    foreach ($questions as $question) {
        if (!isset($questionsData[$questionsPage])) {
            $questionsData[$questionsPage] = [];
        }

        if ($question->type == 'SEPARATOR') {
            if (count($questionsData[$questionsPage]) > 0) {
                $questionsPage++;
            }
        } else {
            $questionsData[$questionsPage][] = [
                'id'         => $question->id,
                'name'       => $question->name,
                'options'    => explode(';', $question->options),
                'type'       => $question->type,
                'required'   => $question->is_required,
                'ineligible' => explode(';', $question->ineligible_options),
            ];
        }
    }

    $isStarted = false;
    $isEnded   = false;
    if ($design->study->recruitment_starts_at) {
        if ($design->study->recruitment_starts_at->timestamp < now()->timestamp) {
            $isStarted = true;
        }
    }
    
    if ($design->study->recruitment_ends_at) {
        if ($design->study->recruitment_ends_at->timestamp < now()->timestamp) {
            $isEnded = true;
        }
    }

    echo str_replace(
        '</title>',
        '</title>
         <style>'.$design->css.'</style>
         <script>
            window.__neucruitSurveyStudyId='.$design->study_id.';
            window.__neucruitSurveyCampaignId='.($campaign->id ?? 'null').';
            window.__neucruitSurveySessionId="'.$sessionId.'";
            window.__neucruitSurveyStarted='. ($isStarted ? 'true' : 'false') .';
            window.__neucruitSurveyCompleted='. ($isEnded ? 'true' : 'false') .';
            window.__neucruitSurveyQuestions='.json_encode($questionsData).';
         </script>
         <script src="/js/embed/embed.js"></script>',
        $design->html
    );
    die();
});

Route::any('/{path?}', function () {
    return view('layouts.app');
})->where('path', '^((?!(nova|api|storage|debug-sentry)).)*$')->middleware('isSuperUserWeb');
