<?php
  namespace jon;
  class PDOUpdate {
    private $driver;
    private $host;
    private $username;
    private $password;
    private $db;
    private $table;
    private $link;
    private $statement;
    private $pageUrl;
    private $id;
    private $old_page_url;
    private $blogUrl;

    public function __construct($database) {
      $this->driver       = $database['driver'];
      $this->host         = $database['host'];
      $this->username     = $database['username'];
      $this->password     = $database['password'];
      $this->db           = $database['db'];
      $this->table        = $database['table'];
      $this->id           = $_POST['id'];
      $this->old_page_url = $_POST['old_page_url'];

      self::urlSearch($this->driver, $this->host, $this->username, $this->password, $this->db, $this->table, $this->old_page_url, $this->id);
    }

    protected function urlSearch($driver, $host, $username, $password, $db, $table, $old_page_url, $id) {
      $this->link = new \PDO("$this->driver:host=$this->host;dbname=$this->db", $this->username, $this->password);
      $this->statement = $this->link->prepare("SELECT id, page_url FROM ".$this->table." WHERE id = :id AND page_url = :old_page_url");
      $vals = array(':id' => $this->id, ':old_page_url' => $this->old_page_url);
      $this->statement->execute($vals);
      $allVals = $this->statement->fetch(\PDO::FETCH_ASSOC);

      foreach ($allVals as $key => $value) {
        $checked[$key] = $value;
      }

      self::updateInfo($this->driver, $this->host, $this->username, $this->password, $this->db, $this->table, $checked);
    }

    protected function updatedURL($blogUrl) {
      // replace white space with dash
      $blogUrl = preg_replace('/\s/', '-', $blogUrl);

      // remove odd characters
      $blogUrl = preg_replace('/[^a-zA-Z0-9-_]/', '', $blogUrl);

      return strtolower($blogUrl);
    }

    private function updateInfo($driver, $host, $username, $password, $db, $table, $checked) {
      $this->blogUrl = self::updatedURL($_POST['page_url']);

      $this->link = new \PDO("$this->driver:host=$this->host;dbname=$this->db", $this->username, $this->password);
      $this->statement = $this->link->prepare("UPDATE ".$this->table." SET post_title = :postTitle, post_body = :postBody, page_url = :postUrl, tags = :tags WHERE id = :id AND page_url = :old_page_url");
      $vals = array(':postTitle' => $_POST['title'], ':postBody' => $_POST['body'], ':postUrl' => $this->blogUrl, ':tags' => $_POST['tags'], ':id' => $checked['id'], ':old_page_url' => $checked['page_url']);
      $added = $this->statement->execute($vals);

      if ($added) {
        header("Location: $this->blogUrl");
      } else {
        echo 'There was an error.';
      }
    }
}
