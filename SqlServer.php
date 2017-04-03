<?php

  namespace Model\DB;
  /**
   *
   */
  class SqlServer implements DbDrivers {

    protected $pdo = NULL;
    protected $dbConfig = array();

    function __construct() {
      $this->dbConfig = require ROOT . "/Config/DbConfig.php";
      try {
        $this->pdo = new PDO("odbc:Driver={SQL Server Native Client 10.0};Server={$this->dbConfig['host']};Database={$this->dbConfig['dbname']};", $this->dbConfig['user'], $this->dbConfig['password']);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
      } catch (Exception $e) {
        die("Something is wrong, error status: " . $e->getMessage());
      }
    }

    /**
     * executer les requetes SQL et return ds resultats
     * @param $request String rquete SQL
     * @param $params Array les valeur des requetes preparees
     * @param $class String nom de class en cas de  fething
     * @return Mixed soit results de fetch Array; JSON ou Boolean en terme de requete
     */
    public function query($request, $params = array(), $fetchAll = FALSE, $class = NULL) {
      $queryType = substr(strtolower($request), 0, 6);

      if (empty($params)) $res = $this->pdo->query($request);
      else {
        $res = $this->pdo->prepare($request);
        $res->execute($params);
      }

      if ($queryType === "select") {
        if (isset($class)) $res->setFetchMode(PDO::FETCH_CLASS, $class);

        if($fetchAll) return $res->fetchAll();
        else return $res->fetch();
      }
      return $res;

    }

    /**
     * reuperer PDO ressource
     * @return $this->pdo PDO ressource de connexion à la base de donnee
     */
    public function getPDO() {
      return $this->pdo;
    }




  }
