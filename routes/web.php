<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
use App\Models\User;
use App\Models\Company;

$router->get('/test-database-connection', function () {
    try {
        $pdo = app('db')->getPdo();
        dd($pdo);
       
    } catch (\Exception $e) {
        return 'Database connection failed: ' . $e->getMessage();
    }
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/entities', function () {
    $user = User::find(1);
    
    $companies = $user->companies;
    dump($companies);    
    
    $company = Company::find(5);
    dump($company->users);
});

 
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/user/register', 'UserController@register');//done
    $router->post('/user/sign-in', 'AuthController@login');//done
    $router->post('/user/recover-password', 'UserController@addResetToken');//done
    $router->patch('/user/recover-password', 'UserController@reset');//done
      
    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/user/companies', 'CompanyController@index');//get user companies
        $router->post('/user/companies', 'CompanyController@createAttach'); //assotiate new companies with user
    });
});
