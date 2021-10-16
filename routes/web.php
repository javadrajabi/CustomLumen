<?php

/** @var \Laravel\Lumen\Routing\Router $router */




$router->group(['prefix' => 'user'], function () use ($router) {
    $router->post('/login', [
        'as' => 'sms-login', 'uses' => 'Auth\SMSAuthController@signIn'
    ]);
    $router->post('/send-code', [
        'as' => 'send-code', 'uses' => 'Auth\SMSAuthController@sendCode'
    ]);



});

//$router->group(['prefix' => 'auth'], function () use ($router) {
//    $router->get('/login', [
//        'as' => 'login', 'uses' => 'AuthController@login'
//    ]);
//});

//$router->group(['prefix' => 'user'], function () use ($router) {
//    $router->get('/login', [
//        'as' => 'login', 'uses' => 'UserController@show'
//    ]);
//});

//$router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
//    $router->get('/info', [
//        'as' => 'login', 'uses' => 'UserController@show'
//    ]);
//});
$router->group(['prefix' => 'member', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/get-profile', [
        'as' => 'login', 'uses' => 'Member\MemberController@getProfile'
    ]);
    $router->get('/get-appointment-list', [
        'as' => 'login', 'uses' => 'Member\MemberController@getAppointmentList'
    ]);
    $router->get('/get-notification-list', [
        'as' => 'login', 'uses' => 'Member\MemberController@getNotificationList'
    ]);
    $router->get('/test', [
//    'middleware' => ['after-res'],
        'as' => 'test',
        'uses' => 'TestController@test'
    ]);
});
$router->post('/test', [
//    'middleware' => ['after-res'],
    'as' => 'test',
    'uses' => 'TestController@test'
]);


//$router->group([
//        'middleware' => 'api',
//        'prefix' => 'auth'
//    ], function ($router) {



////        $router->post('signin', [SMSAuthController::class, 'signIn']);
//        $router->post('sendcode', [SMSAuthController::class, 'sendCode']);
//        $router->get('refreshtoken', [SMSAuthController::class, 'refreshToken']);
//        $router->get('logout', [SMSAuthController::class, 'logOut']);
//
//    });

//    $router->group([
//        'middleware' => 'auth:api',
//        'prefix' => 'app'
//    ], function ($router) {
//        $router->get('last-assign', [DeviceController::class, 'lastState']);
//        $router->get('device-list', [DeviceController::class, 'deviceList']);
//        $router->get('reset-device', [DeviceController::class, 'resetDevice']);
//    });



//$router->get('/', function () use ($router) {
//    return $router->app->version();
//});
//
//$router->get('/user', [
//    'as' => 'user', 'uses' => 'UserController@show'
//]);

// $router->get(
//     '/user',
//     [UserController::class, 'show']
// );
