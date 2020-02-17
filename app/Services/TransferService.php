<?php

namespace App\Services;

use App\Exports\SkeletonExport;
use App\Imports\ClientImport;
use App\Imports\ProductImport;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Lang;
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
        //import data from -xls; store on the the server -> then read it
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

    /**
     * Export data to xlxs and send on email
     *
     * @param int $filterKey
     * @param string $filterVal
     * @return array
     */
    public static function exportData(?int $filterKey, ?string $filterVal)
    {
        $filterService = new FilterService();
        $query         = ProductRepository::getQuery();
        //set filter queries
        $query         = $filterService->addFilterStatements($filterKey, $filterVal, $query);
        $data          = ProductRepository::executeQueryForExport($query);

        if (count($data) == 0) {
            //if no results for export
            $msg = Lang::get('translations.export.msg_nothing_to_export');
        } else {
            //if we have data then create xlsx file and send in email
            $headData    = [
                Lang::get('translations.export.file_heading.client'),
                Lang::get('translations.export.file_heading.product'),
                Lang::get('translations.export.file_heading.total'),
                Lang::get('translations.export.file_heading.date')
            ];
            $file        = '/files/reports/' . time() . '.xlsx';

            ob_end_clean();
            Excel::store(new SkeletonExport($data, $headData), $file);

            //send report to users
            MailService::sendReport(['aleksandr.datsko@asdat.net'], storage_path() . '/app' .$file);

            $msg = Lang::get('translations.export.msg_success');
        }

        return compact('msg');
    }
}
