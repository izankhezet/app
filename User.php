<?php

  namespace Model\Uses;
  /**
   * cette class permet de personalise ls users
   * @param $db instance de \Model\DB\DbDrivers
   * @var $dbLink instance de \Model\DB\DbDrivers
   */
  class User  {

    protected $dbLink = NULL;

    public function __construct(\Model\DB\DbDrivers $db) {
      $this->dbLink = $db;
    }

    /**
     * recuperer la liste de tous ls employes
     * @return Mixed soit Array si existe des employes au niveau de DB ou FALSE dans le cas contraire
     */
     public function getAllEmployes()  {
       return $this->dbLink->query("SELECT matricule, nom, prenom, email, mobile, mobilePro, photo, adresse FROM personnel ORDER BY nom ", NULL, TRUE);
     }

     /**
      * recuperer 1employes cible
      * @return Mixed soit Array si existe des employe au niveau de DB ou FALSE dans le cas contraire
      */
      public function getEmploye($matricule)  {
        return $this->dbLink->query("SELECT * FROM personnel WHERE matricule = ? ORDER BY nom ", array($matricule));
      }

    /**
     * recuperer tous ls employes non utilisateur n'ont pas un compte user
     * @return Array de qlq infos concerne les employes n'ont pas 1compte utilisateur
     */
    public function getAllNonUsers() {
      return $this->dbLink->query("SELECT matricule, nom, prenom, email, mobile FROM personnel WHERE hasCount = 0 ORDER BY nom ", NULL, TRUE);
    }

    /**
     * recuperer les infos des utilisateurs(ont compte)
     * @return Array de nom, prenom, mobile, mmail .. infos concerne ls utilisateurs
     */
    public function getAllUsers() {
      return $this->dbLink->query("SELECT matricule, nom, prenom, email, mobile, privileges FROM personnel WHERE hasCount != 0 ORDER BY nom  ASC", NULL, TRUE);
    }

    /**
     * recuperer un employe via son matricule
     * @return PDO::stdclass les infos de employe
     */
     public function getPerson($id) {
       return $this->dbLink->query('SELECT * FROM personnel WHERE matricule=?', array($id));
     }

    /**
     * charger les chef de projet
     * @return Mixed soit Array liste des emplouyes ou FALSE en cas la requete ne recuperer aucune resultat
     */
    public function getAllProjectChef() {
      return $this->dbLink->query(
        "SELECT matricule, nom, prenom FROM personnel WHERE privileges = 'c' ORDER BY nom",
        NULL, TRUE
      );
    }

    /**
     * recuperer un chef specifie
     * @param $id le matricule de chef de projet a recuperer
     * @return Mixed soit Array d'infos concerne chef ou FALSE en cas la requete ne recuperer rien
     */
    public function getProjectChef($id) {
      return  $this->dbLink->query(
        "SELECT * FROM personnel WHERE privileges = 'c' AND matricule = ? ORDER BY nom",
        array($id)
      );
    }

    /**
     * charger la liste des clients
     * @return Mixed soit Array liste des client ou FALSE sinon
     */
    public function getAllClient() {
      return $this->dbLink->query(
        "SELECT * FROM client",
        NULL, TRUE
      );
    }

    /**
     * recuperer un client specifie
     * @param $id Strinf le id de client
     * @return Mixed Array ls infos de client ou FALSE en cas d'inexistance de client
     */
    public function getClient($id) {
      return  $this->dbLink->query(
        "SELECT * FROM client WHERE  id_client = ? ",
        array($id)
      );
    }

    /**
     * charger la liste des projets
     * @return Mixed soit Array liste des client ou FALSE sinon
     */
    public function getAllProjects() {
      return $this->dbLink->query(
        "SELECT * FROM projet",
        NULL, TRUE
      );
    }

    /**
     * @param $id String le id de projet a modifier
     * @return Mixed soit Array de resultat ou FALSE si n' a pas de ce projet
     */
    public function getProjet($id) {
      return  $this->dbLink->query(
        "SELECT * FROM projet WHERE  id_projet = ? ",
        array($id)
      );
    }

    /**
     * recuperer la liste des wilaya
     * @return Array liste des wilaya
     */
    public function getAllWilaya() {
      return $this->dbLink->query('SELECT * FROM wilaya', NULL, TRUE);
    }

    /**
     * recuperer un client specifie
     * @param $id Strinf le id de wilaya
     * @return Mixed Array ls infos de wilaya ou FALSE en cas d'inexistance de wilaya
     */
    public function getWilaya($id) {
       return  $this->dbLink->query(
         "SELECT * FROM wilaya WHERE  id_wilaya = ? ",
         array($id)
       );
     }

    /**
     * recuperer tous les sites
     * @return Mixed soit Array liste de tous ls sites ou FALSE sinon aucun site existe
     */
     public function getAllSites() {
       return $this->dbLink->query("SELECT * FROM site", NULL, TRUE);
     }

    /**
     *recuperer le site
     *@param $id String id de site*
     *@return stdClass de infos de sitte ou FALSE si n"existe plus
     */
     public function getSite($id) {
       return  $this->dbLink->query(
         "SELECT * FROM site WHERE id_site = ?",
         array($id)
       );
     }
















  }
