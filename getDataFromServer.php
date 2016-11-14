<?php


use backendless\Backendless;
use backendless\model\BackendlessUser;
use backendless\services\persistence\BackendlessDataQuery;
//use backendless\BackendlessAutoloader;
//use backendless\services\persistence;
//use DataStore;
//use Assignee;
require_once( "KpiTable.php" );
require_once( "DataStore.php" );
require_once( "Assignee.php" );
include "vendor/backendless/autoload.php";




function rm_from_array($needle, &$array, $all = true){
    if(!$all){
        if(FALSE !== $key = array_search($needle,$array)) unset($array[$key]);
        return;
    }
    foreach(array_keys($array,$needle) as $key){
        unset($array[$key]);
    }
}

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

function DeleteKpiTable()
{
    $url = 'http://api.backendless.com/v1/data/bulk/kpiTable?where=created%3E0';
    $headers = array(
        'application-id: 70518918-F4D9-EA7A-FF91-7E981EF9CF00',
        'secret-key: 05193E30-2613-A4C8-FFC7-2431B4935800'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $asw =json_decode($result, true);
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

function createNewDataStoreTable() //функция для создания таблицы DataStore с тестовыми данными на случай удаления
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

function createTableAssignee() //функция для создания таблицы Assignee с тестовыми данными на случай удаления
{
    $assignee = new Assignee();
    $assignee->setAssigneeName("user");
    $assignee->setSalary(1000);
    $assignee->setHourlyRate(4.5);
    $saveAssignee = Backendless::$Persistence->save(new $assignee );
    return $saveAssignee;
}

function logOutBack($someUser) //вылогинить пользователя из системы
{
    try {
        $res = Backendless::$UserService->logout($someUser);
    }
    catch (Exception $ex){
        return $ex;
    }
    return true;
}

function loginToTheSystem($someLogin, $somePass) //логин пользрвателя в систему
{
    Backendless::initApp('70518918-F4D9-EA7A-FF91-7E981EF9CF00', '05193E30-2613-A4C8-FFC7-2431B4935800', 'v1');
    $curUser = $someLogin;
    $curPass = $somePass;
    $user = new BackendlessUser();
    $user->setEmail( $curUser );
    $user->setPassword( $curPass );
    try {

        $res = Backendless::$UserService->login($curUser, $curPass);
    }
    catch(Exception $ex){
        $resultOfAuth = false;
        return $resultOfAuth;
    }
    if($user->email=!$curUser){
        $resultOfAuth = false;
    } else {
        $resultOfAuth = true;
    }
    $_POST["username"] = $res->name;
    return $resultOfAuth;
}



function addAssignee($assigneeUser, $salary, $hourlyRate) //добавить данные с рейтами в таличку Assignee
{
    $assignee = new Assignee();
    $assignee->setAssigneeName($assigneeUser);
    $assignee->setSalary($salary);
    $assignee->setHourlyRate($hourlyRate);
    $saveAssignee = Backendless::$Persistence->save( $assignee );
    return $saveAssignee;
}

function doesTableExists($someTable){ //проверить существует ли табличка в системе
    echo "Cheking the table ". $someTable . "<br>";
    try {
        Backendless::$Data->of($someTable)->find()->getAsObject();
    }
    catch (Exception $ex){
        echo "The table dosen't exist";
        return false;
    }
    return true; // The table exist;

}

function projectResults($someProjectName) //посчиать промежуточные результаты из DataStore
{                                         // по определенному проекту
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

function getAllProjects(){ //прлучить все записи таблицы DataStore и посчитать сколько
    echo "Start";          //в таблицу количество строк, количесство строк на странице
    $query = new BackendlessDataQuery(); //количество страниц
    $query->setPageSize(10);

    $result = Backendless::$Data->of( "DataStore" )->find( $query );
    $numberOfLines = $result->totalObjectsCount();
    $pageSize = $result->pageSize();
    echo "Number of line =>" . $numberOfLines . "<br>";
    echo "Page size =>" . $pageSize . "<br>";
    $countOfPages = floor($numberOfLines/$pageSize);
    echo "Number of Pages =>" . $countOfPages . "<br>";
}

function getListOfProject() //получить список данных из таблички DataStore и вывести их ввиде таблтчки
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

}

function getListOfProjectPlus() // получить данные из DataStore и вывести их на фронте
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

function getTotalHours() //посчитать основные показатели в тадичке DataStore, возвращает масив данных
{                        // с TotalEstimated - кол-во заэкстимеченых часов, TotalSpentTime...
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
            $getTotalProjectsTmp[]=$res[$key]->project;
            $getTotalPMTmp[]=$res[$key]->assignee;

        }
        $result->loadNextPage();
        $res=$result->getAsObject();
    }
    $getTotalProjects = array_unique($getTotalProjectsTmp);
    $getTotalProjects = count($getTotalProjects);

    $getTotalPM = array_unique($getTotalPMTmp);
    rm_from_array("-", $getTotalPM, true);
    $getTotalPM = count($getTotalPM);

    $getTotalHours = array( "TotalEstimated"=>$getTotalEstimated,
                            "NonBillblEstimated"=>$getNonBillblEstimated,
                            "BillblEstimated"=>$getBillblEstimated,
                            "TotalSpentTime"=>$getTotalSpentTime,
                            "NonBillblSpentTime"=>$getNonBillblSpentTime,
                            "BillblSpentTime"=>$getBillblSpentTime,
                            "TotalProjects"=>$getTotalProjects,
                            "TotalPM"=>$getTotalPM);

    return $getTotalHours;

}

