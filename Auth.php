<?php

  namespace Control\Auth;

  /**
   * La class Auth permet de verifier tous qui concerne l'authentification
   * @param $db  est l'une instace de l'interface \Model\DB\DbDrivers
   * @var $dbCnnexion PDO ressource connexion à DB
   */
  class Auth {

    protected $dbCnnexion;

    public function __construct(\Model\DB\DbDrivers $db) {
      $this->dbCnnexion = $db;
    }

    /**
     * verifier si un user tenter de connecter et planter les sessions en cs user se connecte
     * @param $pseudoname String le pseudo  de user
     * @param $password String le mot de pass de user
     * @return Boolean true si se connecte et non en cas echoue
     */
    public function tryToConnect($pseudoname, $password) {
      $getPseudo = $this->dbCnnexion->query('SELECT matricule FROM personnel WHERE mobile = :pseudo OR mobilePro = :pseudo', array('pseudo' => $pseudoname));
      $getLoggin = $this->dbCnnexion->query(
        "SELECT privileges FROM personnel WHERE (mobile = :pseudo OR mobilePro = :pseudo) AND password = :password AND hasCount = 1",
        array("pseudo" => $pseudoname, "password" => hash('sha256', "dayen" . $password))
      );

      if (is_object($getLoggin)) {
        if ($getLoggin->privileges == "a") {
          $className = "\Model\Uses\Admin";
        } elseif ($getLoggin->privileges == "d") {
          $className = "\Model\Uses\Drh";
        } elseif ($getLoggin->privileges == "c") {
          $className = "\Model\Uses\Chef";
        } elseif ($getLoggin->privileges == "b") {
          $className = "\Model\Uses\Coordinateur";
        } elseif ($getLoggin->privileges == "e") {
          $className = "\Model\Uses\Employe";
        }

        $getLoggin = $this->dbCnnexion->query(
          "SELECT matricule, nom, prenom, mobile, email, privileges FROM personnel WHERE (mobile = :pseudo OR mobilePro = :pseudo) AND password = :password AND hasCount = 1",
          array("pseudo" => $pseudoname, "password" => hash('sha256', "dayen" . $password)),
          FALSE,
          $className
        );
        $_SESSION['__user'] = $getLoggin;
        return TRUE;
      } else {
        if(!$getPseudo) $_SESSION['loggedError']['pseudoname'] = "Verifiez votre numero ou saise un autre valide.";
        $_SESSION['loggedError']['password'] = "Saisez un mot de pass valide sinon vous n'avez pas encore un compte.";
      }
      return FALSE;
    }












}
