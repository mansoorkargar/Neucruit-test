<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Class CommunicationTriggerEnum
 * @package App\Enums
 */
class CampaignTypesEnum extends Enum
{
    /**
     * @const string
     */
    public const DIRECT_TO_INDIVIDUAL = "Direct to Individual";

    /**
     * @const string
     */
    public const VIA_CLINIC = "Via Clinician";

    /**
     * @const string
     */
    public const VIA_NON_CLINICAL_ORGANISATION = "Via non-clinical organisation";
}
