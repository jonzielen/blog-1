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
    public $blogUrl;

    public function __construct($database) {
      $this->driver   = $database['driver'];
      $this->host     = $database['host'];
      $this->username = $database['username'];
      $this->password = $database['password'];
      $this->db       = $database['db'];
      $this->table    = $database['table'];

      $this->blogUrl = self::urlFromTitle($_POST['title']);

      self::insertInfo($this->driver, $this->host, $this->username, $this->password, $this->db, $this->table, $this->blogUrl);
    }

    protected function urlFromTitle($blogUrl) {
      // replace white space with dash
      $blogUrl = preg_replace('/\s/', '-', $blogUrl);

      // remove odd characters
      $blogUrl = preg_replace('/[^a-zA-Z0-9-]/', '', $blogUrl);

      return strtolower($blogUrl);
    }

    public function insertInfo($driver, $host, $username, $password, $db, $table, $blogUrl) {
      $this->link = new \PDO("$this->driver:host=$this->host;dbname=$this->db", $this->username, $this->password);
      $this->statement = $this->link->prepare("INSERT INTO ".$this->table." (unix_time, post_title, post_body, page_url, tags) VALUES (:unixTime, :postTitle, :postBody, :postUrl, :tags)");
      $this->statement->execute(array(':unixTime' => time(), ':postTitle' => $_POST['title'], ':postBody' => $_POST['body'], ':postUrl' => $this->blogUrl, ':tags' => $_POST['tags']));
    }
}
