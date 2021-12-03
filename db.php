<?php

class db {
    public function connect()
    {
        $host = '127.0.0.1';
        $db = 'test';
        $user = 'root';
        $pass = '';
        $charset = 'utf8';
        $dbconnect = "mysql:host=$host;dbname=$db;charset=$charset";
        return new PDO($dbconnect, $user, $pass);
    }
}