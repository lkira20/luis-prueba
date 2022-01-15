<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin','permission:producto.index'])->only('index');
        $this->middleware(['role:admin','permission:producto.create'])->only('store');
        $this->middleware(['role:admin','permission:producto.edit'])->only('update');
        $this->middleware(['role:admin','permission:producto.delete'])->only('destroy');
        $this->middleware(['role:admin','permission:producto.show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $productos = Producto::orderBy('id', 'desc')->get();

        return response()->json($productos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|string|max:255',
                'descripcion' => ['required'],
                'precio' => ['required', 'integer'],
            ]);

            $request->merge([
                'creado' => Carbon::now()
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->all());
            }
            
            $producto = Producto::create($request->all());

            return response()->json([
                'message' => 'registro exitoso',
                'producto'    =>  $producto
            ]);
        } catch (\Throwable $th) {
    
            return response()->json([
                'message' => $th->getMessage() ,
                'error'    => 'true'
            ]);
           
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $producto = Producto::find($id);

            if(isset($producto)){
                return response()->json([
                    'producto'    =>  $producto
                ]);
            }else{
                return response()->json([
                    'message'    =>  'no exite el producto'
                ]);
            }
            
        } catch (\Throwable $th) {
            
            return response()->json([
                'message' => $th ,
                'error'    => 'true'
            ]);
           
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->update($request->all());

            return response()->json([
                'message' => 'registro actualizado exitosamente',
                'producto'    =>  $producto
            ]);
        } catch (\Throwable $th) {
            
            return response()->json([
                'message' => $th ,
                'error'    => 'true'
            ]);
           
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $producto = Producto::find($id);
            $producto->delete();

            return response()->json([
                'message' => 'producto eliminado',
                'producto'    =>  $producto
            ]);
        } catch (\Throwable $th) {
            
            return response()->json([
                'message' => $th ,
                'error'    => 'true'
            ]);
           
        }
    }
}
