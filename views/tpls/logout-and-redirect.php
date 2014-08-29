<?php
  session_destroy();
  header("Location: /", 302);
  die();
?>
