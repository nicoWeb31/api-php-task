<?php
require_once("V1/controller/task/TaskController.php");
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
        //var_dump($url);
        switch ($url[0]) {

            case "tasks":
                switch ($url[1]) {

                    case "task":
                        if (!isset($url[3])) {

                            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                                $apiTaskController->getTask((int)$url[2]);
                            } elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {

                                echo "toto PATCTCH";
                            } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                                $apiTaskController->deleteTask((int)$url[2]);
                                //echo "toto delete";
                            } else {
                                Response::methodIsNotAllowed();
                            }
                        }
                        break;


                        //retourne toute les tasks    
                    case "tasks":
                        if (!isset($url[2])) {
                            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                                $apiTaskController->getAllTasks();
                            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                //to do create post
                            } else {
                                Response::methodIsNotAllowed();
                            }
                        }
                        
                        //retourne toute les tasks finish '/Y' or not '/N'    
                        elseif (!isset($url[3])) {
                            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                                $apiTaskController->getAllCompleteTask($url[2]);
                            } else {
                                Response::methodIsNotAllowed();
                            }
                        }
                        elseif( $url[2] == "page" && (!isset($url[4]))){
                            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                            // echo "test page {$url[3]} ";
                                $apiTaskController->getTaskWithPagination((int)$url[3]);
                            }else{
                                Response::methodIsNotAllowed();

                            }
                        }
                        else{
                            Response::statutNotFound("page introuvable");
                        }

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
