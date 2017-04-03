<?php

  namespace Model\Uses;

  /**
   * cette class present le coordinateur et ses methode et proprieties
   */
  class coordinateur extends Share{

    function __construct() { }

    /**
     * ajouter un site
     * @param $dbLink Model\DB\DbDrivers lien vers DB
     * @param $posts Array les valeur des champ de table site
     * @return Boolean True si l'insertion a bient faite sinon FALSE
     */
    public function addSite($dbLink, $posts) {
      $idSite = $posts['idSite'];
      $errorsGet = array();
      $errors = array(
        "verfiez le champ de region.",
        "verfiez le champ de adresse.",
        "verfiez le champ de nature de site.",
        "verfiez le champ de responsable.",
        "Ce client choisit n'existe pas ou vous laissez son champ vide.",
        "verfiez le champ de projet.",
        "verfiez le champ de wilaya.",
        "verfiez le champ de longitude.",
        "verfiez le champ de altitude.",
        "verfiez le champ de laltitude"
      );

      if(trim($idSite) == "" || $dbLink->query("SELECT * from site WHERE id_site = ?", [$idSite]))
        $errorsGet[] = 'Cet id existe deja ou vous avez laisse le champ de id vide.';

      //retirer le 1er element de posts qui correspond à id site car a deja ete verifie
      array_shift($posts);

      // verifier si les posts sont bien remplit et ls vals englonbees sont valide
      if(is_array($this->isValide($posts, $errors))){
        foreach ($this->isValide($posts, $errors) as $value) {
          array_push($errorsGet, $value);
        }
      }
      // $errorsGet = $this->isValide($posts, $errors);
      array_unshift($posts, $idSite);

      // si $errorsGet vide en ajouter ls vals à DB
      if (count($errorsGet) == 0) {
        return $dbLink->query(
          "INSERT INTO site(id_site, region, nature, id_persone, id_client, id_projet, id_wilaya, longitude, altitude, latitude)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
          array_values($posts)
        );
      } else{
        $_SESSION['errors']['warning'] = $errorsGet;
        return FALSE;
      }
    }

    /**
     * update un site
     * @param $dbLink Model\DB\DbDrivers lien vers DB
     * @param $posts Array les valeur des champ de table site
     * @return Boolean True si l'insertion a bient faite sinon FALSE
     */
    public function updateSite($dbLink, $posts) {

      $errors = array(
        "verfiez le champ de region.",
        "verfiez le champ de nature de site.",
        "Ce client choisit n'existe pas ou vous laissez son champ vide.",
        "verfiez le champ de responsable.",
        "verfiez le champ de projet.",
        "verfiez le champ de wilaya.",
        "verfiez le champ de longitude.",
        "verfiez le champ de laltitude",
        "verfiez le champ de altitude."
      );

      // verifier si les posts sont bien remplit et ls vals englonbees sont valide
      $errorsGet = array();
      if(is_array($this->isValide($posts, $errors))){
        foreach ($this->isValide($posts, $errors) as $value) {
          array_push($errorsGet, $value);
        }
      }

      // si $errorsGet vide en applique ls mis à jours dans DB
      if (count($errorsGet) == 0) {
        if($dbLink->query(
          "UPDATE site SET region=?, nature=?, id_client=?, id_persone=?, id_projet=?, id_wilaya=?, longitude=?, latitude=?, altitude=?
            WHERE id_site=?",
          array_values($posts)
        )) return $_SESSION['notification']['success'] = "Vous modifiez le site qui situe à {$posts['region']}.";
        else {
          $_SESSION['notification']['danger'] = "Erreur en base de  donnees.";
          return FALSE;
        }
      } else{
        $_SESSION['errors']['danger'] = $errorsGet;
        return FALSE;
      }
    }






  }
