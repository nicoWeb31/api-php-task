<?php
require_once('V1/model/Response.php');



class AbstractController
{

    public function idIsNunber($id)
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

    public function IsYorN($complete){
        if($complete !== "Y" && $complete !== "N"){
            $res = new Response();
            $res->setHttpStatusCode(400)
                ->setSuccess(false)
                ->addMessages("complete filter must be Y or N")
                ->send();
            exit();    
        }
    }
}
