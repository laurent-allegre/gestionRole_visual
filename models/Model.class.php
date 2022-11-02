<?php

abstract class Model{
    private static $pdo;

    private static function setBdd(){
        self::$pdo = new PDO("mysql:host=localhost;dbname=gestioncompte;charset=utf8", "root", "");
        self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function getBdd(){
        if(self::$pdo === null){
            self::setBdd();
        }
        return self::$pdo;
    }
}