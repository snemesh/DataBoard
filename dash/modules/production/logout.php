<?php
/**
 * Created by PhpStorm.
 * User: sergeynemesh
 * Date: 13.11.16
 * Time: 04:18
 */
include('../../../getDataFromServer.php');
$userName = $_POST['uname'];
$res = logOutBack($userName);
if ($res==true) {
    echo $userName . " was logout";
} else
    {
        echo "Error logout";
    }