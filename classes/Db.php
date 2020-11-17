<?php
    class Db {
        public static function connect()
        {
            include_once(__DIR__ . "/../settings/settings.php");
    
            $dsn = 'mysql:localhost=' . SETTINGS['db']['host'] . ';dbname=' . SETTINGS['db']['db']; 
            $pdo = new PDO(
                $dsn,
                SETTINGS['db']['user'],
                SETTINGS['db']['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            return $pdo;
        }
?>