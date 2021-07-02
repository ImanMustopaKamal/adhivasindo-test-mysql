<?php

$router->get('/users', 'UsersController@index');
$router->get('/users/{id}', 'UsersController@show');
$router->post('/users', 'UsersController@store');
$router->put('/users/{id}', 'UsersController@update');
$router->delete('/users/{id}', 'UsersController@destroy');