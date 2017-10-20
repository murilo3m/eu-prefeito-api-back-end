<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    //Validation
    public function getValidateMessages($messages){
        $error = '';
        foreach ($messages as $message) {
            $error .= $message[0] . ' / ';
        }

        $error = rtrim($error, ' / ');

        return $error;
    }
}
