<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProductsController extends Controller {

    public function index() {

        $product = Product::all()->toArray();

        return response()->json($product);
    }

    public function store(Request $request) {

        try {

            $product = new Product([
                'id_provider' => $request->input('id_provider'),
                'shop_id' => $request->input('shop_id'),
                'product_name' => $request->input('product_name'),
                'description' => $request->input('description'),
                'buy_date' => $request->input('buy_date'),
                'quantity' => $request->input('quantity'),
                'unit_cost' => $request->input('unit_cost'),
                'active' => $request->input('active')
            ]);

            $product->save();

            return response()->json(['status' => true, 'message' => 'Se ha creado un producto '
                        . 'exitosamente'], 200);
        } catch (Exception $ex) {
            Log::critical("No se pudo crear el producto: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'crear el producto'], 500);
        }
    }

    public function show($id_product) {
        try {

            $product = Product::find($id_product);

            if (!$product) {
                return response()->json(['message' => 'Este producto no existe'], 200);
            } else {
                return response()->json($product, 200);
            }
        } catch (Exception $ex) {
            Log::critical("No se encontró el producto: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'buscar el producto'], 500);
        }
    }

    public function update(Request $request) {
        try {
            if ($request->isMethod('put')) {
                $product = Product::findOrFail($request->get('id'));

                if (!$product) {
                    return response()->json(['message' => 'Este producto no existe'], 404);
                } else {

                    Product::where('id', $request->get('id'))->update(
                            ['id_provider' => $request->get('id_provider'),
                                'shop_id' => $request->get('shop_id'),
                                'product_name' => $request->get('product_name'),
                                'description' => $request->get('description'),
                                'buy_date' => $request->get('buy_date'),
                                'quantity' => $request->get('quantity'),
                                'unit_cost' => $request->get('unit_cost'),
                                'active' => $request->get('active')]);

                    return response()->json(['status' => true, 'message' => 'Se ha actualizado un producto '
                                . 'exitosamente ' . $request->get('id')], 200);
                }
            } else {
                return response()->json(['status' => true, 'message' => 'No ocurrió nada'], 200);
            }
        } catch (Exception $ex) {
            Log::critical("No se pudo crear el producto: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'buscar el producto'], 500);
        }
    }

    public function destroy($id) {
        try {

            $product = Product::find($id);

            if (!$product) {
                return response()->json(['message' => 'Este producto no existe'], 404);
            } else {

                $product->delete();
                return response()->json(['status' => true,
                            'message' => 'El producto ha sido eliminado'], 200);
            }
        } catch (Exception $ex) {
            Log::critical("No se pudo eliminar el producto: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'eliminar el producto'], 500);
        }
    }

}
