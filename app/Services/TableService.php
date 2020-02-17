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
     * Init datatable listings
     *
     * @param int|null $filterKey
     * @param string|null $filterValue
     * @return json
     */
    public static function getProductsDataTable(?int $filterKey, ?string $filterValue)
    {
        $filterService = new FilterService();
        $query         = ProductRepository::getQuery();
        $query         = $filterService->addFilterStatements($filterKey, $filterValue, $query);

        return DataTables::of(ProductRepository::execQuery($query))
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
