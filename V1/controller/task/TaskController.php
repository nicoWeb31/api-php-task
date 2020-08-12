<?php

require_once('V1/controller/AbstractController.php');
require_once('V1/model/task/TaskManager.php');
require_once("V1/model/Response.php");

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


    

    /**
     * fetch all tash by complete Y or N
     *
     * @param int $PageNumber
     * @return void
     */
    public function getTaskWithPagination($PageNumber){
        $this->idIsNunber($PageNumber);
        $this->manager->getAllTaskWhitPagi($PageNumber);
    }

     /**
     * fetch all tash by complete Y or N
     *
     * @param int $PageNumber
     * @return void
     */
    public function createTask(){

        $rowPostData = file_get_contents('php://input');

        // var_dump($rowPostData);
        // var_dump(json_decode($rowPostData));

        if(!$jsonData =  json_decode($rowPostData)){
            Response::contentTypeErr("Request body is not valid !");
        }

        if(!isset($jsonData->title) || !isset($jsonData->complited)){
            Response::contentTypeErr(
                (!isset($jsonData->title) ? "Title field is mandatory and must be provided" : "complited field is mandatory and must be provided")
            );
        }
        $newTask = new Task(null,$jsonData->title,(isset($jsonData->description) ? $jsonData->description : null),
            (isset($jsonData->deadline) ? $jsonData->deadline : null),$jsonData->complited);
        

        //var_dump($newTask);
        $title = $newTask->getTitle();
        $description = $newTask->getDescription();
        $deadline = $newTask->getDeadline();
        $complete = $newTask->getCompleted();




        $this->manager->createTask($title,$description,$deadline,$complete);
    }



}