<?php

namespace App\Http\Controllers;


use App\Services\ClientService;
use App\Services\FilterService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public static function index()
    {
        $clients       = ClientService::getWithIdName();
        $filterOptions = FilterService::getFilterList();

        return view('index.index', compact('clients', 'filterOptions'));
    }
}
