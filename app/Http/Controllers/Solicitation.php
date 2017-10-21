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
            'status' => 'required',       
        ]);

        if ($validator->fails()) {
            $error = $this->getValidateMessages($validator->messages()->getMessages());
            return response()->json(['message' => $error], 422);
        } else {
            DB::table('solicitation')->insert([
                'user_id' => $request->input('user_id'),                
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

    public function getSolicitations(){
        $solicitation = DB::table('solicitation')
        ->orderBy('user_id')
        ->distinct()->get();
        return response()->json($solicitation);                
    }

    public function getSolicitation(Request $request, $id){
        $solicitation = DB::table('solicitation')
        ->where('solicitation_id', $id)
        ->first();
        
        if ($solicitation){
            return response()->json($solicitation);    
        }else{
            return response()->json(['message' => 'there is no solicitation'], 400);
        }        
    }

    public function updateSolicitation(Request $request, $id){

        $hasUser = DB::table('solicitation')
        ->where('solicitation_id', $id)
        ->first();

        if($hasUser){
            DB::table('solicitation')
            ->where('solicitation_id', $id)                    
            ->update(['name' => $request->input('name'), 
                'category' => $request->input('category'),
                'description' => $request->input('description'),
                'picture' => $request->input('picture'),
                'geolocalization' => $request->input('geolocalization'),
                'status' => $request->input('status'),
                'update_at' => date('Y-m-d H:i')]);

            return response()->json(['message' => 'solicitation updated'], 200);
        } else {
            return response()->json(['message' => 'there is no solicitation with this id'], 422);
        }
    }

    public function voteSolicitation(Request $request, $id){
        $validator = Validator::make($request->input(), [
            'vote' => 'required',            
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            $error = $this->getValidateMessages($validator->messages()->getMessages());
            return response()->json(['message' => $error], 422);
        } else {
            DB::table('solicitation_votes')->insert([
                'solicitation_id' => $request->input('solicitation_id'),                
                'user_id' => $request->input('user_id'), 
                'vote' => $request->input('vote'),
                'entry_date' => date('Y-m-d H:i'),
            ]);
        }

        return response()->json(['message' => 'vote created'], 201);
    }
}
