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
        
        $this->idIsNunber($id);
        $this->manager->getTask($id);

    }

    public function getTasks()
    {

    }

    public function deleteTask($id){
        $this->idIsNunber($id);
        $this->manager->deleteTask($id);

    }

    public function getAllCompleteTask($complete){
        $this->IsYorN($complete);
        $this->manager->getAllCompleteTask($complete);
    }


}