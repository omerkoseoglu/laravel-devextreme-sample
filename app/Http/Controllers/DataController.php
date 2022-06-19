<?php

namespace App\Http\Controllers;

use App\Services\DataSourceService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class DataController extends Controller
{
    private DataSourceService $dataSourceService;

    public function __construct(DataSourceService $dataSourceService)
    {
        $this->dataSourceService = $dataSourceService;
    }

    public function getAll(Request $request)
    {
        $fields = [
            ['column' => 'id', 'table' => 'c', 'alias' => 'id'],
            ['column' => 'short_name', 'table' => 'c', 'alias' => 'short_name'],
            ['column' => 'name', 'table' => 'c', 'alias' => 'name'],
            ['column' => 'phone_code', 'table' => 'c', 'alias' => 'phone_code'],
            ['column' => 'name', 'table' => 's', 'alias' => 'state_name'],
            ['column' => 'name', 'table' => 'c1', 'alias' => 'city_name'],
        ];

        $selectFields = collect($fields)->map(function ($item, $key) {
            return $item['table'].'.'.$item['column']. ' as '. $item['alias'];
        });

        $query = DB::table('countries as c')
            ->join('states as s', 'c.id', '=', 's.country_id')
            ->join('cities as c1', 's.id', '=', 'c1.state_id')
            ->select($selectFields->toArray());

        return $this->dataSourceService->getData($query, $request, $fields);
    }
}
