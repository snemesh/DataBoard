<?php
/**
 * Created by PhpStorm.
 * User: snemesh
 * Date: 03.11.16
 * Time: 18:52
 */

namespace my_app;
use backendless\Backendless;
use backendless\model\BackendlessUser;
use my_app\KpiData;
use backendless\BackendlessAutoloader;
use backendless\services\persistence\BackendlessDataQuery;
use DataStore;


include "vendor/backendless/autoload.php";
include "KpiData.php";
include "DataStore.php";
include "getDataFromServer.php";

Backendless::initApp('70518918-F4D9-EA7A-FF91-7E981EF9CF00', '05193E30-2613-A4C8-FFC7-2431B4935800', 'v1');
$curUser = "snemesh@gmail.com";
$curPass = "123";


$user = new BackendlessUser();
$user->setEmail( $curUser );
$user->setPassword( $curPass );

$user = Backendless::$UserService->login( $curUser, $curPass );
if($user->email=!$curUser){
    echo "loginError";
} else {
    echo "Success login <br>";

};

$newDataBlock = new DataStore();



$ress = Backendless::$Persistence->of( 'KpiData ')->find();


//if ($last_rec['totalObjects']==0){
//
//    echo "It's an anmpty table <br>";
//    $myData = getDataFromReport('http://localhost:3000/u9fsyc4mz9g');
//    foreach ($myData as $index=>$col) {
//        $newDataBlock->setProject( $col[0] );
//        $newDataBlock->setNonBil( $col[1] );
//        $newDataBlock->setAssignee( $col[2] );
//        $newDataBlock->setEstimated( $col[3] );
//        $newDataBlock->setSpentTime( $col[4] );
//        $saved_newDataBlock = Backendless::$Persistence->save( $newDataBlock );
//        print_r($saved_newDataBlock);
//    }
//
//
// } else {
//        echo "The base has data. We are starting a process of deleting the information <br>";
//        $res = DeleteLine();
//        print_r($res);
//};




//$myData = getDataFromReport('http://localhost:3000/u9fsyc4mz9g');
//foreach ($myData as $index=>$col) {
//    $newDataBlock->setProject( $col[0] );
//    $newDataBlock->setNonBil( $col[1] );
//    $newDataBlock->setAssignee( $col[2] );
//    $newDataBlock->setEstimated( $col[3] );
//    $newDataBlock->setSpentTime( $col[4] );
//    $saved_newDataBlock = Backendless::$Persistence->save( $newDataBlock );
//}
//
//print_r($saved_newDataBlock);