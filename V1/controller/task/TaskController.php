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


    /**
     * recupere all task
     *
     * @return void
     */
    public function getAllTasks()
    {
        $this->manager->getAllTask();
    }



    /**
     * Undocumented function
     *
     * @param int $id
     * @return void
     */
    public function deleteTask($id){
        $this->idIsNunber($id);
        $this->manager->deleteTask($id);

    }


    /**
     * fetch all tash by complete Y or N
     *
     * @param string $complete
     * @return void
     */
    public function getAllCompleteTask($complete){
        $this->IsYorN($complete);
        $this->manager->getAllCompleteTask($complete);
    }


}