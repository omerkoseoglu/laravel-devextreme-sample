<?php

namespace App\Services;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class DataSourceService
{
    public function getData(Builder $query, Request $request, array $fields): array
    {
        $response = array();

        $queryStr = Str::replaceArray('?', $query->getBindings(), $query->toSql());

        $query = DB::table(DB::raw("($queryStr) as sub"));

        $requireTotalCount = $request::get('requireTotalCount');
        $skip = $request::input('skip');
        $take = $request::input('take');
        $sort = $request::input('sort');
        $filter = $request::input('filter');
        $group = $request::input('group');

        if (isset($sort) && is_array(json_decode($sort)) && !isset($group)) {
            $sortArray = json_decode($sort);
            foreach ($sortArray as $key => $sortItem) {
                $query->orderBy($sortItem->selector, $sortItem->desc ? 'asc' : 'desc');
            }
        }

        if (isset($filter) && is_array(json_decode($filter))) {
            $isCriteria = function ($item) {
                return is_array($item) && !is_string($item);
            };

            $filterArray = json_decode($filter);

            $compileWhereOperator = function ($whereOp, $whereValue) {
                switch ($whereOp) {
                    case 'contains':
                        $whereOp = 'LIKE';
                        $whereValue = '%' . $whereValue . '%';
                        break;
                    case 'notcontains':
                        $whereOp = 'NOT LIKE';
                        $whereValue = '%' . $whereValue . '%';
                        break;
                    case 'startswith':
                        $whereOp = 'LIKE';
                        $whereValue = $whereValue . '%';
                        break;
                    case 'endswith':
                        $whereOp = 'LIKE';
                        $whereValue = '%' . $whereValue;
                        break;
                }

                return ['operator' => $whereOp, 'value' => $whereValue];
            };

            if (!$isCriteria($filterArray[0])) {
                $compiledWhere = $compileWhereOperator($filterArray[1], $filterArray[2]);

                $whereOperator = $compiledWhere['operator'];
                $filterValue = $compiledWhere['value'];

                if ($filterArray[1] == 'BETWEEN') {
                    $query->whereBetween($filterArray[0], $filterArray[2]);
                } else {
                    $query->where($filterArray[0], $whereOperator, $filterValue);
                }
            } else {
                $compileFilter = function ($filterCriteria, $query) use ($compileWhereOperator, &$compileFilter) {

                    $operand = in_array('and', $filterCriteria) ? 'and' : 'or';

                    foreach ($filterCriteria as $filterKey => $filterValue) {
                        if (is_array($filterValue) && is_string($filterValue[0])) {
                            $compiledWhere = $compileWhereOperator($filterValue[1], $filterValue[2]);
                            $whereOperator = $compiledWhere['operator'];
                            $whereValue = $compiledWhere['value'];

                            $query = $query->where($filterValue[0], $whereOperator, $whereValue, $operand);
                        } else if (is_array($filterValue) && !is_string($filterValue[0])) {
                            // $l = in_array('and', $filterValue) ? 'and' : 'or';
                            $t = $compileFilter($filterValue, $query->forNestedWhere());
                            $query->addNestedWhereQuery($t, $operand);
                        } else if (is_string($filterValue)) {
                            $operand = $filterValue;
                        }
                    }

                    return $query;
                };

                $query = $compileFilter($filterArray, $query);
            }
        }

        if (isset($requireTotalCount) || isset($skip)) {
            $response['totalCount'] = $query->count();
        }

        if (isset($skip)) {
            $query->skip($skip);
        }

        if (isset($take)) {
            $query->take($take);
        }

        $queryData = $query->get();

        $response['data'] = $queryData->toArray();

        /*
        Log::info($request);
        Log::info(json_encode($response));
        */

        return $response;
    }

}
