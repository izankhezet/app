<?php

  namespace Model\Uses;

  /**
   * recuperer l employe de qui a ls privileges de DRH
   */
  class Drh extends Share {

    function __construct() {}


      /**
       * ajouter un employe
       * @param $dbLink Model\DB\DbDrivers lien vers DB
       * @param $posts Array les valeur des champ de table employe
       * @return Boolean True si l'insertion a bient faite sinon FALSE
       */
      public function addEmploye($dbLink, $posts, $rip, $photo, $outils) {
        $matricule = $posts['matricule'];
        $errorsGet = array();
        $errors = array(
          "verfiez le champ de matricule.",
          "verfiez le champ de nom.",
          "verfiez le champ de prenom.",
          "verfiez le champ de adresse.",
          "verfiez le champ de mobile (0xxxxxxxxx).",
          "verfiez le champ de mobile professionnel (0xxxxxxxxx).",
          "verfiez le champ de email.",
          "verfiez le champ de sexe.",
          "verfiez le champ de date de naissance (xx/xx/201x).",
          "verfiez le champ de lieu de naissance (xx/xx/201x).",
          "verfiez le champ de titre de poste.",
          "verfiez le champ de deparetement.",
          "verfiez le champ de duree de contart.",
          "verfiez le champ de date debut de contrat.",
          "verfiez le champ de nature de contrat.",
          "verfiez le champ de vehiculede service",
          "verfiez le champ de diplome",
          "verfiez le champ de experince",
          "verfiez le champ de group sanguin",
          "verfiez le champ de numero de securite social"
        );

        //verifier si le matricule est unique
        if(trim($matricule) == "" || $dbLink->query("SELECT * from personnel WHERE matricule = ?", [$matricule]))
          $errorsGet[] = 'Ce matricule existe deja ou vous avez laisse le champ de id vide.';

        //retirer le 1er element de posts qui correspond à matricule de personnel car a deja ete verifie
        array_shift($posts);
        $outilsString = "";
        if(!empty($outils)){
          foreach ($outils as $key => $value) {
            $outilsString .= $value . ", ";
          }
        }

        // verifier si les posts sont bien remplit et ls vals englonbees sont valide
        if(is_array($this->isValide($posts, $errors))){
          foreach ($this->isValide($posts, $errors) as $value) {
            array_push($errorsGet, $value);
          }
        }
        //verifier si le rip et la photo sont bien uploader
        if(!$rip) array_push($errorsGet, "Vous oubiez le rip de l'employe.");
        if(!$photo) array_push($errorsGet, "Vous oubiez la photo de l'employe.");

        //ajouter les champ manque dans le array $posts
        array_unshift($posts, $matricule);
        array_push($posts, $rip);
        array_push($posts, $photo);
        if($outilsString) array_push($posts, $outilsString);


        // si $errorsGet vide en ajouter ls vals à DB
        if (count($errorsGet) == 0) {
          return $dbLink->query(
            "INSERT INTO personnel (matricule, nom, prenom, adresse, mobile, mobilePro, email, sexe,
              date_de_naissance, lieu_de_naissance, titre_de_poste, deparetement, duree_de_contrat, date_debut_contrat,
              nature_de_contrat, vehicule_service, diplome, experience, group_sanguin, numero_securite_social,
              rip, photo, hasCount, outils)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 0, ?)",
            array_values($posts)
          );
        } else{
          // supprimer le images uploader en cas ls ifos n 'inserer pas à DB
          unlink(ROOT . "/images/employeRips" . $rip);
          unlink(ROOT . "/images/employePhotos" . $photo);
          $_SESSION['errors']['warning'] = $errorsGet;
          return FALSE;
        }
      }

      /**
       * ajouter un employe
       * @param $dbLink Model\DB\DbDrivers lien vers DB
       * @param $posts Array les valeur des champ de table employe
       * @return Boolean True si l'insertion a bient faite sinon FALSE
       */
      public function updateEmploye($dbLink, $posts, $outils) {
        $matricule = $posts['matricule'];
        $errorsGet = array();
        $errors = array(
          "verfiez le champ de nom.",
          "verfiez le champ de prenom.",
          "verfiez le champ de mobile (0xxxxxxxxx).",
          "verfiez le champ de mobile professionnel (0xxxxxxxxx).",
          "verfiez le champ de date de naissance (xx/xx/201x).",
          "verfiez le champ de lieu de naissance (xx/xx/201x).",
          "verfiez le champ de adresse.",
          "verfiez le champ de email.",
          "verfiez le champ de sexe.",
          "verfiez le champ de titre de poste.",
          "verfiez le champ de deparetement.",
          "verfiez le champ de duree de contart.",
          "verfiez le champ de date debut de contrat.",
          "verfiez le champ de nature de contrat.",
          "verfiez le champ de vehiculede service",
          "verfiez le champ de diplome",
          "verfiez le champ de experince",
          "verfiez le champ de group sanguin",
          "verfiez le champ de numero de securite social"
        );

        //recuperer les outils
        $oldOutils = $dbLink->query("SELECT outils from personnel WHERE matricule = ?", [$matricule])->outils;

        //ajouter ls new outils
        $outilsString = $oldOutils;
        if(!empty($outils)){
          foreach ($outils as $key => $value) {
            $outilsString .= $value . ", ";
          }
        }

        //ajouter les champ manque dans le array $posts
        array_unshift($posts, $outilsString);

        // si $errorsGet vide en ajouter ls vals à DB
        if ($dbLink->query(
          "UPDATE personnel SET outils=?,nom=?,prenom=?,mobile=?,mobilePro=?,date_de_naissance=?,lieu_de_naissance=?,
            adresse=?,email=?,sexe=?, titre_de_poste=?,deparetement=?,
            duree_de_contrat=?,date_debut_contrat=?,
            nature_de_contrat=?,vehicule_service=?,diplome=?,experience=?,group_sanguin=?,
            numero_securite_social=?,date_fin_contrat=?,date_depart=?,motif_depart=?
            WHERE matricule = ?",
          array_values($posts)
        )) {
          return $_SESSION['notification']['success'] = "Les mis à jours sont appliques.";
        } else{
          $_SESSION['errors']['warning'] = $errorsGet;
          return FALSE;
        }
      }








  }
