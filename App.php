<?php

  namespace Core;
  /**
   * App class permet de charger tous qui concerne l application et joue le role de couer
   * @namespace Core
   */
  class App  {

    function __construct(){}

    /**
     * charger les autoloader de chaque dossiers
     */
    public static function loadDependency() {
      require ROOT . '/Control/Autoloader.php';
      \Control\Autoloader::register();
      require ROOT . '/View/Autoloader.php';
      \View\Autoloader::register();
      require ROOT . '/Model/Autoloader.php';
      \Model\Autoloader::register();
    }

    /**
     * verifier l'existance des sessions de user
     * @return Boolean true si $_SESSION['__user'] existe sinon false
     */
    public static function userSessionExist() {
      self::startSession();
      return !empty($_SESSION['__user']);
    }

    /**
     * verifier l'existance des sessions ou non en cas de ce dernier ajouter ls sessions
     */
    private function startSession() {
      if(session_status() != PHP_SESSION_ACTIVE) session_start();
    }

    /**
     * rediret et tuer l'execution de code suivant
     */
    public static function redirect($link) {
      header("Location: $link");
      exit();
    }

    /**
     * verifier les inputs saise via ls users pour eviter XSS faile
     * @param $values Array ls valeurs doit verifier
     * @return $values Array ls vals verfiez
     */
    public static function escapeValues($values) {
      foreach ($values as $key => $value)
        $values[$key] = utf8_encode(htmlentities($value));
      return $values;
    }

    /**
     * enrigestrer l'image upload dans e dossier specifie
     * @return Boolean si l'image enrigestrer ou non
     */
    public static function uploadImage($file, $path, $name) {
      $type = substr($file['type'], 6);
      $imageType = array('jpeg', 'jpg', 'png', 'gif');
      if(!empty($file) && in_array($type, $imageType)){
        $tmpName = $file['tmp_name'];
        $name = basename($name);
        if(move_uploaded_file($tmpName, $path . "/$name.$type")) return "/$name.$type";
      }
      return FALSE;
    }

    /**
     * verfier 1user a des cookies
     */
    // public static function hasCookie($dbLink, $cookie) {
    //   echo "<pre>";
    //   $user =  $dbLink->query(
    //     "SELECT matricule, nom, prenom, privileges, mobile FROM personnel WHERE hasCount != 0",
    //     NULL, TRUE
    //   );
    //   var_dump($user);die();
    // }

  }
