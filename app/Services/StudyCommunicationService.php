<?php


namespace App\Services;

use App\Models\Study;
use Illuminate\Http\Request;
use App\Models\Communication;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CommunicationRequest;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Classes\Contracts\Services\StudyCommunicationService as StudyCommunicationServiceContract;

class StudyCommunicationService implements StudyCommunicationServiceContract
{
    /**
     * Get communications by a study
     *
     * @param Study $study Study
     *
     * @return HasMany
     */
    public function getCommunicationsByStudy(Study $study): HasMany
    {
        return $study->communications();
    }

    /**
     * Show a communication template
     * 
     * @param Study         $study         Study
     * @param Communication $communication Communication
     * 
     * @return Communication
     */
    public function show(
        Study $study,
        Communication $communication
    ): Communication {
        return $study->communications()->findOrFail($communication->id);
    }

    /**
     * Update a communication template
     * 
     * @param Study         $study         Study
     * @param Communication $communication Communication
     * @param array         $request       Request
     * 
     * @return Communication
     */
    public function update(
        Study $study,
        Communication $communication,
        CommunicationRequest $request
    ): Communication {
        $editedData = [
            'template_name' => $request->template_name,
            'email_subject' => $request->email_subject,
            'content'       => $request->content,
        ];

        if ($request->file) {
            $editedData['file'] = Storage::disk('local')->putFile('images', $request->file);
        }

        $study->communications()->whereId($communication->id)->update($editedData);

        return $communication->fresh();
    }

    /**
     * Update a communication template
     * 
     * @param Study         $study         Study
     * @param Communication $communication Communication
     * @param Request       $request       Request
     * 
     * @return Communication
     */
    public function updateColumn(
        Study $study,
        Communication $communication,
        Request $request
    ): Communication {
        $study->communications()->whereId($communication->id)->update(['enabled' => $request->enabled ? 1 : 0]);

        return $communication->fresh();
    }
}
