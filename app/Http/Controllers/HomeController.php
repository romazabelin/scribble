<?php

namespace App\Http\Controllers;

use App\Repositories\ClientRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public static function index()
    {
        $clients = ClientRepository::getWithIdName();

        return view('index.index', compact('clients'));
    }
}
