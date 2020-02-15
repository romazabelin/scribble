<?php

namespace App\Repositories;

use App\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * @param string $name
     * @param int $total
     * @param int $clientId
     * @param string $date
     * @return App/Product
     */
    public static function create(string $name, int $total, int $clientId, string $date)
    {
        return Product::create([
            'name'      => $name,
            'total'     => $total,
            'client_id' => $clientId,
            'date'      => $date
        ]);
    }

    /**
     * get all products
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAllProducts()
    {
        return Product::with(['client'])->get('*');
    }

    /**
     * get query for all products
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getQuery()
    {
        return Product::query();
    }

    /**
     * add statement belongsTo client
     *
     * @param $query
     * @return mixed
     */
    public static function addWithClients($query)
    {
        return $query->with(['client']);
    }

    /**
     * @param string $name
     * @param $query
     * @return mixed
     */
    public static function addWithClientsStatement(string $name, $query)
    {
        return $query->whereHas('client', function($q) use ($name) {
            $q->where('name', 'like', '%' . $name . '%');
        });
    }

    /**
     * @param string $value
     * @param string $date
     * @param $query
     * @return mixed
     */
    public static function addAllStatements(string $value, string $date, $query)
    {
        return $query->where(function($q) use ($value, $date) {
            $q->orWhere('total', $value);
            $q->orWhere('date', 'like', '%' . $date . '%');
            $q->orWhere('name', 'like', '%' . $value . '%');
            $q->orWhereHas('client', function($q) use ($value) {
                $q->where('name', 'like', '%' . $value . '%');
            });
        });
    }

    /**
     * @param int $total
     * @param $query
     */
    public static function addTotalStatement(int $total, $query)
    {
        return $query->where('total', $total);
    }

    /**
     * @param string $date
     * @param $query
     * @return mixed
     */
    public static function addDateStatement(string $date, $query)
    {
        return $query->where('date', 'like', '%' . $date . '%');
    }

    /**
     * @param string $name
     * @param $query
     * @return mixed
     */
    public static function addNameStatement(string $name, $query)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function execQuery($query)
    {
        return $query->with(['client'])->get('*');
    }


    /**
     * @param $query
     * @return mixed
     */
    public static function executeQueryForExport($query)
    {
        //return $query->with(['client'])->get();
        //['name', 'total', 'date']
        //with(['client'])
        return $query->get(['name', 'total', 'date'])->toArray();
    }

    /**
     * get single product by ID
     *
     * @param int $id
     * @return mixed
     */
    public static function getById(int $id)
    {
        return Product::find($id);
    }

    /**
     * @param int $id
     */
    public static function destroy(int $id)
    {
        Product::destroy($id);
    }

    /**
     * @return mixed
     */
    public static function getTotalByDateQuery()
    {
        //return Product::select(DB::raw('sum(products.total) as total'), DB::raw('DATE_FORMAT(products.date, "%Y-%m-%d") as date'))->groupBy('products.date')->get()->toArray();
        return Product::selectRaw('sum(products.total) as total, DATE_FORMAT(products.date, "%Y-%m-%d") as date')
            ->groupBy('products.date')
            ->orderBy('products.date');
    }


    /**
     * @param $query
     * @return mixed
     */
    public static function executeTotalByDateQuery($query)
    {
        return $query->get()
            ->pluck('total', 'date')
            ->toArray();
    }

    /**
     * @return mixed
     */
    public static function getTotalByDate()
    {
        //return Product::select(DB::raw('sum(products.total) as revenue'), DB::raw('DATE_FORMAT(products.date, "%Y-%m-%d") as date'))->groupBy('products.date')->get()->toArray();
        return Product::selectRaw('sum(products.total) as revenue, DATE_FORMAT(products.date, "%Y-%m-%d") as date')
            ->groupBy('products.date')
            ->orderBy('products.date')
            ->get()
            ->pluck('revenue', 'date')
            ->toArray();
    }
} 