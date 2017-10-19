<?php

namespace App\Http\Controllers;

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

    public function getUser(){
        return response()->json("user!");
    }
}
