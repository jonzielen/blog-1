<?php
namespace jon;
class HomepageBlogPosts {
  protected $settings = array();

  public function __construct($settings = array()) {
    foreach ($settings as $key => $value) {
      $this->settings[$key] = $value;
    }
  }

  protected function dateFormat($date) {
    return date($this->settings['blog_post_date_format'], $date);
  }

  protected function bodyCharacterLimit($bodyText) {
    $bodyText = strip_tags($bodyText, '<p><a><strong><i><em><span>');
    $bodyArray = explode(' ', $bodyText);

    if (sizeof($bodyArray) <= $this->settings['blog_post_body_word_limit']) {
      return $bodyText;
    } else {
      $text = explode(' ', $bodyText);
      $textSlice = array_slice($text, 0, $this->settings['blog_post_body_word_limit']);
      return implode(' ', $textSlice).'...</p>';
    }
  }

  public function homepageBlogPosts($dbInfo) {
    // templating
    $tpl = '';
    for ($i = 0; $i < count($dbInfo); $i++) {
      if (file_exists('views/tpls/homepage-blog-posts.php')) {
        $tpl .= file_get_contents('views/tpls/homepage-blog-posts.php');
      }

      // format displayed text
      $dbInfo[$i]['unix_time'] = self::dateFormat($dbInfo[$i]['unix_time']);
      $dbInfo[$i]['post_body'] = self::bodyCharacterLimit($dbInfo[$i]['post_body']);

      foreach ($dbInfo[$i] as $key => $value) {
        $tpl = str_replace("{".$key."}", $value, $tpl);
      }
    }

    return $tpl;
  }
}
