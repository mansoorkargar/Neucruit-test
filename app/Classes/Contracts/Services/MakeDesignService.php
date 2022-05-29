<?php


namespace App\Classes\Contracts\Services;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface MakeDesignService
{
    /**
     * @param string $id
     * @return array
     */
    public function showByStudy(string $id): array;

    /**
     * @param string $id
     * @return Builder|Model
     */
    public function show(string $id): model;

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data): array;
}
