<?php
require_once "V1/model/AbstractManager.php";
require_once "V1/model/Response.php";
require_once "V1/model/task/Task.php";

class TaskManager extends AbstractManager
{



    /**
     * fetch task by id
     * 
     */

    public function getTask($id){

        
        try{
            $query = $this->dbRead->prepare('SELECT id,title,description,DATE_FORMAT(deadline,"%d/%m/%Y %H:%i") as deadline,complited from tbltasks where id = :id');
            $query->bindParam(':id',$id,PDO::PARAM_INT);
            $query->execute();
            
            $rowCount = $query->rowCount();


            if($rowCount === 0){
                $this->resp->setHttpStatusCode(404)
                            ->setSuccess(false)
                            ->addMessages("Task not found")
                            ->send();
                exit();            
            }

            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $task = new Task($row['id'],$row['title'],$row['description'],$row['deadline'],$row['complited']);
                $taskArray[] = $task->returnTaskArray();
            }

            $returnData = [];
            $returnData['rows_returned'] = $rowCount;
            $returnData['tasks'] = $taskArray;


            $this->resp->setHttpStatusCode(200)
                        ->setSuccess(true)
                        ->toCache(true)
                        ->setData($returnData)
                        ->send();
            exit();            

        }
        catch(TaskException $e){
            $this->resp->setHttpStatusCode(500)
                        ->setSuccess(false)
                        ->addMessages($e->getMessage)
                        ->send();
            exit();            
        }
        catch(PDOException $e){
            error_log("database query error - " .$e, 0 );
            $this->resp->setHttpStatusCode(500)
                        ->setSuccess(false)
                        ->addMessages("faild to take task")
                        ->send();
            exit();            
        }


    }

    public function getTest($id){
        echo "test" . $id;
    }


}