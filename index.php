<?php
  session_start();
  require 'models/defaultSiteFunctions.php';
  require 'rout/router.php';
  require 'rout/controller.php';
  require 'classes/class.page.php';

  $rout = new jon\Router(explode('/', @$_SERVER['REDIRECT_URL']));

  $controllerInfo = new jon\Controller($rout->routOrder);
  $controllerSettings = $controllerInfo->controllerOutput();

  $loadPage = new jon\Page($controllerSettings);
  $loadPage->displayPage();
?>
