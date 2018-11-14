<?php

namespace App\Http\Controllers;

use App\Sell;
use App\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SellsController extends Controller {

    public function index() {

//        $shop = Shop::all()->toArray();
//
//        return response()->json($shop);
    }

    public function store(Request $request) {

        try {

            $sells = new Sell([
                'id_product' => $request->input('id_product'),
                'cost' => $request->input('cost'),
                'quantity' => $request->input('quantity')
            ]);

            if ($sells->save() && $this->updateStok($request->input('id_product'), $request->input('quantity'))) {
                return response()->json(['status' => true, 
                    'message' => 'Venta completada por un costo total de '
                    .$request->input('cost')], 200);
            } else {
                return response()->json(['status' => true, 'message' => 'Nada'], 200);
            }
        } catch (Exception $ex) {
            Log::critical("No se pudo crear la tienda: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'crear la tienda'], 500);
        }
    }

    private function updateStok($id, $quantity) {
        try {

            $product = Product::findOrFail($id);

            if (!$product) {
                return false;
            } else {

                //Product::where('id', $id)->update(['quantity' => 'quantity-'.$quantity]);
                Product::where('id', $id)->decrement('quantity', $quantity);

                return true;
            }
        } catch (Exception $ex) {
            Log::critical("No se pudo actualizar la tienda: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'actualizar la tienda'], 500);
        }
    }

//    public function destroy($id) {
//        try {
//
//            $shop = Shop::find($id);
//
//            if (!$shop) {
//                return response()->json(['message' => 'Esta tienda no existe'], 404);
//            } else {
//
//                $shop->delete();
//                return response()->json(['status' => true,
//                            'message' => 'La tienda ha sido eliminada'], 200);
//            }
//        } catch (Exception $ex) {
//            Log::critical("No se pudo eliminar la tienda: {$ex->getCode()},"
//                    . "{$ex->getLine()},{$ex->getMessage()}");
//
//            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
//                        . 'eliminar la tienda'], 500);
//        }
//    }
}
