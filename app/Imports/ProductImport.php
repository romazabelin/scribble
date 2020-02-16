<?php

namespace App\Imports;

use App\Repositories\ClientRepository;
use App\Repositories\ProductRepository;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class ProductImport implements ToModel
{
    /**
     * import data to client model
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null|void
     */
    public function model(array $row)
    {
        $client  = $row[0];
        $name    = $row[1];
        $total   = $row[2];
        $date    = $row[3];

        $product = ClientRepository::getByName($client);

        if ($product) {
            $date = Date::excelToDateTimeObject($date);

            ProductRepository::create($name, $total, $product->id, $date->format('Y-m-d'));
        }
    }
}