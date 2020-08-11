<?php
require_once("V1/controller/TaskController.php");
require_once("V1/model/Response.php");

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));


$apiTaskController = new TaskController();



try {
    if (empty($_GET['page'])) {
        throw new Exception("La page n'existe pas");
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        if (empty($url[0]) || empty($url[1])) throw new Exception("La page n'existe pas");
        switch ($url[0]) {

            case "tasks":
                switch ($url[1]) {

                    case "task":
                        if (!isset($url[3])) {
                            if((int)$url[2] == "" || !is_numeric((int)$url[2])){
                                $resp = new Response();
                                $resp->setHttpStatusCode(400)
                                    ->setSuccess(false)
                                    ->addMessages("Task ID cannot be blank or must be numeric")
                                    ->send();
                                exit;    
                            }
                            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                                    echo "toto";
                                    //todo get method//
                                
                            }

                            elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
                                //$apiTaskController->getTask((int)$url[2]);
                                echo "toto PATCTCH";
                            }

                            elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                                //$apiTaskController->getTask((int)$url[2]);
                                echo "toto delete";
                            }else
                            
                            {
                                $resp = new Response();
                                $resp->setHttpStatusCode(405)
                                        ->setSuccess(false)
                                        ->addMessages("Request methode not allowed")
                                        ->send();

                            }
                        }
                        break;

                    case "all":

                        // todo method gettasks
                        echo "toto get task SSS";
                        break;


                    default:
                        throw new Exception("La page n'existe pas");
                }
                break;
                //routeur pour le page du back
            case "back":
                echo "page back end demandée";
                break;
            default:
                throw new Exception("La page n'existe pas");
        }
    }
} catch (Exception $e) {
    $msg = $e->getMessage();
    echo $msg;
}
