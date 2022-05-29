<?php


namespace App\Services;

use Exception;
use App\Classes\Contracts\Services\MakeDesignService as MakeDesignServiceContract;
use App\Models\Design;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;


class MakeDesignService implements MakeDesignServiceContract
{
    /**
     * @param string $id
     * @return array
     * @throws Exception
     */
    public function showByStudy(string $id): array
    {
        try {
            $design = Design::query()->where('study_id', $id)->firstOrFail();

            return [
              'gjs-assets' => $design->assets,
              'gjs-components' => $design->components,
              'gjs-css' => $design->css,
              'gjs-html' => $design->html,
              'gjs-styles' => $design->styles,
            ];
        } catch (Exception $e) {
            throw new Exception();
        }
    }

    /**
     * @param string $id
     * @return Builder|Model
     * @throws Exception
     */
    public function show(string $id): model
    {
        try {
            return Design::query()->where('id', $id)->firstOrFail();
        } catch (Exception $e) {
            throw new Exception();
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function store(array $data): array
    {
        try {
            $design = Design::query()->updateOrCreate(['study_id' => $data['study_id']], $data);
            
            return [
              'success' => true,
              'data' => $design
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'data' => $e
            ];
        }
    }
}
