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
} 