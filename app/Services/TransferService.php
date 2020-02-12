<?php

namespace App\Services;

use App\Imports\ClientImport;
use App\Imports\ProductImport;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TransferService
{
    /**
     * import clients, products to DB
     *
     * @param array $input
     * @return bool
     */
    public static function importData(array $input)
    {
        $file     = $input['file_to_upload'];
        $fileName = time() . '.' . $file->getClientOriginalExtension();

        $file->move(base_path('public/files/uploads'), $fileName);

        $pathToFile  = public_path() . '/files/uploads/' . $fileName;

        switch ($input['checked_table']) {
            case 1:
                Excel::import(new ClientImport(), $pathToFile);
                break;
            case 2:
                Excel::import(new ProductImport(), $pathToFile);
                break;
        }

        return true;
    }
} 