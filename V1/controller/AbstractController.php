<?php 

require_once('V1/controller/Db.php');
require_once('V1/model/Response.php');



class AbstractController
{
    private $dbWrite;
    private $dbRead;


public function __construct()
{
    $this->dbWrite = Db::connectWriteDB();
    $this->dbRead = Db::connectreadDB();
}


}