<?php
date_default_timezone_set("America/Bogota");
class Connection {
    public $host,$driver,$bd,$user,$pwd;
    public $conn;

    public function __clone() {
    }

    public function __construct() {
        $this->host   = "192.167.99.236";
        $this->driver = "mysql";
        $this->port   = "12589";
        $this->bd     = "interbank_pid";
        $this->user   = "interbank_pid";
        $this->pwd    = "QSSCxZ5E";
    }

    public function connect() {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pwd, $this->bd, $this->port);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        return $this->conn;
    }

    public function consult($sql) {
        $conn = $this->connect();
        $result = mysqli_query($conn,$sql);
        return $result;
    }
}