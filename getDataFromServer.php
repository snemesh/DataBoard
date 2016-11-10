<?php

namespace my_app;
use backendless\Backendless;
use backendless\model\BackendlessUser;
use backendless\services\persistence\BackendlessDataQuery;
use backendless\services\persistence;
use DataStore;
use Assignee;


function getDataFromReport($link)
{
    echo ("Start process of getting the data <br>");
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $link);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_USERAGENT, 'PHP');
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    curl_close($ch);
    $obj = json_decode($data);
    echo ("The process of getting data was finished... <br>");
    return $obj->results->data;

}


function DeleteDataStore()
{
    echo ("Start process of deleting the data <br>");
    $url = 'http://api.backendless.com/v1/data/bulk/DataStore?where=created%3E0';
    echo $url;
    echo "<br>";
    $headers = array(
        'application-id: 70518918-F4D9-EA7A-FF91-7E981EF9CF00',
        'secret-key: 05193E30-2613-A4C8-FFC7-2431B4935800'
    );

// Open connection
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


// Execute request
    $result = curl_exec($ch);
// Close connection
    curl_close($ch);

    $asw =json_decode($result, true);
    echo ("The process of deleting data was finished<br>");
    return $asw;
}

function loadDataToExistDataStoreTable()
{
    echo ("Start process of loading data to the base<br>");
    $newDataBlock = new DataStore();
    $myData = getDataFromReport('http://localhost:3000/u9fsyc4mz9g');
    foreach ($myData as $index => $col) {
        $newDataBlock->setProject($col[0]);
        $newDataBlock->setNonBil($col[1]);
        $newDataBlock->setAssignee($col[2]);
        $newDataBlock->setEstimated($col[3]);
        $newDataBlock->setSpentTime($col[4]);
        $saved_newDataBlock = Backendless::$Persistence->save($newDataBlock);
    }
    echo ("The process of loading data to the base was finished<br>");
}

function createNewDataStoreTable()
{
    echo ("Start process of loading data to the base<br>");
    $DataStore = new DataStore();
    $DataStore->setProject("test");
    $DataStore->setNonBil("yes");
    $DataStore->setAssignee("user");
    $DataStore->setEstimated(100);
    $DataStore->setSpentTime(100);
    $saved_newDataBlock = Backendless::$Persistence->save(new $DataStore);

    print_r($saved_newDataBlock);
}

function createTableAssignee(){

    $assignee = new Assignee();
    $assignee->setAssigneeName("user");
    $assignee->setSalary(1000);
    $assignee->setHourlyRate(4.5);
    $saveAssignee = Backendless::$Persistence->save( $assignee );
    return $saveAssignee;
}

function loginToTheSystem()
{

    Backendless::initApp('70518918-F4D9-EA7A-FF91-7E981EF9CF00', '05193E30-2613-A4C8-FFC7-2431B4935800', 'v1');
    $curUser = "snemesh@gmail.com";
    $curPass = "123";

    $user = new BackendlessUser();
    $user->setEmail( $curUser );
    $user->setPassword( $curPass );

    $user = Backendless::$UserService->login( $curUser, $curPass );
    if($user->email=!$curUser){
        return "loginError";
    } else {
        return "Success login <br>";

    };
}

function addAssignee($assigneeUser, $salary, $hourlyRate){
    $assignee = new Assignee();
    $assignee->setAssigneeName($assigneeUser);
    $assignee->setSalary($salary);
    $assignee->setHourlyRate($hourlyRate);
    $saveAssignee = Backendless::$Persistence->save( $assignee );
    return $saveAssignee;
}

function doesTableExists($someTable){
    $ress = Backendless::$Data->of($someTable)->find()->getAsObject();
    if(!$ress) {
        return false; //The table doesn't exist
    }
    return true; // The table exist;

}

function projectResults($someProjectName)
{
    $sumOfSpentTime = 0;
    $sumOfestimated = 0;
    $projectName = '';

    $query = new BackendlessDataQuery();
    $clause = "project = '$someProjectName'";
    $query->setWhereClause($clause);
    $result_collection = Backendless::$Persistence->of('DataStore')->find($query)->getAsObject();

    foreach ($result_collection as $key => $val) {
        $projectName = $result_collection[$key]->project;
        $spentTime = $result_collection[$key]->spentTime;
        $estimated = $result_collection[$key]->estimated;

        $spentTime = strval($spentTime);
        $sumOfSpentTime = $sumOfSpentTime + $spentTime;
        $estimated = strval($estimated);
        $sumOfestimated = $sumOfestimated + $estimated;
    }
    echo $projectName . "<br>";
    echo $sumOfSpentTime . "<br>";
    echo $sumOfestimated . "<br>";
}

function getAllProjects(){

    $getProjects = Backendless::$Persistence->of('DataStore')->find()->getAsObject();
    print_r($getProjects);
    foreach ($getProjects as $key => $val) {
        $projectName = $getProjects[$key]->project;
        echo $projectName."<br>";
    }
}

