<?php
  require_once 'models/site-settings.php';
  require_once 'classes/pdo.blog-search.php';
  $dbRead = new jon\PDOBlogSearch($database, $blogPost);
?>
