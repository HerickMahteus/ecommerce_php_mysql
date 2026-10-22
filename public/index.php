<?php
declare(strict_types=1);
session_start();

require __DIR__.'/../app/Core/Database.php';
require __DIR__.'/../app/Core/Controller.php';
foreach (['User','Product','Order'] as $model) require __DIR__.'/../app/Models/'.$model.'.php';
foreach (
    ['User', 'Product', 'Cart', 'Order', 'Auth']
    as $controller
) require __DIR__.'/../app/Controllers/'.$controller.'Controller.php';

$route=$_GET['r']??'products';
$routes=[
 'products'=>[ProductController::class,'index'],'products/create'=>[ProductController::class,'create'],
 'products/store'=>[ProductController::class,'store'],'products/edit'=>[ProductController::class,'edit'],
 'products/update'=>[ProductController::class,'update'],'products/delete'=>[ProductController::class,'delete'],
 'users'=>[UserController::class,'index'],'users/create'=>[UserController::class,'create'],
 'users/store'=>[UserController::class,'store'],'users/edit'=>[UserController::class,'edit'],
 'users/update'=>[UserController::class,'update'],'users/delete'=>[UserController::class,'delete'],
 'cart'=>[CartController::class,'index'],'cart/add'=>[CartController::class,'add'],
 'cart/update'=>[CartController::class,'update'],'cart/remove'=>[CartController::class,'remove'],'cart/clear'=>[CartController::class,'clear'],
 'orders'=>[OrderController::class,'index'],'orders/checkout'=>[OrderController::class,'checkout'],'orders/delete'=>[OrderController::class,'delete'],
 'login' => [AuthController::class, 'loginForm'],
 'login/submit' => [AuthController::class, 'login'],
 'logout' => [AuthController::class, 'logout'],
 ];
if(!isset($routes[$route])){http_response_code(404);exit('Página não encontrada.');}
[$class,$method]=$routes[$route]; $controller=new $class();
$writeRoutes=['products/store','products/update','products/delete','users/store','users/update','users/delete','cart/add','cart/update','cart/remove','cart/clear','orders/checkout','orders/delete'];
if(in_array($route,$writeRoutes,true) && $_SERVER['REQUEST_METHOD']!=='POST'){http_response_code(405);exit('Método não permitido.');}
$controller->$method();
