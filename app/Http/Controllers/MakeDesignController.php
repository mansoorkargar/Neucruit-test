<?php

namespace App\Http\Controllers;

use App\Classes\Contracts\Services\MakeDesignService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class MakeDesignController extends Controller
{
    /**
     * @param MakeDesignService $designService
     * @param $id
     * @return Builder|Model
     */
    public function showByStudy(MakeDesignService $designService, $id)
    {
        return $designService->showByStudy($id);
    }

    /**
     * @param MakeDesignService $designService
     * @param $id
     * @return Builder|Model
     */
    public function show(MakeDesignService $designService, $id)
    {
        return $designService->show($id);
    }

    /**
     * @param MakeDesignService $designService
     * @param Request $request
     */
    public function store(MakeDesignService $designService, Request $request)
    {
        $data = [
            'study_id' => $request['study_id'],
            'assets' => $request['gjs-assets'],
            'components' => $request['gjs-components'],
            'css' => $request['gjs-css'],
            'html' => $request['gjs-html'],
            'styles' => $request['gjs-styles'],
        ];

        $designService->store($data);
    }
}
