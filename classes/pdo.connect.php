<?php
  namespace jon;
  class PDOInsert {
    private $driver;
    private $host;
    private $username;
    private $password;
    private $db;
    private $table;
    private $link;
    private $statement;

    public function __construct($database) {
      $this->driver   = $database['driver'];
      $this->host     = $database['host'];
      $this->username = $database['username'];
      $this->password = $database['password'];
      $this->db       = $database['db'];
      $this->table    = $database['table'];

      self::insertInfo($this->driver, $this->host, $this->username, $this->password, $this->db, $this->table);
    }

    public function insertInfo($driver, $host, $username, $password, $db, $table) {
      $this->link = new \PDO('mysql:host=localhost;dbname=test', $this->username, $this->password);
      $this->statement = $this->link->prepare("INSERT INTO ".$this->table." (unix_time, post_title, post_body) VALUES (:unixTime, :postTitle, :postBody)");
      $this->statement->execute(array(':unixTime' => time(), ':postTitle' => $_POST['title'], ':postBody' => $_POST['body']));
    }
}
