<?php


use backendless\Backendless;
use backendless\model\BackendlessUser;
use backendless\services\persistence\BackendlessDataQuery;
//use backendless\BackendlessAutoloader;
//use backendless\services\persistence;
use DataStore;
use Assignee;
include "vendor/backendless/autoload.php";

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
        $saved_newDataBlock = Backendless::$Persistence->save(new $newDataBlock);
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
    $saved_newDataBlock = Backendless::$Persistence->save( new $DataStore);

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

function logOutBack($someUser)
{
    try {
        $res = Backendless::$UserService->logout($someUser);
    }
    catch (Exception $ex){
        return $ex;
    }
    return true;
}

function loginToTheSystem($someLogin, $somePass)
{
    Backendless::initApp('70518918-F4D9-EA7A-FF91-7E981EF9CF00', '05193E30-2613-A4C8-FFC7-2431B4935800', 'v1');
    $curUser = $someLogin;
    $curPass = $somePass;

    //echo "curUser => ".$curUser. "  curPass => ". $curPass;
    $user = new BackendlessUser();
    $user->setEmail( $curUser );
    $user->setPassword( $curPass );


    try {

        $res = Backendless::$UserService->login($curUser, $curPass);
    }
    catch(Exception $ex){
        //echo $ex->getMessage();
        $resultOfAuth = false;
        return $resultOfAuth;
    }
//    $user = Backendless::$UserService->login($someLogin, $somePass);
//    $user->setName("Nemesh Sergey");
//    Backendless::$UserService->update( $user );

    if($user->email=!$curUser){
        $resultOfAuth = false;
    } else {
        $resultOfAuth = true;
    }

    $_POST["username"] = $res->name;
    return $resultOfAuth;
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
    echo "Start";
    $query = new BackendlessDataQuery();
    $query->setPageSize(10);

    $result = Backendless::$Data->of( "DataStore" )->find( $query );
    $numberOfLines = $result->totalObjectsCount();
    $pageSize = $result->pageSize();
    echo "Number of line =>" . $numberOfLines . "<br>";
    echo "Page size =>" . $pageSize . "<br>";
    $countOfPages = floor($numberOfLines/$pageSize);
    echo "Number of Pages =>" . $countOfPages . "<br>";
    $res=$result->getAsArrays();
    print_r($res);
    //print_r($result);
    $result->loadNextPage();
    print_r($result);
    //$result->loadNextPage();
    //print_r($result);
    //print_r($result);
    //print_r($result->data[0]->created);

    //echo $result
    //print_r($getProjects);
//    foreach ($result as $key => $val) {
//        print_r( $val);
//        //$result = $result[$key]->project;
//        //echo $result."<br>";
//    }
}

function getListOfProject()
{
    $query = new BackendlessDataQuery();
    $query->setPageSize(10);

    $result = Backendless::$Data->of( "DataStore" )->find( $query );
    $numberOfLines = $result->totalObjectsCount();
    $pageSize = $result->pageSize();
    $countOfPages = floor($numberOfLines/$pageSize);
    $count=0;
    echo "<tbody>";
    $res=$result->getAsObject();

    for ($i=0; $i<=$countOfPages; $i++){
        foreach ($res as $key=>$val)
        {
            $count++;
            echo "<tr class='even pointer'>";
            echo "<td class='a-center '><input type='checkbox' class='flat' name='table_records'></td>";
            echo "<td class=' '>" . $count .  "</td>" ;
            echo "<td class=' '>" . $res[$key]->project .  "</td>" ;
            echo "<td class=' '>" . $res[$key]->assignee . "</td>";
            echo "<td class=' '>" . $res[$key]->nonBil .   "</td>";
            echo "<td class=' '>" . $res[$key]->estimated . "</td>";
            echo "<td class=' '>" . $res[$key]->spentTime . "</td>";
            echo "<td class=' '>" . $res[$key]->created .   "</td>";
            echo "<td class=' last'><a href='#'>View</a></td>";
            echo "</tr>";

        }
        $result->loadNextPage();
        $res=$result->getAsObject();

    }
    echo "</tbody>";

//                        <tbody>
//                        <tr class="even pointer">
//                          <td class="a-center "><input type="checkbox" class="flat" name="table_records"></td>
//                          <td class=" ">121000040</td>
//                          <td class=" ">May 23, 2014 11:47:56 PM </td>
//                          <td class=" ">121000210 <i class="success fa fa-long-arrow-up"></i></td>
//                          <td class=" ">John Blank L</td>
//                          <td class=" ">Paid</td>
//                          <td class="a-right a-right ">$7.45</td>
//                          <td class=" last"><a href="#">View</a>
//                          </td>
//                        </tr>
//                        </tbody>


}

