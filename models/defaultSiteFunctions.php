<?php
  function siteURL() {
      $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
      $domainName = $_SERVER['HTTP_HOST'];
      return $protocol.$domainName;
  }
  define('SITE_URL', siteURL());

  function printMeta($key, $value) {
    return "<meta name=\"$key\" content=\"$value\">\r\n";
  }

  if (@$_POST['username'] == 'jon' && @$_POST['password'] == '123') {
    $_SESSION['logged_in'] = true;
  }

  // set default date display
  define('DATE_FORMAT', 'n/j/Y - g:ia');
  //$settings['blog_post_date_format'] = 'n/j/Y - g:ia';
?>
