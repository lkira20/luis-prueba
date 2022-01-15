<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function asignarRole(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'role' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->all());
            }
            
            $user = User::find($request->user_id);
            $role = Role::where('name', $request->role)->first();
            if(isset($role) && isset($user)){
                $user->assignRole($role);
                return response()->json([
                    'message' => 'rol asignado exitosamente',
                    'user'    =>  $user,
                    'role'    =>  $role
                ]);
            }else{
                return response()->json([
                    'message' => 'no existe ese rol o usuario',
                ]);
            }
            
        } catch (\Throwable $th) {
    
            return response()->json([
                'message' => $th->getMessage() ,
                'error'    => 'true'
            ]);
           
        }
    }

    public function removerRole(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'role' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->all());
            }
            
            $user = User::find($request->user_id);
            $role = Role::where('name', $request->role)->first();
            
            if(isset($role) && isset($user)){
                $user->removeRole($role);
                return response()->json([
                    'message' => 'rol removido exitosamente',
                    'user'    =>  $user,
                    'role'    =>  $role
                ]);
            }else{
                return response()->json([
                    'message' => 'no existe ese rol o usuario',
                ]);
            }
            
        } catch (\Throwable $th) {
    
            return response()->json([
                'message' => $th->getMessage() ,
                'error'    => 'true'
            ]);
           
        }
    }

    public function asignarPermiso(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'permiso' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->all());
            }
            
            $user = User::find($request->user_id);
            $permiso = Permission::where('name', $request->permiso)->first();
            if(isset($permiso) && isset($user)){
                $user->givePermissionTo($permiso);
                return response()->json([
                    'message' => 'permiso asignado exitosamente',
                    'user'    =>  $user,
                    'permiso'    =>  $permiso
                ]);
            }else{
                return response()->json([
                    'message' => 'no existe ese permiso o usuario',
                ]);
            }
            
        } catch (\Throwable $th) {
    
            return response()->json([
                'message' => $th->getMessage() ,
                'error'    => 'true'
            ]);
           
        }
    }

    public function removerPermiso(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'permiso' => 'required',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->all());
            }
            
            $user = User::find($request->user_id);
            $permiso = Permission::where('name', $request->permiso)->first();
            if(isset($permiso) && isset($user)){
                $user->revokePermissionTo($permiso);
                return response()->json([
                    'message' => 'permiso removido exitosamente',
                    'user'    =>  $user,
                    'permiso'    =>  $permiso
                ]);
            }else{
                return response()->json([
                    'message' => 'no existe ese permiso o usuario',
                ]);
            }
            
        } catch (\Throwable $th) {
    
            return response()->json([
                'message' => $th->getMessage() ,
                'error'    => 'true'
            ]);
           
        }
    }

    public function checkRole(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->all());
            }
            
            $user = User::find($request->user_id);
         
            if(isset($user)){
                $roles = $user->getRoleNames();
                return response()->json([
                    'user'    =>  $user,
                    'roles'    =>  $roles
                ]);
            }else{
                return response()->json([
                    'message' => 'no existe ese usuario',
                ]);
            }
            
        } catch (\Throwable $th) {
    
            return response()->json([
                'message' => $th->getMessage() ,
                'error'    => 'true'
            ]);
           
        }
    }

    public function checkPermisos(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|integer',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors()->all());
            }
            
            $user = User::find($request->user_id);
         
            if(isset($user)){
                $permisos = $user->getAllPermissions()->pluck('name');
                return response()->json([
                    //'user'    =>  $user,
                    'permisos'    =>  $permisos
                ]);
            }else{
                return response()->json([
                    'message' => 'no existe ese usuario',
                ]);
            }
            
        } catch (\Throwable $th) {
    
            return response()->json([
                'message' => $th->getMessage() ,
                'error'    => 'true'
            ]);
           
        }
    }
}
