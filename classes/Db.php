<?php
    class Db{

        public static function connect(){ // word dus toegankelijk zonder dat de klasse geïnstantieerd te worden. 

            include_once(__DIR__ . "/../settings/settings.php");

            $dsn = 'mysql:host=' . SETTINGS['db']['localhost'] . ';dbname=' . SETTINGS['db']['db']; //dsn is voor het connecten van de mysql database, SETTINGS verwijst naar settings:settings.php
            $pdo = new PDO( //opzetten van databank
            $dsn,
            SETTINGS['db']['user'],
            SETTINGS['db']['password'],
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
                 );
         return $pdo;
        }


    }

 ?>