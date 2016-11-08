<?php

namespace my_app;
use backendless\Backendless;
use backendless\model\BackendlessUser;
use DataStore;

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


function DeleteLine()
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

function loadDataToBase()
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