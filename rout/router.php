<?php
namespace jon;
class Router {

  private $urlParts = '';
  private $routParams = '';
  public $routOrder = '';

  public function __construct($urlParams) {
    $this->urlParts = $urlParams;

    foreach ($this->urlParts as $key => $value) {
      if ($value == '') {
        $this->routParams[$key] = 'homepage';
      } else {
        $this->routParams[$key] = $value;
      }
    }
    self::rout($this->routParams);
  }

  protected function rout($routOrder) {
    $this->routOrder = array_reverse($this->routParams);
    return $this->routOrder;
  }
}
