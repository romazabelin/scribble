<?php

namespace App\Repositories;

use App\Client;

class ClientRepository
{
    /**
     * @param string $name
     */
    public static function create(string $name)
    {
        Client::firstOrCreate(
            ['name' => $name],
            ['name' => $name]
        );
    }

    /**
     * @param string $name
     * @return App/Client
     */
    public static function getByName(string $name)
    {
        return Client::where('name', $name)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getWithIdName()
    {
        return Client::all()->pluck('name', 'id')->toArray();
    }
} 