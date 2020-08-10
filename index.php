<?php

define("URL", str_replace("index.php", "", (isset($_SERVER['HTTPS']) ? "https" : "http") .
    "://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));

require_once "controllers/front/ApiController.php";
// $apiController = new ApiController();


try {
    if (empty($_GET['page'])) {
        throw new Exception("La page n'existe pas");
    } else {
        $url = explode("/", filter_var($_GET['page'], FILTER_SANITIZE_URL));
        if (empty($url[0]) || empty($url[1])) throw new Exception("La page n'existe pas");
        switch ($url[0]) {
                //routing pour le front
            case "front":
                switch ($url[1]) {
                        //ressource json collection animaux
                    case "animaux":
                        if (!isset($url[2])) {
                            $apiController->getAnimaux();
                        } else if (!isset($url[3])) {
                            $apiController->getAnimauxWithParamConti($url[2]);
                        } else if (!isset($url[4])) {
                            $apiController->getAnimauxWithParam($url[2], (int)$url[3]);
                        }

                        break;

                        //donne une ressorce animal
                    case "animal":
                        if (empty($url[2])) {
                            throw new Exception("La page n'existe pas il manque l'id");
                        }

                        $apiController->getAnimal($url[2]);
                        break;


                        //ressource json collection continent
                    case "continents":
                        $apiController->getContinents();
                        break;

                        //ressource json collection familles
                    case "familles":
                        $apiController->getFamilles();
                        break;

                        //ressource json collection familles
                    case "contact":
                        $apiController->sendContact();
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