function createTableKPI($doDelete){
//if you need to delete existed data in the table,
// please specify 'delete' argument like a parameter for the function
    $getKPI = getTotalHours(); // высчитываем основные показатели из таблички DataStore, получаем массив
                               // с данными
    $kpiTable = new KpiTable();
    $kpiTable->setTotalEstimated($getKPI["TotalEstimated"]);
    $kpiTable->setNonBillblEstimated($getKPI["NonBillblEstimated"]);
    $kpiTable->setBillblEstimated($getKPI["BillblEstimated"]);

    $kpiTable->setTotalSpentTime($getKPI["TotalSpentTime"]);
    $kpiTable->setNonBillblSpentTime($getKPI["NonBillblSpentTime"]);
    $kpiTable->setBillblSpentTime($getKPI["BillblSpentTime"]);
    $kpiTable->setTotalProjects($getKPI["TotalProjects"]);
    $kpiTable->setTotalPM($getKPI["TotalPM"]);


    if(doesTableExists("KpiTable")==true){
        if ($doDelete=="delete") {
            DeleteKpiTable();
        }
        $saveKpiTable = Backendless::$Persistence->save($kpiTable); //сохраняем в табличку
    } else {
        $saveKpiTable = Backendless::$Persistence->save(new $kpiTable); //создаем табличку и сохраняем
    }

}

function getTotalEstimatedHours(){ //получаем totalEstimated из KpiTable
    $query = new BackendlessDataQuery();
    $result = Backendless::$Data->of( "KpiTable" )->find( $query )->getAsObject();
    foreach ($result as $key=>$val) {
        $ressult[] = $result[$key]->totalEstimated;
    }
    return $ressult;
}

function getTotalSpentHours(){ //получаем totalSpentTime из KpiTable
    $query = new BackendlessDataQuery();
    $result = Backendless::$Data->of( "KpiTable" )->find( $query )->getAsObject();
    foreach ($result as $key=>$val) {
        $ressult[] = $result[$key]->totalSpentTime;
    }
    return $ressult;
}


function getTotalSpentBill(){ //получаем billblSpentTime из KpiTable
    $query = new BackendlessDataQuery();
    $result = Backendless::$Data->of( "KpiTable" )->find( $query )->getAsObject();
    foreach ($result as $key=>$val) {
        $ressult[] = $result[$key]->billblSpentTime;
    }
    return $ressult;
}
function getTotalSpentNonBill(){
    $query = new BackendlessDataQuery();
    $result = Backendless::$Data->of( "KpiTable" )->find( $query )->getAsObject();
    foreach ($result as $key=>$val) {
        $ressult[] = $result[$key]->nonBillblSpentTime;
    }
    return $ressult;
}
function getTotalPM(){
    $query = new BackendlessDataQuery();
    $result = Backendless::$Data->of( "KpiTable" )->find( $query )->getAsObject();
    foreach ($result as $key=>$val) {
        $ressult[] = $result[$key]->totalPM;
    }
    return $ressult;
}

function getTotalProjects(){
    $query = new BackendlessDataQuery();
    $result = Backendless::$Data->of( "KpiTable" )->find( $query )->getAsObject();
    foreach ($result as $key=>$val) {
        $ressult[] = $result[$key]->totalProjects;
    }
    return $ressult;
}

