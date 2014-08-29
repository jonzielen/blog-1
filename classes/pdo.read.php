<?php
  namespace jon;
  class PDORead {
    private $driver;
    private $host;
    private $username;
    private $password;
    private $db;
    private $table;
    private $link;
    private $statement;
    public $results;

    public function __construct($database) {
      $this->driver   = $database['driver'];
      $this->host     = $database['host'];
      $this->username = $database['username'];
      $this->password = $database['password'];
      $this->db       = $database['db'];
      $this->table    = $database['table'];

      self::readInfo($this->driver, $this->host, $this->username, $this->password, $this->db, $this->table);
    }

    private function readInfo($driver, $host, $username, $password, $db, $table) {
      $this->link = new \PDO("$this->driver:host=$this->host;dbname=$this->db", $this->username, $this->password);
      $this->statement = $this->link->prepare("SELECT * FROM ".$this->table." ORDER BY id DESC LIMIT 5");
      $this->statement->execute();
      $this->results = $this->statement->fetchAll(\PDO::FETCH_ASSOC);

      self::displayResults($this->results);
    }

    public function displayResults($results) {
      return $this->results;
    }
}
