<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;


// setup the autoloading
require_once 'vendor/autoload.php';


// setup Propel
require_once 'kpiapp/generated-conf/config.php';

$defaultLogger = new Logger('defaultLogger');
$defaultLogger->pushHandler(new StreamHandler('/var/log/propel.log', Logger::WARNING));

$serviceContainer->setLogger('defaultLogger', $defaultLogger);



$myKpiData = new myAssignee();
$myKpiData->setassigneeName("Nemesh Sergey");
$myKpiData->setId("");
$myKpiData->sethourlyRate(3.33);
$myKpiData->setSalary(4.324);
$myKpiData->save();


