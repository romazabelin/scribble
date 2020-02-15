<?php

namespace App\Services;


use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class FilterService
{
    /**
     * get possible options for filtering
     *
     * @return array
     */
    public static function getFilterList()
    {
        return [
            0                    => Lang::get('translations.filter.select'),
            FILTER_ALL_FIELDS    => Lang::get('translations.filter.all'),
            FILTER_CLIENT_NAME   => Lang::get('translations.filter.client_name'),
            FILTER_PRODUCT_NAME  => Lang::get('translations.filter.product_name'),
            FILTER_PRODUCT_TOTAL => Lang::get('translations.filter.total'),
            FILTER_PRODUCT_DATE  => Lang::get('translations.filter.date')
        ];
    }

    /**
     * add filter statements to query
     *
     * @param int $key
     * @param string $value
     * @param $query
     */
    public function addFilterStatements(int $key, string $value, $query)
    {
        //TODO: date in input - mask
        if (!$key)
            return $query;

        $validator = Validator::make([
            'key'   => $key,
            'value' => $value
        ], [
            'key'   => 'required|integer|min:1',
            'value' => 'required|string'
        ]);

        if ($validator->fails())
            return $query;

        switch($key) {
            case FILTER_ALL_FIELDS:
                $date  = date('Y-m-d', strtotime($value));
                $query = ProductRepository::addAllStatements($value, $date, $query);
                break;
            case FILTER_CLIENT_NAME:
                $query = ProductRepository::addWithClientsStatement($value, $query);
                break;
            case FILTER_PRODUCT_NAME:
                $query = ProductRepository::addNameStatement($value, $query);
                break;
            case FILTER_PRODUCT_TOTAL:
                $query = ProductRepository::addTotalStatement($value, $query);
                break;
            case FILTER_PRODUCT_DATE:
                $date  = date('Y-m-d', strtotime($value));
                $query = ProductRepository::addDateStatement($date, $query);
                break;
        }

        return $query;
    }
} 