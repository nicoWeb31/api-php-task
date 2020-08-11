<?php


class TaskException extends Exception {} 

class Task 
{
    private $id;
    private $title;
    private $description;
    private $deadline;
    private $completed;




    public function __construct($id,$title,$description,$deadline,$completed)
    {
        // $this->title = $title;
        // $this->description = $description;
        // $this->deadline =$deadline;
        // $this->completed = $completed;
        $this->setId($id);
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setDeadline($deadline);
        $this->setCompleted($completed);
    }
    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        if(($id !== null) && (!is_numeric($id) || $id <= 0 || $id > 9223372036854775807 || $this->id !== null)){

            throw new TaskException("Task ID error");
        }
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        if(strlen($title) < 0 || strlen($title) > 255 ){
            throw new TaskException("task title error");
        }
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {

        if(($description !== null) && (strlen($description) > 16777215 )){
            throw new TaskException("task description error");
        }
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of deadline
     */ 
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set the value of deadline
     *
     * @return  self
     */ 
    public function setDeadline($deadline)
    {
        if(($deadline !== null ) &&  date_format(date_create_from_format('d/m/Y H:i', $deadline),'d/m/Y H:i') !== $deadline){
            throw new TaskException("task deadline time  error");
        }
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get the value of completed
     */ 
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * Set the value of completed
     *
     * @return  self
     */ 
    public function setCompleted($completed)
    {
        if(strtoupper($completed) !== 'Y' && strtoupper($completed) !== 'N' ){
            throw new TaskException("task complited must be Y or N");
        }
        $this->completed = $completed;

        return $this;
    }

    /**
     * function qui retourn un task sous form d'objet
     *
     * @return array
     */
    public function returnTaskArray(){
        $task = [];
        $task['id'] = $this->getId();
        $task['title'] = $this->getTitle();
        $task['descrition'] = $this->getDescription();
        $task['deadline'] = $this->getDeadline();
        $task['completed'] = $this->getCompleted();

        return $task;

    }
}
