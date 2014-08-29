<?php
namespace jon;
class BlogPostDataProcess {

  public static function dateFormat($date) {
    return date('n/j/Y - g:ia', $date);
  }

  public static function metaDescriptionFromBody($postBody) {
    $cleanString = strip_tags($postBody);

    if (strlen($cleanString) <= 160) {
      $metaDesc = $cleanString;
    } else {
      $cleanString = substr($cleanString, 0, 160);
      $metaDesc = preg_replace('/\n/', '', substr($cleanString, 0, strrpos($cleanString, ' ')));
      if (!preg_match('/[!\.\?]/', substr($metaDesc, -1))) {
        $metaDesc = $metaDesc.'.';
      }
    }

    return $metaDesc;
  }

  public static function tagsWrap($tags) {
    if (!empty($tags)) {
      $tagsLinks = 'Tags: ';
      $tagArray = str_replace(' ', '', explode(',', $tags));

      foreach ($tagArray as $key => $value) {
        $tagsLinks .= '<a href="/tags/'.$value.'">'.$value.'</a> ';
      }

      return $tagsLinks;
    }
  }
}
