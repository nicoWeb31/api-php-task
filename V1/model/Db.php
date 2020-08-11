<?php
require_once('V1/model/Response.php');


class Db
{
    private static $writeDBConnection;
    private static $readDBConnection;

    const DB_USER = 'root';
    const DB_PASSWORD = '';
    const DB_HOST = 'localhost';
    const DB_NAME = 'tasksdb;charset=utf8mb4';


    public static function connectWriteDB()
    {

        try {

            if (self::$writeDBConnection === null) {
                self::$writeDBConnection = new PDO('mysql:host=' . Db::DB_HOST . '; dbname=' . Db::DB_NAME, Db::DB_USER, Db::DB_PASSWORD);
                self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
            return self::$writeDBConnection;
        } catch (PDOException $e) {
            error_log("connection error - " .$e->getMessage(), 0);
            $rep = new Response();
            $rep->setHttpStatusCode(500)
                ->setSuccess(false)
                ->addMessages("database connection error")
                ->send();
                exit();
        }
    }

    public static function connectreadDB()
    {

        try {
            if (self::$readDBConnection === null) {
                self::$readDBConnection = new PDO('mysql:host=' . Db::DB_HOST . '; dbname=' . Db::DB_NAME, Db::DB_USER, Db::DB_PASSWORD);
                self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
            return self::$readDBConnection;
        } catch (PDOException $e) {
            error_log("connection error - " .$e->getMessage(), 0);
            $rep = new Response();
            $rep->setHttpStatusCode(500)
                ->setSuccess(false)
                ->addMessages("database connection error")
                ->send();
            exit();    
        }
    }
}
