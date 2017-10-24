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

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/ping', function () use ($router) {
    return response()->json("Pong!", 418);
    // $results = app('db')->select("SELECT * FROM tb_users");
    // return $results;
});


//$router->group(['middleware' => 'cors'], function () use ($router) {

	//User
	$router->get('/user/{id}', 'User@getUser');
	$router->get('/user', 'User@getUsers');
	$router->get('/addUser', 'User@addUser');
	$router->get('/deleteUser/{id}', 'User@delUser');	
	$router->get('/editUser/{id}', 'User@updateUser');

	//Solicitation
	$router->post('/solicitation', 'Solicitation@addSolicitation');
	$router->get('/solicitation', 'Solicitation@getSolicitations');
	$router->get('/solicitation/{id}', 'Solicitation@getSolicitation');
	$router->put('/solicitation/{id}', 'Solicitation@updateSolicitation');

	//Solicitation Votes
	$router->post('/solicitation/{id}/vote', 'Solicitation@voteSolicitation');

//});
