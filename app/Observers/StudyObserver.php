<?php

namespace App\Observers;

use App\Models\Study;
use App\Models\Design;
use App\Models\Communication;
use App\Models\StudyQuestion;

class StudyObserver
{
    /**
     * Listen to the creating event
     *
     * @param Study $model Study
     *
     * @return void
     */
    public function creating(Study $model): void
    {
        $model->created_by = auth()->user()->id ?? 0;
        $model->updated_by = null;
    }

    /**
     * Listen to the created event
     *
     * @param Study $model Study
     *
     * @return void
     */
    public function created(Study $model): void
    {
        /* Create designs */
        $model->designs()->createMany(
            Design::whereNull('study_id')->select(
                'assets',
                'components',
                'css',
                'html',
                'styles',
            )->get()->toArray()
        );

        /* Create communication templates */
        $model->communications()->createMany(
            Communication::whereNull('study_id')->select(
                'template_name',
                'email_subject',
                'file',
                'enabled',
                'content',
                'communication_trigger_id'
            )->get()->toArray()
        );

        /* Create study questions */
        $model->study_questions()->createMany(
            StudyQuestion::whereNull('study_id')->select(
                'position',
                'name',
                'type',
                'options',
                'is_required',
            )->get()->toArray()
        );
    }

    /**
     * Listen to the updating event
     *
     * @param Study $model Study
     *
     * @return void
     */
    public function updating(Study $model): void
    {
        $model->updated_by = auth()->user()->id ?? null;
    }

    /**
     * Listen to the updating event
     *
     * @param Study $model Study
     *
     * @return void
     */
    public function deleting(Study $model): void
    {
        /* Create designs */
        $model->designs()->delete();

        /* Create communication templates */
        $model->communications()->delete();

        /* Create study questions */
        $model->study_questions()->delete();
    }
}
