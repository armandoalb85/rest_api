<?php

namespace App\Http\Controllers;

use App\Shop;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ShopsController extends Controller {

    public function index() {

        $shop = Shop::all()->toArray();

        return response()->json($shop);
    }

    public function store(Request $request) {

        try {

            $shop = new Shop([
                'shop_name' => $request->input('shop_name')
            ]);

            $shop->save();

            return response()->json(['status' => true, 'message' => 'Se ha creado una tienda '
                        . 'exitosamente'], 200);
        } catch (Exception $ex) {
            Log::critical("No se pudo crear la tienda: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'crear la tienda'], 500);
        }
    }

    public function show($idProvider) {
        try {

            $shop = Shop::find($idProvider);

            if (!$shop) {
                return response()->json(['message' => 'Esta tienda no existe'], 200);
            } else {
                return response()->json($shop, 200);
            }
        } catch (Exception $ex) {
            Log::critical("No se encontró la tienda: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'buscar la tienda'], 500);
        }
    }

    public function update(Request $request) {
        try {
            if ($request->isMethod('put')) {
                $shop = Shop::findOrFail($request->get('id'));

                if (!$shop) {
                    return response()->json(['message' => 'Esta tienda no existe'], 404);
                } else {

                    Shop::where('id', $request->get('id'))->update(
                            ['shop_name' => $request->get('shop_name')]);

                    return response()->json(['status' => true, 
                        'message' => 'Se ha actualizado la tienda'], 200);
                }
            } 
        } catch (Exception $ex) {
            Log::critical("No se pudo actualizar la tienda: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'actualizar la tienda'], 500);
        }
    }

    public function destroy($id) {
        try {

            $shop = Shop::find($id);

            if (!$shop) {
                return response()->json(['message' => 'Esta tienda no existe'], 404);
            } else {

                $shop->delete();
                return response()->json(['status' => true,
                            'message' => 'La tienda ha sido eliminada'], 200);
            }
        } catch (Exception $ex) {
            Log::critical("No se pudo eliminar la tienda: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'eliminar la tienda'], 500);
        }
    }

}
