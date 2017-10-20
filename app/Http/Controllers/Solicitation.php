<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;    

class Solicitation extends Controller
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

    public function addSolicitation(Request $request){
        $validator = Validator::make($request->input(), [
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',           
        ]);

        if ($validator->fails()) {
            $error = $this->getValidateMessages($validator->messages()->getMessages());
            return response()->json(['message' => $error], 422);
        } else {
            DB::table('solicitation')->insert([
                'user_id' => 10, 
                'adm_id' => 10, 
                'name' => $request->input('name'), 
                'category' => $request->input('category'), 
                'description' => $request->input('description'),
                'picture' => $request->input('picture'),
                'geolocalization' => $request->input('geolocalization'),
                'status' => $request->input('status'),
                'entry_date' => date('Y-m-d H:i'),
                'update_at' =>  NULL,
            ]);
        }

        return response()->json(['message' => 'solicitation created'], 201);
    }    
}
