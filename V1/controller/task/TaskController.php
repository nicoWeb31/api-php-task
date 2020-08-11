<?php

require_once('V1/controller/AbstractController.php');
require_once('V1/model/task/TaskManager.php');

class TaskController extends AbstractController

{


    private $manager;
    
    public function __construct(){
        $this->manager = new TaskManager();
    }


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
        //echo "test Task";
        $this->manager->getTask($id);

    }

    public function getTasks()
    {

    }


}