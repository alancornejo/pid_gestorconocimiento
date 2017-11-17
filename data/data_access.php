<?php
date_default_timezone_set("America/Bogota");
class Connection {
    public $host,$driver,$bd,$user,$pwd;
    public $conn;

    public function __clone() {
    }

    public function __construct() {
        $this->host   = "mysql_interbank.sapia.pe";
        $this->driver = "mysql";
        $this->bd     = "interbank_pid";
        $this->user   = "interbank_pid";
        $this->pwd    = "Mezeketa6eXE";
    }

    public function connect() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pwd, $this->bd);
        return $this->conn;
    }

    public function consult($sql) {
        $conn = $this->connect();
        $result = mysqli_query($conn,$sql);
        return $result;
    }
}