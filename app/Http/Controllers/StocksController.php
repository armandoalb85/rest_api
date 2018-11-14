<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class StocksController extends Controller {

    
    public function update(Request $request) {
        try {
            if ($request->isMethod('put')) {
                $product = Product::findOrFail($request->get('id'));

                if (!$product) {
                    return response()->json(['message' => 'Este producto no existe'], 404);
                } else {

                    Product::where('id', $request->get('id'))->increment('quantity', $request->get('quantity'));

                    return response()->json(['status' => true, 
                        'message' => 'Se ha actualizado el stock del producto'], 200);
                }
            } 
        } catch (Exception $ex) {
            Log::critical("No se pudo actualizar el stock: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'actualizar el stock'], 500);
        }
    }

}
