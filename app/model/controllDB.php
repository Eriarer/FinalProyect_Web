<?php
/*
Estructura de la tabla productos:
Field: prod_id - Type: int(6)
Field: prod_name - Type: varchar(255)
Field: prod_description - Type: text
Field: prod_imgPath - Type: varchar(255)
Field: prod_stock - Type: int(11)
Field: prod_precio - Type: float
Field: prod_descuento - Type: float
*/
class dataBase {

  private $connexion;
  private $host;
  private $user;
  private $pass;
  private $db;
  private $config;

  public function __construct($credentials, $config) {
    $this->host = $credentials['host'];
    $this->user = $credentials['user'];
    $this->pass = $credentials['pass'];
    $this->db = $credentials['db'];
    $this->config = $config;
    $this->connexion = new mysqli($this->host, $this->user, $this->pass, $this->db);
    if ($this->connexion->connect_error) {
      die('Error de conexión: ' . $this->connexion->connect_error);
    }
  }
}
