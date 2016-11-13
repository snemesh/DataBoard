<?php
namespace backendless\model;

use backendless\Backendless;

function authorization($login, $password) {
//устанавливаем начальное значение авторизации
    $user_login=FALSE;
//запрос к базе данных
    Backendless::initApp('70518918-F4D9-EA7A-FF91-7E981EF9CF00', '05193E30-2613-A4C8-FFC7-2431B4935800', 'v1');
    $curUser = $login;
    $curPass = $password;

    $user = new BackendlessUser();
    $user->setEmail( $curUser );
    $user->setPassword( $curPass );

    $user = Backendless::$UserService->login( $curUser, $curPass );
    if($user->email=!$curUser){
        $_SESSION['auth']=FALSE;
        $user_login=FALSE;

    } else {
        $_SESSION['auth']=TRUE;
        $_SESSION['user_id']=$login;
        $user_login=TRUE;

    };
    return $user_login;
}