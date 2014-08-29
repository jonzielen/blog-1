<h1>HOMEPAGE!</h1>
<h2>Blog:</h2>
<?php
  require 'classes/homepage.blog.php';
  $settings['blog_post_date_format'] = 'n/j/Y - g:ia';
  $settings['blog_post_body_word_limit'] = 50;
  $posts = new jon\HomepageBlogPosts($settings);
  echo $posts->homepageBlogPosts($dbRead->results);;
?>
