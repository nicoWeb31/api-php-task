<?php

require_once('V1/model/Task.php');
require_once('V1/controller/AbstractController.php');

class TaskController extends AbstractController

{

    public function getTask($id)
    {
        if($id == '' || !is_numeric($id)){
            $res = new Response();
            $res->setHttpStatusCode(400)
                ->setSuccess(false)
                ->addMessages("Task ID cannot be blank or must be numeric")
                ->send();
            exit();    
        }
    }

    public function getTasks()
    {

    }


}