<?php
namespace jon;
class Page {

  protected $headerFile = 'views/tpls/header.php';
  protected $footerFile = 'views/tpls/footer.php';
  protected $defaultSiteInfo = 'models/default-page-info.php';
  protected $page = '';
  public $pageVars = '';

  function __construct($controllerSettings) {
    self::addVars($controllerSettings);
    self::addHeader($controllerSettings);
    self::addBody($controllerSettings);
    self::addFooter($controllerSettings);
  }

  protected function addVars($controllerSettings) {
    if ($controllerSettings['vars']) {
      foreach ($controllerSettings['vars'] as $key => $value) {
        $this->pageVars[$key] = $value;
      }
    }
  }

  protected function setPageInfo($pageVars) {
    if (@$this->pageVars['post_title']) {
      $page['title'] = strip_tags($this->pageVars['post_title']).' | ';
    }

    if (@$this->pageVars['title']) {
      $page['title'] = strip_tags($this->pageVars['title']);
    }

    if (@$this->pageVars['meta']['description']) {
      $page['meta']['description'] = $this->pageVars['meta']['description'];
    }

    if (@$this->pageVars['meta']['keywords']) {
      $page['meta']['keywords'] = $this->pageVars['meta']['keywords'];
    }

    return @$page;
  }

  protected function addHeader($controllerSettings) {
    if ($controllerSettings['preHTML']) {
      $this->page .= $controllerSettings['preHTML'];
    }

    if ($controllerSettings['vars']) {
      foreach ($controllerSettings['vars'] as $key => $value) {
        $this->pageVars[$key] = $value;
      }
    }

    $this->page .= file_get_contents($this->defaultSiteInfo);
    $this->page .= file_get_contents($this->headerFile);
  }

  protected function addBody($controllerSettings) {
    $this->page .= $controllerSettings['html'];
  }

  protected function addFooter($controllerSettings) {
    $this->page .= file_get_contents($this->footerFile);
  }

  public function displayPage() {
    $page = self::setPageInfo($this->pageVars);

    return eval('?>'.$this->page);
  }
}
