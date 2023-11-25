<?php
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
