<?php 

class Dbhandler {
  private $host;
  private $user;
  private $pass;
  private $db;
  public $conn;

  public function __construct() {
    $this->connect();
  }

  private function connect() {
    // default XAMPP credentials 
    $this->host = "db";
    $this->user = "myuser";
    $this->pass = "mypassword";
    $this->db = "ogtech";

    // connect to db
    $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
    return $this->conn;

    /* check connection */
    if (!$this->conn) 
      die("Connection failed: " . mysqli_connect_error());
  }

  public function conn() {
    // connect to db
    $this->conn = new mysqli("db", "myuser", "mypassword", "ogtech");
    return $this->conn;

    /* check connection */
    if (!$this->conn) 
      die("Connection failed: " . mysqli_connect_error());
  }
}