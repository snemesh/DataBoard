<?php

ini_set('display_errors',3);
error_reporting(E_ALL);


include "getDataFromServer.php";
//----------------------------------------
loginToTheSystem("snemesh@gmail.com","123;");

createTableKPI();

//echo createNewDataStoreTable();
//loadDataToExistDataStoreTable();
//echo getAllProjects();
//DeleteDataStore();

//$authRes = loginToTheSystem("snemesh@gmail.com","123");

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
//getAllProjects();


//foreach ($result_collection as $key=>$val)
//{
//    foreach ($val as $index=>$val1){
//        echo $index . " = > " . $val1 . "<br>";
//    }
//}


