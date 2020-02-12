<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferData;
use App\Services\TransferService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TransferController extends Controller
{
    /**
     * Import data from xls
     *
     * @param \App\Http\Requests\TransferData $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importDataFromXls(TransferData $request)
    {
        $input      = $request->all();
        $isImported = TransferService::importData($input);
        $msg        = $isImported ? Lang::get('translations.success_import') : Lang::get('translations.unsuccessful_import');

        return back()->with('status', $msg);
    }
}
