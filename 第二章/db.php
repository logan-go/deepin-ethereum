<?php
require_once "./config.php";

class db extends PDO{
    public function __construct(){
        $dsn = "mysql:host=" . MYSQL_HOST . ";dbname=" . MYSQL_DATABASE;
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        );

        return parent::__construct($dsn,MYSQL_USERNAME,MYSQL_PASSWORD,$options);
    }
}
