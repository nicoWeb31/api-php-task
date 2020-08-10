<?php

require_once "Response.php";

$resp = new Response();

$resp   ->setSuccess(false)
        ->setHttpStatusCode(404)
        ->addMessages("test message 1")
        ->addMessages("test message 2")
        ->send();
