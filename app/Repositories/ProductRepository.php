<?php

namespace App\Repositories;

use App\Product;

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
    public static function getAll()
    {
        return Product::with(['client'])->get('*');
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
} 