function getListOfProjectPlus()
{
    $query = new BackendlessDataQuery();
    $query->setPageSize(10);
    $result = Backendless::$Data->of( "DataStore" )->find( $query );
    $numberOfLines = $result->totalObjectsCount();
    $pageSize = $result->pageSize();
    $countOfPages = floor($numberOfLines/$pageSize);
    $count=0;
    $res=$result->getAsObject();
    for ($i=0; $i<=$countOfPages; $i++){
        foreach ($res as $key=>$val)
        {
            $count++;
            echo "<tr>";
            echo "<td>" . $count .  "</td>" ;
            echo "<td>" . $res[$key]->project .  "</td>" ;
            echo "<td>" . $res[$key]->assignee . "</td>";
            echo "<td>" . $res[$key]->nonBil .   "</td>";
            echo "<td>" . $res[$key]->estimated . "</td>";
            echo "<td>" . $res[$key]->spentTime . "</td>";
            echo "<td>" . $res[$key]->created .   "</td>";
            echo "</tr>";

        }
        $result->loadNextPage();
        $res=$result->getAsObject();

    }
}

function getTotalHours()
{
    $query = new BackendlessDataQuery();
    $query->setPageSize(10);
    $result = Backendless::$Data->of( "DataStore" )->find( $query );
    $numberOfLines = $result->totalObjectsCount();
    $pageSize = $result->pageSize();
    $countOfPages = floor($numberOfLines/$pageSize);
    $count=0;
    $res=$result->getAsObject();
    $getTotalEstimated=0;$getTotalSpentTime=0;$getNonBillblEstimated=0;$getNonBillblSpentTime=0;
    $getBillblEstimated=0;$getBillblSpentTime=0;

    for ($i=0; $i<=$countOfPages; $i++){
        foreach ($res as $key=>$val)
        {
            $count++;
            //echo $res[$key]->project;
            //echo $res[$key]->assignee;
            //echo $res[$key]->nonBil;
            if($res[$key]->nonBil == "Yes"){
                $getNonBillblEstimated = $getNonBillblEstimated + strval($res[$key]->estimated);
                $getNonBillblSpentTime = $getNonBillblSpentTime + strval($res[$key]->spentTime);
            } else{
                $getBillblEstimated = $getBillblEstimated + strval($res[$key]->estimated);
                $getBillblSpentTime = $getBillblSpentTime + strval($res[$key]->spentTime);
            }
            $getTotalEstimated = $getTotalEstimated + strval($res[$key]->estimated);
            $getTotalSpentTime = $getTotalSpentTime + strval($res[$key]->spentTime);
        }
        $result->loadNextPage();
        $res=$result->getAsObject();
    }
    $getTotalHours = array( "TotalEstimated"=>$getTotalEstimated,
                            "NonBillblEstimated"=>$getNonBillblEstimated,
                            "BillblEstimated"=>$getBillblEstimated,
                            "TotalSpentTime"=>$getTotalSpentTime,
                            "NonBillblSpentTime"=>$getNonBillblSpentTime,
                            "BillblSpentTime"=>$getBillblSpentTime);

    return $getTotalHours;
}