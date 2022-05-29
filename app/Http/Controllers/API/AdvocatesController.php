<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Classes\Contracts\Services\AdvocatesService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class AdvocatesController extends Controller
{
    /**
     * @var AdvocatesService
     */
    private $advocates;

    /**
     * StudyController constructor.
     * @param AdvocatesService $advocates
     */
    public function __construct(AdvocatesService $advocates)
    {
        $this->advocates = $advocates;
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function list(Request $request): LengthAwarePaginator
    {
        return $this->paginate($this->advocates->list($request->search));
    }

    /**
     * @param $items
     * @param int $perPage
     * @param null $page
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, int $perPage = 50, $page = null, array $options = []): LengthAwarePaginator
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
