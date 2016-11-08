<?php
/**
 * Created by PhpStorm.
 * User: snemesh
 * Date: 03.11.16
 * Time: 15:25
 */

namespace my_app;
use backendless\Backendless;
use backendless\model\BackendlessUser;
use my_app\KpiData;
use backendless\BackendlessAutoloader;
use backendless\services\persistence\BackendlessDataQuery;

include "vendor/backendless/autoload.php";
include "KpiData.php";


Backendless::initApp('70518918-F4D9-EA7A-FF91-7E981EF9CF00', '05193E30-2613-A4C8-FFC7-2431B4935800', 'v1');

$curUser = "snemesh@gmail.com";
$curPass = "123";


$user = new BackendlessUser();
$user->setEmail( $curUser );
$user->setPassword( $curPass );

    $user = Backendless::$UserService->login( $curUser, $curPass );
    if($user->email=!$curUser){
        echo "loginError";
    };
    print_r($user);

//Backendless::$Persistence->save( new KpiData('SomeProject','SomeUser',200));

//if ($registered_user = Backendless::$UserService->register($user)){
//    echo "User wes registred";
//};


//$query = new BackendlessDataQuery();
//$query->setWhereClause('spentTime > 147');
//
//
//$result_collection = Backendless::$Persistence->of("KpiData")->find($query);
//print_r($result_collection);