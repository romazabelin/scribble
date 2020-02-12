<?php

namespace App\Imports;

use App\Repositories\ClientRepository;
use Maatwebsite\Excel\Concerns\ToModel;

class ClientImport implements ToModel
{
    /**
     * import data to client model
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Model[]|null|void
     */
    public function model(array $row)
    {
        $id   = $row[0];
        $name = $row[1];

        //check on integer - because of heading row ('ID')
        if (is_int($id))
            ClientRepository::create($name);
    }
}