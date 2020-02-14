<?php
/**
 * Created by PhpStorm.
 * User: roma
 * Date: 2/13/20
 * Time: 1:46 PM
 */

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Lang;
use Yajra\DataTables\DataTables;

class TableService
{
    /**
     * Get products list for dataable
     *
     * @return json
     */
    public static function getProductsDataTable()
    {
        return DataTables::of(ProductRepository::getAll())
            ->editColumn('total', function($row) {
                return Lang::get('translations.table.row.dollar') . $row->total;
            })
            ->addColumn('date_formatted', function($row) {
                return [
                    'display'   => date('d/m/Y', strtotime($row->date)),
                    'timestamp' => strtotime($row->date)
                ];
            })
            ->addColumn('actions', function($row) {
                $str  = "<a href='" . route('product.edit', ['product' => $row->id]) . "' class='btn btn-info load-product-data mr-1'>" . Lang::get('translations.table.row.edit') . "</a>";
                $str .= "<a href='" . route('product.destroy', ['product' => $row->id]) . "' class='btn btn-danger destroy-product'>" . Lang::get('translations.table.row.delete') . "</a>";

                return $str;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
} 