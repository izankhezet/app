<?php

  namespace Model\Uses;

  /**
   * cette class represente le chef de projet durant sa connexion
   */
  class Chef extends Share{

    function __construct(){}

    /**
     * ajouter un client
     * @param $dbLink Model\DB\DbDrivers lien vers DB
     * @param $posts Array les valeur des champ de table client
     * @param $rip Mixed soit String lorsque l'image a bien ete uploader represente Path False sinon
     * @return Boolean True si l'insertion a bient faite sinon FALSE
     */
    public function addClient($dbLink, $posts, $rip) {
      $idClient = $posts['idClient'];
      $errorsGet = array();
      $errors = array(
        "verfiez le champ de rai",
        "verfiez le champ de adresse",
        "verfiez le champ de registre de commerce",
        "verfiez le champ de numero de telephone",
        "Email saise ne correspond pas à un valide email",
        "verfiez le champ de numero de NIF",
        "verfiez le champ de numero de FAX",
        "verfiez le champ de numero de NIS",
        "verfiez le champ de numero de AI",
        "verfiez le champ de numero de wilaya"
      );
      if(trim($idClient) == "" || $dbLink->query("SELECT * from client WHERE id_client = ?", [$idClient]))
        $errorsGet[] = 'Cet id existe deja ou vous avez laisse le champ de id vide.';
      array_shift($posts);
      // verifier si les posts sont bien remplit et ls vals englonbees sont valide
      if(is_array($this->isValide($posts, $errors))){
        foreach ($this->isValide($posts, $errors) as $value) {
          array_push($errorsGet, $value);
        }
      }
      // $errorsGet = $this->isValide($posts, $errors);
      // ajouter rip comme dernier element de $posts et idclient au debut
      array_push($posts, $rip);
      array_unshift($posts, $idClient);
      //verifier rip
      if(!$rip) $errorsGet[] = "Le rip doit etre une image PNG, JPEG, JPG ou GIF pas autre chose.";
      // si $errorsGet vide en ajouter ls vals à DB
      if (count($errorsGet) == 0) {
        return $dbLink->query(
          "INSERT INTO client(id_client, rai, adresse, registreCommerce, telClient, emailClient, nif, fax, nis, ai, id_wilaya, ripClient)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
          array_values($posts)
        );
      } else{
        $_SESSION['errors']['warning'] = $errorsGet;
        return FALSE;
      }
    }

    /**
     * mettre en place ls modifications
     * @param $dbLink lien vers DB
     * @param $params Array les ifos que en mettant à jour
     * @return Boolean TRUE si ls mis à jours effectuer ou FALSE sinon
     */
    public function updateClient($dbLink, $posts) {
      $errorsGet = array();
      $errors = array(
        "verfiez le champ de rai",
        "verfiez le champ de adresse",
        "verfiez le champ de registre de commerce",
        "verfiez le champ de numero de telephone",
        "Email saise ne correspond pas à un valide email",
        "verfiez le champ de numero de FAX",
        "verfiez le champ de numero de NIF",
        "verfiez le champ de numero de NIS",
        "verfiez le champ de numero de wilaya",
        "verfiez le champ de numero de AI"
      );

      // verifier si les posts sont bien remplit et ls vals englonbees sont valide
      if(is_array($this->isValide($posts, $errors))){
        foreach ($this->isValide($posts, $errors) as $value) {
          array_push($errorsGet, $value);
        }
      }

      // si $errorsGet vide en applique ls mis à jours dans DB
      if (count($errorsGet) == 0) {
        if($dbLink->query(
          "UPDATE client
            SET rai=?, adresse=?, registreCommerce=?, telClient=?, emailClient=?, fax=?, nif=?, nis=?, id_wilaya=?, ai=?
            WHERE id_client=?",
          array_values($posts)
        )) return $_SESSION['notification']['success'] = "Vous modifiez le client {$posts['rai']}.";
        else {
          $_SESSION['notification']['danger'] = "Erreur en base de  donnees.";
          return FALSE;
        }
      } else{
        $_SESSION['errors']['warning'] = $errorsGet;
        return FALSE;
      }
    }

    /**
     * ajouter un nouveau projet
     */
    public function addProject($dbLink, $posts) {
      $idProjet = $posts['idProjet'];
      $errorsGet = array();
      $errors = array(
        "Remplissez le champ de titre  de projet;",
        "Vous oubliez le champ de date de debut;",
        "Saisez une date valide dans le champ de date de fin;",
        "Remplissez le champ de budget;",
        "Le champ de pays est vide;",
        "Remplissez le champ de nombre d'employes;",
        "Remplissez le champ de duree;",
        "Vous laissez le champ de chef vide;",
        "Verifiez le champ correspondant au client;",
        "Attention, selectionnez la nature des traveaux;"
      );
      if(trim($idProjet) == "" || $dbLink->query("SELECT * from projet WHERE id_projet = ?", [$idProjet]))
        $errorsGet[] = 'Cet id existe deja ou vous avez laisse le champ de id vide.';
      array_shift($posts);
      // verifier si les posts sont bien remplit et ls vals englonbees sont valide
      $answer = $this->isValide($posts, $errors);
      if(is_array($answer)){
        foreach ($answer as $value) {
          array_push($errorsGet, $value);
        }
      }
      // si $errorsGet vide en ajouter ls vals à DB
      if (count($errorsGet) == 0) {
        array_unshift($posts, $idProjet);
        return $dbLink->query(
          "INSERT INTO projet(id_projet, titre_projet, date_debut, date_fin, budget, pays, nombre_employes_assigne, duree, chef, id_client, nature_traveaux)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
          array_values($posts)
        );
      } else{
        $_SESSION['errors']['warning'] = $errorsGet;
        return FALSE;
      }
    }

    /**
     * update le projet
     * @param $params Array les ifos que en mettant à jour
     * @return Boolean TRUE si ls mis à jours effectuer ou FALSE sinon
     */
    public function updateProject($dbLink, $posts) {

      $errors = array(
        "Remplissez le champ de titre  de projet;",
        "Remplissez le champ de budget;",
        "Vous oubliez le champ de date de debut;",
        "Saisez une date valide dans le champ de date de fin;",
        "Le champ de pays est vide;",
        "Remplissez le champ de nombre d'employes;",
        "Remplissez le champ de duree;",
        "Verifiez le champ correspondant au client;",
        "Vous laissez le champ de chef vide;",
        "Attention, selectionnez la nature des traveaux;"
      );

      // verifier si les posts sont bien remplit et ls vals englonbees sont valide
      $errorsGet = $this->isValide($posts, $errors);
      if(is_array($errorsGet)){
        foreach ($errorsGet as $value) {
          array_push($errorsGet, $value);
        }
      }

      // si $errorsGet vide en applique ls mis à jours dans DB
      if (count($errorsGet) == 0) {
        if($dbLink->query(
          "UPDATE projet
            SET titre_projet=?, budget=?, date_debut=?, date_fin=?, pays=?, nombre_employes_assigne=?, duree=?, id_client=?, chef=?, nature_traveaux=?
            WHERE id_projet=?",
          array_values($posts)
        )) return $_SESSION['notification']['success'] = "Vous modifiez le projet {$posts['titreProjet']}.";
        else {
          $_SESSION['notification']['danger'] = "Erreur en base de  donnees.";
          return FALSE;
        }
      } else{
        $_SESSION['errors']['warning'] = $errorsGet;
        return FALSE;
      }
    }


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
