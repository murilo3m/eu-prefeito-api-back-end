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
        $customer = DB::table('user')
                    ->where('cpf', $cpf)
                    ->first();
        // var_dump($customer);die;
        // return response()->json("user!");
        return response()->json($customer);                
    }

    public function getUsers(){
        $customer = DB::table('user')
                    ->orderBy('user_id')
                    ->distinct()->get();
        return response()->json($customer);                
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
            return response()->json(['message' => $error], 422);
        } else {
            DB::table('user')->insert([
                'cpf' => $request->input('cpf'), 
                'name' => $request->input('name'), 
                'email' => $request->input('email'), 
                'phone' => $request->input('phone'), 
                'password' => md5($request->input('password')),
                'active' => TRUE,
                'entry_date' => date('Y-m-d H:i'),
                'update_at' =>  NULL,
            ]);
        }

        return response()->json(['message' => 'user created'], 201);
    }

    public function delUser(Request $request, $cpf){
        $customer = DB::table('user')
                    ->where('cpf', $cpf)
                    ->update(['active' => FALSE]);                

        return response()->json(['message' => 'user deleted'], 200);           
    }
}
