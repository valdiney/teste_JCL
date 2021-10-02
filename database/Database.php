<?php
ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

class Database
{
    private static $pdo;
    
    public static function connect()
    {
        if ( ! isset($pdo))
        {
            try
            {
                self::$pdo = new PDO("pgsql:host=localhost;dbname=teste", "postgres", "33473347",
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            }
            catch (PDOException $e)
            {
                if ($e->getCode() == 2002) {
                    echo "<b>Database configuration Error:</b> This Localhost not exist in this server";
                    exit;
                } elseif ($e->getCode() == 1049) {
                    echo "<b>Database configuration Error:</b> This Database not exist in this server";
                    exit;
                } elseif ($e->getCode() == 1044) {
                    echo "<b>Database configuration Error:</b> Database username not exist in this server";
                    exit;
                } elseif ($e->getCode() == 1045) {
                    echo "<b>Database configuration Error:</b> Database Password are incorrect";
                    exit;
                }
            }
        }

        return self::$pdo;
    }
}

$pdo = Database::connect();