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
include "Assignee.php";

//----------------------------------------

echo loginToTheSystem();

////Loading data to the Base
//if(!doesTableExists("DataStore")){
//        echo "<br>It's an anmpty table <br>";
//        loadDataToBase();
//    } else {
//        $res = DeleteLine();
//        loadDataToBase();
//};
//projectResults("MCC");
//projectResults("Monodeal MVP Phase 2");
getAllProjects();


//foreach ($result_collection as $key=>$val)
//{
//    foreach ($val as $index=>$val1){
//        echo $index . " = > " . $val1 . "<br>";
//    }
//}


