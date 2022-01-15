<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::orderBy('id', 'desc')->get();

        return response()->json($users);
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
                'email' => ['required', 'email', 'max:255', Rule::unique('users')],
                'password' => ['required', 'string', 'max:255'],
                'edad' => ['required', 'integer', 'max:255'],
                'fecha_nacimiento' => ['required', 'date', 'max:255'],
                'sexo' => ['required', 'string', 'max:255', 'in:hombre,mujer'],
                'dni' => ['required', 'integer', Rule::unique('users')],
                'direccion' => ['required', 'string', 'max:255'],
                'pais' => ['required', 'string', 'max:255'],
                'telefono' => ['required', 'string'],
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->all());
            }
            
            $user = User::create($request->all());

            return response()->json([
                'message' => 'registro exitoso',
                'user'    =>  $user
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
            $user = User::find($id);

            if(isset($user)){
                return response()->json([
                    'user'    =>  $user
                ]);
            }else{
                return response()->json([
                    'message'    =>  'no exite el usuario'
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
            $user = User::findOrFail($id);
            $user->update($request->all());

            return response()->json([
                'message' => 'registro actualizado exitosamente',
                'user'    =>  $user
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
            $user = User::find($id);
            $user->delete();

            return response()->json([
                'message' => 'usuario eliminado',
                'user'    =>  $user
            ]);
        } catch (\Throwable $th) {
            
            return response()->json([
                'message' => $th ,
                'error'    => 'true'
            ]);
           
        }
    }
}
