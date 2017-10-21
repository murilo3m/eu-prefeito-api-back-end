<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;    

class User extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getUser(Request $request, $cpf){
        $user = DB::table('user')
                    ->where('cpf', $cpf)
                    ->first();

        if($user){
            return response()->json(['status' => 'success', 'data' => $user]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'there is no user with this cpf'], 400);
        }

    }

    public function getUsers(){
        $user = DB::table('user')
                    ->orderBy('user_id')
                    ->distinct()->get();
        return response()->json(['data' => $user]);
    }

    public function addUser(Request $request){
        $validator = Validator::make($request->input(), [
            'cpf' => 'required',
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $this->getValidateMessages($validator->messages()->getMessages());
            return response()->json(['status' => 'error', 'message' => $error], 422);
        } else {
            $hasUser =  DB::table('user')
                            ->where('cpf', $request->input('cpf'))
                            ->first();
            if(!$hasUser){
                DB::table('user')->insert([
                    'cpf' => $request->input('cpf'), 
                    'name' => $request->input('name'), 
                    'email' => $request->input('email'), 
                    'phone' => $request->input('phone'), 
                    'password' => md5($request->input('password')),
                    'user_group' => $request->input('user_group'), 
                    'active' => TRUE,
                    'entry_date' => date('Y-m-d H:i'),
                    'update_at' =>  NULL,
                ]);

                return response()->json(['status' => 'success', 'message' => 'user created'], 201);
            } else {
                return response()->json(['status' => 'error', 'message' => 'there is already user with this CPF'], 422);
            }
        }

    }

    public function delUser(Request $request, $cpf){
        $hasUser = DB::table('user')
                    ->where('cpf', $cpf)
                    ->first();

        if($hasUser){ 
            DB::table('user')
            ->where('cpf', $cpf)
            ->update(['active' => FALSE,
                    'update_at' => date('Y-m-d H:i')]);                
            
            return response()->json(['status' => 'success', 'message' => 'user deleted'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'there is no user with this CPF'], 422);
        }

    }

    public function updateUser(Request $request, $cpf){
        $hasUser = DB::table('user')
                    ->where('cpf', $cpf)
                    ->first();

        if($hasUser){
            DB::table('user')
            ->where('cpf', $cpf)                    
            ->update(['name' => $request->input('name'), 
                    'phone' => $request->input('phone'),
                    'password' => $request->input('password'),
                    'email' => $request->input('email'),
                    'user_group' => $request->input('user_group'),
                    'update_at' => date('Y-m-d H:i'),
                    'active' => $request->input('active')]);

            return response()->json(['status' => 'success', 'message' => 'user updated'], 200);
        } else {
            return response()->json(['status' => 'error', 'message' => 'there is no user with this CPF'], 422);
        }
    }
}
