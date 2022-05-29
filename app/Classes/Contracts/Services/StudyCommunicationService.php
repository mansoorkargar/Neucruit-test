<?php

namespace App\Classes\Contracts\Services;

use App\Models\Study;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Http\Requests\CommunicationRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface StudyCommunicationService
{
    /**
     * Get communications by a study
     *
     * @param Study $study Study
     *
     * @return HasMany
     */
    public function getCommunicationsByStudy(Study $study): HasMany;

    /**
     * Show a communication template
     * 
     * @param Study         $study         Study
     * @param Communication $communication Communication
     * 
     * @return Communication
     */
    public function show(Study $study, Communication $communication): Communication;

    /**
     * Update a communication template
     * 
     * @param Study                $study         Study
     * @param Communication        $communication Communication
     * @param CommunicationRequest $request       Request
     * 
     * @return Communication
     */
    public function update(Study $study, Communication $communication, CommunicationRequest $request): Communication;

    /**
     * Update a communication template
     * 
     * @param Study         $study         Study
     * @param Communication $communication Communication
     * @param Request       $request       Request
     * 
     * @return Communication
     */
    public function updateColumn(Study $study, Communication $communication, Request $request): Communication;
}
