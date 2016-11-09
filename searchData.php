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

////Loading data to the Base
//$ress = Backendless::$Data->of( 'DataStore ')->find()->getAsObject();
//if(!$ress){
//        echo "<br>It's an anmpty table <br>";
//        loadDataToBase();
//    } else {
//        $res = DeleteLine();
//        loadDataToBase();
//};

$ress = Backendless::$Data->of( 'DataStore ')->find()->getAsObject();
$query = new BackendlessDataQuery();
$query->setWhereClause("project = 'MCC'");
$result_collection = Backendless::$Persistence->of( 'DataStore' )->find( $query )->getAsObject();
//print_r($result_collection);
//echo $result_collection[0]->project;
$sumOfSpentTime=0;
$sumOfestimated=0;
$projectName ='';
foreach ($result_collection as $key=>$val) {
    $projectName = $result_collection[$key]->project;
    $spentTime =  $result_collection[$key]->spentTime;
    $estimated = $result_collection[$key]->estimated;
    $assignee = $result_collection[$key]->assignee;
    $spentTime = strval($spentTime);
    $sumOfSpentTime = $sumOfSpentTime + $spentTime;
    $estimated = strval($estimated);
    $sumOfestimated = $sumOfestimated + $estimated;
}
echo $projectName .  "<br>";
echo $sumOfSpentTime . "<br>";
echo $sumOfestimated . "<br>";

//foreach ($result_collection as $key=>$val)
//{
//    foreach ($val as $index=>$val1){
//        echo $index . " = > " . $val1 . "<br>";
//    }
//}


