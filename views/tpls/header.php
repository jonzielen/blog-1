<!DOCTYPE html>
<html>
<head>
  <title><?php echo @$page['title'].$site['title']; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo (SITE_URL); ?>assets/styles/main.css">
  <?php
    if (@$page['meta']) {
      foreach ($page['meta'] as $key => $value) {
        echo printMeta($key, $value);
      }
    }
  ?>
</head>
<body>
  <div class="page-wrapper clearfix">
  <a href="/">home</a>
  <a href="/blog">blog</a>
  <?php if (@$_SESSION['logged_in'] == false): ?>
  <a href="/login">login</a>
  <?php endif ?>

  <?php
    if (@$_SESSION['logged_in'] == true) {
      require 'views/tpls/logged-in-menu.php';
    };
  ?>
