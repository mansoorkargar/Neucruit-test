<?php

namespace App\Providers;

use App\Models\Study;
use App\Models\Answer;
use App\Models\StudyUser;
use App\Models\Invitation;
use App\Models\Participant;
use App\Observers\StudyObserver;
use App\Observers\AnswerObserver;
use App\Observers\StudyUserObserver;
use App\Observers\InvitationObserver;
use App\Observers\ParticipantObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Study::observe(StudyObserver::class);
        Answer::observe(AnswerObserver::class);
        StudyUser::observe(StudyUserObserver::class);
        Invitation::observe(InvitationObserver::class);
        Participant::observe(ParticipantObserver::class);
    }
}
