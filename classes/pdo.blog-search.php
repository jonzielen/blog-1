<?php
  namespace jon;
  class PDOBlogSearch {
    private $driver;
    private $host;
    private $username;
    private $password;
    private $db;
    private $table;
    private $link;
    private $statement;
    private $blogPostURL;
    public $results;

    public function __construct($database, $blogPostURL) {
      $this->driver      = $database['driver'];
      $this->host        = $database['host'];
      $this->username    = $database['username'];
      $this->password    = $database['password'];
      $this->db          = $database['db'];
      $this->table       = $database['table'];
      $this->blogPostURL = $blogPostURL;

      self::readInfo($this->driver, $this->host, $this->username, $this->password, $this->db, $this->table, $this->blogPostURL);
    }

    private function readInfo($driver, $host, $username, $password, $db, $table, $blogPostURL) {
      $this->link = new \PDO("$this->driver:host=$this->host;dbname=$this->db", $this->username, $this->password);
      $this->statement = $this->link->prepare("SELECT * FROM ".$this->table." WHERE page_url = :blogURL LIMIT 1");
      $this->statement->bindParam(':blogURL',  $this->blogPostURL);
      $this->statement->execute();
      $this->results = $this->statement->fetchAll(\PDO::FETCH_ASSOC);

      self::displayResults();
    }

    public function displayResults() {
      return $this->results;
    }
}
