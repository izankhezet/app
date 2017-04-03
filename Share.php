<?php

  namespace Model\Uses;

  /**
   * cette class a pour but de partager ls methode en commun entre ls class de Uses
   */
  class Share {

    function __construct() {}

    /**
    * validation des posts et retourner des erreurs en cas la validation a ete echouee
    * @param $posts Array comprend les infos doit etre valider
    * @param $errors Array liste des erreurs a afficher
    * @return Array liste des erreur
    */
    public function isValide($posts, $errors) {
      $errorsGet = array();$i = 0;
      foreach ($posts as $key => $post) {
        if($key != "email" && $key != "dateDebut" && $key != "dateFin" && $key != "tel" || $key != "fax" || $key != "mobilePro" || $key != "mobile"){
          if(trim($post) == ""){
            $errorsGet[] = $errors[$i];
          }
        } else if ($key == "email" && !filter_var($post, FILTER_VALIDATE_EMAIL)) {
          $errorsGet[] = $errors[$i];
        } else if (($key == "tel" || $key == "fax" || $key = "mobilePro" || $key = "mobile") && !preg_match('#^0[0-9]{8,9}$#', $post)) {
          $errorsGet[] = $errors[$i];
        } else if (($key == "dateDebut" || $key == "dateFin" || $key == "dateNaissance" || $key == 'dateDebutContrat') && !preg_match('#[0-9]{2}/[0-9]{2}/[12][0-9]{3}#', $post)) {
          $errorsGet[] = $errors[$i];
        }
        $i++;
      }
      return $errorsGet;
    }

    /**
     * update le password
     * @param $posts Array de ls valeurs besion pour update le password
     */
    public function updatePassword($dbLink, $oldPass, $newPass, $confPass, $mobile) {
      $errors = array();
      if(strlen(trim($oldPass)) == 0) $errors['oldPassword'] = "Vous oubliez le champ d ancien password.";
      if(strlen(trim($newPass, " ")) < 6) $errors['newPassword'] = "Votre mot de pass est tres court +6 cars.";
      if($newPass != $confPass) $errors['confPass'] = "La valeur de confirmation doit etre vaut celle de mot de pass.";
      if(!preg_match('#^0[0-9]{9}$#', $mobile)) $errors['mobile'] = "Taper un numero de telephone correct(suivant cette format 0xxxxxxxxx)";
      if(count($errors) == 0 && $dbLink->query('UPDATE personnel SET password = :pass WHERE (mobile = :tel OR mobilePro = :tel) AND password = :oldPass',
        array("pass" => hash('sha256', "dayen" . $newPass), "tel" => $mobile, "oldPass" => hash('sha256', "dayen" . $oldPass)))
      ){
        return $_SESSION['notification']['info'] = "<span class'badge badge-pill badge-danger'>{$_SESSION['__user']->nom}</span>, vous avez modifie le mot de pass.";
      } else {
        $_SESSION['errors']['danger'] = $errors;
        return FALSE;
      }
    }

  }
