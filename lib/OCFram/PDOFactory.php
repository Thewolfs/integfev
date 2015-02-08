<?php
namespace OCFram;

class PDOFactory
{
  public static function getMysqlConnexion()
  {
    $db = new \PDO('mysql:host=localhost;dbname=integfev', 'root', '', array(\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
    $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    
    return $db;
  }
}