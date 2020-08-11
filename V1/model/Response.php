<?php 


class Response 
{
    private $_success;
    private $_httpStatusCode;
    private $_messages = [];
    private $_data;
    private $_toCache = false;
    private $_responseData = [];



    /**
     * Set the value of _success
     *
     * @return  self
     */ 
    public function setSuccess($success)
    {
        $this->_success = $success;

        return $this;
    }


    /**
     * Set the value of _httpStatusCode
     *
     * @return  self
     */ 
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->_httpStatusCode = $httpStatusCode;

        return $this;
    }

    /**
     * Set the value of _messages
     *
     * @return  self
     */ 
    public function addMessages($messages)
    {
        $this->_messages[] = $messages;

        return $this;
    }

    /**
     * Set the value of _data
     *
     * @return  self
     */ 
    public function setData($data)
    {
        $this->_data = $data;

        return $this;
    }

    /**
     * Set the value of _toCache
     *
     * @return  self
     */ 
    public function ToCache($_toCache)
    {
        $this->_toCache = $_toCache;

        return $this;
    }

    /**
     * Set the value of _responseData
     *
     * @return  self
     */ 
    public function send()
    {
        header('Content-type: application/json;charset=utf-8');
        // if($this->_toCache){
        //     header('Cache-control: max-age=60');
        // }
        // else header('Cache-control:no-cache,no-store');
        $this->_toCache ? header('Cache-control: max-age=60') : header('Cache-control: max-age=60');

        if(($this->_success !== false && $this->_success !== true ) || !is_numeric($this->_httpStatusCode)){
            http_response_code(500);
            $this->_responseData['statusCode'] = 500;
            $this->_responseData['success'] = false;
            $this->addMessages("Response creation error");


            $this->_responseData['messages'] = $this->_messages;


        }else{
            http_response_code($this->_httpStatusCode);
            $this->_responseData['statusCode'] = $this->_httpStatusCode;
            $this->_responseData['success'] = $this->_success;
            $this->_responseData['messages'] = $this->_messages;
            $this->_responseData['data'] = $this->_data;
            
        }

        echo json_encode($this->_responseData);



    }

    public static function methodIsNotAllowed(){

        $resp = new Response();
        $resp->setHttpStatusCode(405)
            ->setSuccess(false)
            ->addMessages("Request methode not allowed")
            ->send();
    }


}