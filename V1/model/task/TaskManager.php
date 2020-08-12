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

    public function getTask($id)
    {


        try {
            $query = $this->dbRead->prepare('SELECT id,title,description,DATE_FORMAT(deadline,"%d/%m/%Y %H:%i") as deadline,complited from tbltasks where id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $rowCount = $query->rowCount();


            if ($rowCount === 0) {
                $this->resp->setHttpStatusCode(404)
                    ->setSuccess(false)
                    ->addMessages("Task not found")
                    ->send();
                exit();
            }

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $task = new Task($row['id'], $row['title'], $row['description'], $row['deadline'], $row['complited']);
                $taskArray[] = $task->returnTaskArray();
            }

            $returnData = [];
            $returnData['rows_returned'] = $rowCount;
            $returnData['tasks'] = $taskArray;


            $this->resp->statutTowZeroToCacheOK($returnData);
        } catch (TaskException $e) {
            $this->resp->setHttpStatusCode(500)
                ->setSuccess(false)
                ->addMessages($e->getMessage)
                ->send();
            exit();
        } catch (PDOException $e) {
            error_log("database query error - " . $e, 0);
            $this->resp->setHttpStatusCode(500)
                ->setSuccess(false)
                ->addMessages("faild to take task")
                ->send();
            exit();
        }
    }

    public function getTest($id)
    {
        echo "test" . $id;
    }

    //delete task 
    public function deleteTask($id)
    {
        try {
            $query = $this->dbWrite->prepare('DELETE from tbltasks WHERE id = :id');
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            $query->execute();

            $rowCount = $query->rowCount();

            if ($rowCount === 0) {
                $this->resp->setHttpStatusCode(404)
                    ->setSuccess(false)
                    ->addMessages("Task not found")
                    ->send();
                exit();
            }

            $this->resp->setHttpStatusCode(200)
                ->setSuccess(true)
                ->addMessages("task {$id} deleted with success !")
                ->send();
            exit();
        } catch (PDOException $e) {
            $this->resp->statutFiveZeroZero("faild to delete task");
        }
    }




    /**
     * Recuperation de toute les tasks complete ou impcomplete
     *@param string $complete
     * @return void
     */
    public function getAllCompleteTask($complete)
    {

        try {

            $query = $this->dbRead->prepare('SELECT id,title,description,DATE_FORMAT(deadline,"%d/%m/%Y %H:%i") as deadline,complited from tbltasks WHERE complited = :completed ');
            $query->bindParam(':completed', $complete, PDO::PARAM_STR);
            $query->execute();


            $rowCount = $query->rowCount();

            $taskArray = [];
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $task = new Task($row['id'], $row['title'], $row['description'], $row['deadline'], $row['complited']);
                $taskArray[] = $task->returnTaskArray();
            }

            $returnData = [];
            $returnData['rows_returned'] = $rowCount;
            $returnData['tasks'] = $taskArray;

            $this->resp->statutTowZeroToCacheOK($returnData);
        } catch (TaskException $e) {

            $this->resp->statutFiveZeroZero($e->getMessage());
        } catch (PDOException $e) {

            error_log("database query error - " . $e, 0);
            $this->resp->statutFiveZeroZero("faild to get task");
        }
    }


    /**
     * recupere toute les tasks
     *
     * @return void
     */
    public function getAllTask()
    {

        try {
            $query = $this->dbRead->prepare('SELECT id,title,description,DATE_FORMAT(deadline,"%d/%m/%Y %H:%i") as deadline,complited from tbltasks');
            $query->execute();
            $rowCount = $query->rowCount();

            $taskArray = [];
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $task = new Task($row['id'], $row['title'], $row['description'], $row['deadline'], $row['complited']);
                $taskArray[] = $task->returnTaskArray();
            }
            $returnData = [];
            $returnData['rows_returned'] = $rowCount;
            $returnData['tasks'] = $taskArray;

            $this->resp->statutTowZeroToCacheOK($returnData);
        } catch (TaskException $e) {
            $this->resp->statutFiveZeroZero($e->getMessage());
        } catch (PDOException $e) {
            error_log("database query error - " . $e, 0);
            $this->resp->statutFiveZeroZero("failed to get tasks");
        }
    }

    /**
     * recupere toute les tasks avec pagination de 20 pages
     *
     * @return void
     */
    public function getAllTaskWhitPagi($pagnumber)
    {

        $limitPerPage = 15;

        try {
            $query = $this->dbRead->prepare('SELECT count(id) as totalNoOfTasks from tbltasks');
            $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);
            $taskCount = intval($row['totalNoOfTasks']);

            $numOfPages = ceil($taskCount / $limitPerPage);
            if ($numOfPages == 0) $numOfPages = 1;
            if ($pagnumber > $numOfPages || $numOfPages == 0) Response::statutNotFound("pages doesn't {$pagnumber} exist");


            //start to :
            $offset = ($pagnumber == 1 ? 0 : ($limitPerPage * ($pagnumber - 1)));

            $queryD = $this->dbRead->prepare('SELECT id,title,description,DATE_FORMAT(deadline,"%d/%m/%Y %H:%i") as deadline,complited 
            from tbltasks
            LIMIT :limitTask
            offset :offset
            ');

            $queryD->bindParam(':limitTask', $limitPerPage, PDO::PARAM_INT);
            $queryD->bindParam(':offset', $offset, PDO::PARAM_INT);

            $queryD->execute();
            $rowCount = $query->rowCount();

            $taskArray = [];
            while ($row = $queryD->fetch(PDO::FETCH_ASSOC)) {
                $task = new Task($row['id'], $row['title'], $row['description'], $row['deadline'], $row['complited']);
                $taskArray[] = $task->returnTaskArray();
            }
            $returnData = [];
            $returnData['Total_rows'] = $taskCount;
            $returnData['rows_returned'] = $rowCount;
            $returnData['Total_pages'] = $numOfPages;
            ($pagnumber < $numOfPages ? $returnData['has_a_next_page'] = true : $returnData['has_a_next_page'] = false);
            ($pagnumber > 1 ? $returnData['has_a_previous_page'] = true : $returnData['has_a_previous_page'] = false);




            $returnData['tasks'] = $taskArray;

            $this->resp->statutTowZeroToCacheOK($returnData);
        } catch (TaskException $e) {
            $this->resp->statutFiveZeroZero($e->getMessage());
        } catch (PDOException $e) {
            error_log("database query error - " . $e, 0);
            $this->resp->statutFiveZeroZero("failed to get tasks");
        }
    }


    /**
     * creation d'une task
     *
     * @return void
     */
    public function createTask($title,$description,$deadline,$complete)
    {

        try {
            
            $query = $this->dbWrite->prepare('insert into tbltasks (title,description,deadline,complited) 
            values (:title,:desc, STR_TO_DATE(:deadline,\'%d/%m/%Y %H:%i\'), :completed)');

            $query->bindParam(':title', $title, PDO::PARAM_STR);
            $query->bindParam(':desc', $description, PDO::PARAM_STR);
            $query->bindParam(':deadline', $deadline, PDO::PARAM_STR);
            $query->bindParam(':completed', $complete, PDO::PARAM_STR);

            $query->execute();

            $rowCount = $query->rowCount();
            if($rowCount === 0 ){
                $this->resp->statutFiveZeroZero("failed to create tasks");
            }

            $lastTaskId = $this->dbWrite->lastInsertId();

            $query = $this->dbWrite->prepare('SELECT id, title,description,DATE_FORMAT(deadline,"%d/%m/%Y %H:%i") as deadline,complited
            FROM tbltasks
            WHERE id = :id
            ');

            $query->bindParam(':id', $lastTaskId, PDO::PARAM_INT);
            $query->execute();

            $rowCount = $query->rowCount();
            if($rowCount === 0 ){
                $this->resp->statutFiveZeroZero("failed to retrieve task after creation");
            }



            $taskArray = [];
            while($row = $query->fetch(PDO::FETCH_ASSOC)){
                $task = new Task($row['id'], $row['title'], $row['description'], $row['deadline'], $row['complited']);
                $taskArray[] = $task->returnTaskArray();
            }

            $returnData = [];
            $returnData['rows_returned'] = $rowCount;
            $returnData['tasks'] = $taskArray;

            $resp = new Response();
            $resp->setHttpStatusCode(201)
            ->setSuccess(true)
            ->addMessages("Task created")
            ->setData($returnData)
            ->send();
            exit();



        } catch (TaskException $e) {
            $this->resp->statutFiveZeroZero($e->getMessage());
        } catch (PDOException $e) {
            error_log("database query error - " . $e, 0);
            $this->resp->statutFiveZeroZero("failed to create tasks");
        }
    }
}
