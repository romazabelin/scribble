<?php

namespace App\Services;


use App\Repositories\ClientRepository;

class ClientService
{
    /**
     * get client key=>value pairs
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getWithIdName()
    {
        return ClientRepository::getWithIdName();
    }
} 