<?php

ini_set('display_errors',3);
error_reporting(E_ALL);


include "getDataFromServer.php";
//----------------------------------------
loginToTheSystem("snemesh@gmail.com","123;");
echo "Login Success!<br>";
DeleteDataStore(); //удаляем предвариетльно все данные с таблицы DataStore на beckendLess
echo "Delete data - Success!<br>";
loadDataToExistDataStoreTable(); // загрузка данных в табицу DataStore
echo "Lead data from Jira - Success!<br>";
createTableKPI("none"); //добавляем данные в табличку с KPI
echo "Create KPI data - Success!<br>";

//$totalPM= getTotalPM();
//echo $totalNonBillSpent[0]."<br>";
//echo $totalNonBillSpent[1]."<br>";

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


