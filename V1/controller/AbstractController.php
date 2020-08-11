<?php



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
}
