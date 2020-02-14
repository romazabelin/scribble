<?php

namespace App\Services;


use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class ProductService
{
    /**
     * update product - make validation etc.
     *
     * @param int $id
     * @param array $input
     * @return array
     */
    public static function update(int $id, array $input)
    {
        $validator = Validator::make($input, [
            'client_id' => 'required|integer|min:1',
            'name'      => 'required|string',
            'total'     => 'required|integer|min:1',
            'id'        => 'required|integer'
        ]);

        if ($validator->fails()) {
            $isSaved = false;
            $msg     = implode(',', $validator->messages()->all());
        } else {
            $product = ProductRepository::getById($id);

            $product->fill($input);
            $product->save();

            $isSaved = true;
            $msg     = Lang::get('translations.edit_product.success');
        }

        return compact('isSaved', 'msg');
    }

    /**
     * delete product from DB
     *
     * @param int $id
     */
    public static function destroy(int $id)
    {
        ProductRepository::destroy($id);

        $isSaved   = true;
        $msg       = Lang::get('translations.destroy_product.success');

        return compact('isSaved', 'msg');
    }

    /**
     * get data for chart
     *
     * @return array
     */
    public static function getChartData()
    {
        $revenueTotalData = ProductRepository::getTotalByDate();

        return compact('revenueTotalData');
    }
} 