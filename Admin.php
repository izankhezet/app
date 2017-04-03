<?php

  namespace Model\Uses;

  /**
   *
   */
  class Admin extends Share {

    protected $pdo = NULL;

    function __construct(){}

    /**
     * pour ajouter un nouveus utilisateur
     * @param $dbLink PDO ressource
     * @param $grade String d'1 lettre presente le grade de l'utilisateur soit 'a', 'e', 'c', 'b', 'd'
     * @param $matricule Integer presente le matricule de l'employe
     * @return Integer soit le nombre de champ affectees
     */
    public function addUser($dbLink, $grade, $matricule) {
      return $dbLink->query(
        "UPDATE personnel SET hasCount = 1, password = '". hash('sha256', "dayen" . "dayen") ."',privileges= '" .addcslashes($grade, "'\""). "' WHERE matricule=" . addcslashes($matricule, "'\"")
      );
    }


    /**
     * supprimer un utilisateur
     * @param $dbLink PDO ressource link to DB
     * @param $matricule Integer le matricule de l'utilisateur a supprime
     * @return Mixed  soit nombre de champ affecte(nbr utilisateur supprime) ou FALSE sinon
     */
    public function removeUser($dbLink, $matricule) {
      return $dbLink->query(
        "UPDATE personnel SET hasCount = 0 WHERE privileges != 'a' AND matricule=" . addcslashes($matricule, "'\"")
      );
    }


  }
