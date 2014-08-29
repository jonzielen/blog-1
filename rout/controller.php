<?php
namespace jon;
class Controller {

  protected $template = array('vars'=>'', 'preHTML'=>'', 'html'=>'', 'info'=>'');
  protected $routParts = '';

  public function __construct($routParts) {
    $this->routParts = $routParts;

    foreach ($this->routParts as $key => $value) {
      if (method_exists('jon\Controller', $value)) {
          self::$value($this->routParts);
          break;
        } else {
          switch ($this->routParts[1]) {
            case 'blog':
              self::blogPage($this->routParts[0]);
              break;

            case 'edit':
              self::edit($this->routParts[0]);
              break;

            default:
              self::errorPageInfo();
              break;
          }
      }
    }
  }

  protected function errorPageInfo() {
    if (file_exists('models/error-page.php')) {
       require 'models/error-page.php';
       foreach ($page as $key => $value) {
         $this->template['vars'][$key] = $value;
       }
    }

    $this->template['html'] .= file_get_contents('views/pages/error-page.php');
  }

  protected function notLoggedIn() {
    if (file_exists('models/error-page.php')) {
       require 'models/error-page.php';
       foreach ($page as $key => $value) {
         $this->template['vars'][$key] = $value;
       }
    }
    $this->template['html'] .= file_get_contents('views/pages/not-logged-in-page.php');
  }

  protected function homepage() {
    // connect to db, read info
    if (file_exists('models/database-read.php')) {
      $this->template['preHTML'] .= file_get_contents('models/database-read.php');
    }

    if (file_exists('views/pages/homepage.php')) {
      $this->template['html'] .= file_get_contents('views/pages/homepage.php');
    } else {
     self::errorPageInfo();
    }
  }

  protected function blog($urlParams) {
    //echo 'AWESOME!';

    /*if (file_exists('views/tpls/blog-post.tpl.php')) {
      $this->template['html'] .= file_get_contents('views/tpls/blog-post.tpl.php');
    } else {
      self::errorPageInfo();
    }*/
  }

  protected function blogPage($blogPost) {
    // connect to db, pull info
    if (file_exists('models/database-blog-search.php')) {
      require_once 'models/database-blog-search.php';

      if (empty($dbRead->results)) {
        self::errorPageInfo();
      } else {
        // not empty
        if ($dbRead->results[0]) {
          foreach ($dbRead->results[0] as $key => $value) {
            $this->template['vars'][$key] = $value;
          }
        } else {
          self::errorPageInfo();
        }

        // post database call data processing
        if (file_exists('classes/blogpostdataprocess.php')) {
          require 'classes/blogpostdataprocess.php';

          $this->template['vars']['unix_time'] = BlogPostDataProcess::dateFormat($this->template['vars']['unix_time']);
          $this->template['vars']['meta']['description'] = BlogPostDataProcess::metaDescriptionFromBody($this->template['vars']['post_body']);
          $this->template['vars']['meta']['keywords'] = $this->template['vars']['tags'];
          $this->template['vars']['tags'] = BlogPostDataProcess::tagsWrap($this->template['vars']['tags']);
        } else {
          self::errorPageInfo();
        }

        // templating
        if (file_exists('views/tpls/blog-post.tpl.php')) {
          $this->template['html'] .= file_get_contents('views/tpls/blog-post.tpl.php');

          foreach ($this->template['vars'] as $key => $value) {
            // skip meta, and any other value that is array
            if (!is_array($value)) {
              $this->template['html'] = str_replace("{".$key."}", $value, $this->template['html']);
            }
          }
        } else {
          self::errorPageInfo();
        }

        // ADD EDIT




      }
    } else {
      self::errorPageInfo();
    }
  }

  protected function add($urlParams) {
    if (@$_SESSION['logged_in'] == true) {
       // connect to db, add info
      if (!empty($_POST)) {
        if (file_exists('models/database-insert.php')) {
          $this->template['preHTML'] .= file_get_contents('models/database-insert.php');
        }
      }
      if (file_exists('views/tpls/add-blog-post.tpl.php') && @$_SESSION['logged_in'] == true) {
        $this->template['html'] .= file_get_contents('views/tpls/add-blog-post.tpl.php');
      } else {
        self::notLoggedIn();
      }
    } else {
      self::notLoggedIn();
    }
  }

  protected function edit($blogPost) {

    if (@$_SESSION['logged_in'] == true) {


      /**/
      // connect to db, pull info
      if (file_exists('models/database-blog-search.php')) {
        require_once 'models/database-blog-search.php';

        //$returns = $dbRead->displayResults();

        echo '<pre>';
        print_r(get_defined_vars());
        echo '</pre>';



        //echo $dbRead->displayResults();


        if (empty($dbRead->results)) {
          self::errorPageInfo();
        } else {
          // not empty
          if ($dbRead->results[0]) {
            foreach ($dbRead->results[0] as $key => $value) {
              $this->template['vars'][$key] = $value;
            }
          } else {
            self::errorPageInfo();
          }

          // post database call data processing
          if (file_exists('classes/blogpostdataprocess.php')) {
            require 'classes/blogpostdataprocess.php';

            $this->template['vars']['unix_time'] = BlogPostDataProcess::dateFormat($this->template['vars']['unix_time']);
            $this->template['vars']['meta']['description'] = BlogPostDataProcess::metaDescriptionFromBody($this->template['vars']['post_body']);
            $this->template['vars']['meta']['keywords'] = $this->template['vars']['tags'];
            $this->template['vars']['tags'] = BlogPostDataProcess::tagsWrap($this->template['vars']['tags']);
          } else {
            self::errorPageInfo();
          }

          // templating
          if (file_exists('views/tpls/edit-blog-post.tpl.php')) {
            $this->template['html'] .= file_get_contents('views/tpls/edit-blog-post.tpl.php');

            foreach ($this->template['vars'] as $key => $value) {
              // skip meta, and any other value that is array
              if (!is_array($value)) {
                $this->template['html'] = str_replace("{".$key."}", $value, $this->template['html']);
              }
            }
          } else {
            self::errorPageInfo();
          }
        }
      } else {
        self::errorPageInfo();
      }
      /**/




    } else {
      self::notLoggedIn();
    }
  }

  protected function login($urlParams) {
    if (file_exists('views/pages/login.php')) {
      $this->template['html'] .= file_get_contents('views/pages/login.php');
    } else {
      self::errorPageInfo();
    }
  }

  protected function logout($urlParams) {
    if (file_exists('views/tpls/logout-and-redirect.php')) {
      $this->template['preHTML'] .= file_get_contents('views/tpls/logout-and-redirect.php');
    }
    if (file_exists('views/pages/logout.php')) {
      $this->template['html'] .= file_get_contents('views/pages/logout.php');
    } else {
      self::errorPageInfo();
    }
  }

  public function controllerOutput() {
    return $this->template;
  }
}
