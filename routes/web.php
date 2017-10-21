<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/ping', function () use ($router) {
    return response()->json("Pong!", 418);
    // $results = app('db')->select("SELECT * FROM tb_users");
    // return $results;
});


$router->group(['middleware' => 'auth'], function () use ($router) {

	//User
	$router->get('/user/{id}', 'User@getUser');
	$router->get('/user', 'User@getUsers');
	$router->post('/user', 'User@addUser');
	$router->delete('/user/{id}', 'User@delUser');	
	$router->put('/user/{id}', 'User@updateUser');

	//Solicitation
	$router->post('/solicitation', 'Solicitation@addSolicitation');
	$router->get('/solicitation', 'Solicitation@getSolicitations');
	$router->get('/solicitation/{id}', 'Solicitation@getSolicitation');
	$router->put('/solicitation/{id}', 'Solicitation@updateSolicitation');

});
