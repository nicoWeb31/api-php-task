<?php

require_once('../Db.php');
require_once('../../model/Response.php');

try {
    $writeBb = Db::connectWriteDB();
    $readDB= Db::connectreadDB();
}
catch(Exception $e) {
$response = new Response();
$response->setHttpStatusCode(500)
        ->setSuccess(false)
        ->addMessages("Database connection error :" . $e->getMessage())
        ->send();
        exit;
}