<?php

namespace App\Http\Controllers;

use App\Provider;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ProvidersController extends Controller {

    public function index() {

        $provider = Provider::all()->toArray();

        return response()->json($provider);
    }

    public function store(Request $request) {

        try {

            $provider = new Provider([
                'id_provider' => $request->input('id_provider'),
                'provider_name' => $request->input('provider_name')
            ]);

            $provider->save();

            return response()->json(['status' => true, 'message' => 'Se ha creado un proveedor '
                        . 'exitosamente'], 200);
        } catch (Exception $ex) {
            Log::critical("No se pudo crear el proveedor: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'crear el proveedor'], 500);
        }
    }

    public function show($idProvider) {
        try {

            $provider = Provider::find($idProvider);

            if (!$provider) {
                return response()->json(['message' => 'Este producto no existe'], 200);
            } else {
                return response()->json($provider, 200);
            }
        } catch (Exception $ex) {
            Log::critical("No se encontró el proveedor: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'buscar el proveedor'], 500);
        }
    }

    public function update(Request $request) {
        try {
            if ($request->isMethod('put')) {
                $provider = Provider::findOrFail($request->get('id'));

                if (!$provider) {
                    return response()->json(['message' => 'Este proveedor no existe'], 404);
                } else {

                    Provider::where('id', $request->get('id'))->update(
                            ['provider_name' => $request->get('provider_name')]);

                    return response()->json(['status' => true, 
                        'message' => 'Se ha actualizado el proveedor'], 200);
                }
            } 
        } catch (Exception $ex) {
            Log::critical("No se pudo actualizar el proveedor: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'actualizar el producto'], 500);
        }
    }

    public function destroy($id) {
        try {

            $provider = Provider::find($id);

            if (!$provider) {
                return response()->json(['message' => 'Este proveedor no existe'], 404);
            } else {

                $provider->delete();
                return response()->json(['status' => true,
                            'message' => 'El proveedor ha sido eliminado'], 200);
            }
        } catch (Exception $ex) {
            Log::critical("No se pudo eliminar el proveedor: {$ex->getCode()},"
                    . "{$ex->getLine()},{$ex->getMessage()}");

            return response()->json(['status' => false, 'message' => 'Ha ocurrido un error al '
                        . 'eliminar el proveedor'], 500);
        }
    }

}
