<?php

// utiliser le namespace Core\App
  use Core\App;
  define('ROOT', __DIR__);
// verifier l'existance de la var $_GET['p']
  if (isset($_GET['p'])) $pageName = $_GET['p'];
  else $pageName = "home";

// charger l"autoloader de chaque dossier
  require 'Core/App.php';
  App::loadDependency();

// verifier si l'user a des sessions
  if (!App::userSessionExist()) $pageName = "login";

// verifier l'existance des cookies pour rediriger l'utilisateur à la page de home
  // if(!empty($_COOKIE['__user'])){
  //   $dblink = new Model\DB\Mysql();
  //   App::hasCookie($dblink, $_COOKIE['__user']);
  // }


  ob_start();
    if ($pageName === "home" && !empty($_SESSION['__user'])) require "View/pages/home.php";
    elseif ($pageName === "update" && !empty($_SESSION['__user'])) require "View/pages/update.php";
    elseif ($pageName === "compte" && !empty($_SESSION['__user'])) require "View/pages/compte.php";
    else require "View/pages/$pageName.php";

  $content = ob_get_clean();

  require "View/default/defaultView.php";

 ?>
