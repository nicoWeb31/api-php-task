<?php
require_once('V1/model/Db.php');
require_once "V1/model/Response.php";


class AbstractManager
{

    protected $dbWrite;
    protected $dbRead;
    protected $resp;


    public function __construct()
    {
        $this->dbWrite = Db::connectWriteDB();
        $this->dbRead = Db::connectreadDB();
        $this->resp = new Response();

    }

    


}
