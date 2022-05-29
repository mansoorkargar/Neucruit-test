<?php

namespace App\Classes\Contracts\Services;

interface AdvocatesService
{
    /**
     * @param string $search
     * @return array
     */
    public function list(string $search): array;
}
