<?php

use function PHPSTORM_META\type;

require_once 'V1/model/task/Task.php';

try{
    $task = new Task(1,"Title1", "description","01/01/2022 12:34", "Y");
    header('Content-type: application/json;charset=utf-8');
    echo json_encode($task->returnTaskArray());

}
catch(TaskException $e){
    echo "Error :" . $e->getMessage() ;
}