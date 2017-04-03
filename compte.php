<?php

  //recuperer  utilisateru courrant
  $currentUser = $_SESSION['__user'];

  if (isset($_POST['updatePassword'])) {
    extract($_POST);
    // if (empty($oldPassword)) $errors[] = "Vous oubliez de saisez ancien password.";
    // if (empty($newPassword)) $errors[] = "Il faut remplir nouveau password.";
    // if (empty($mobile)) $errors[] = "Vous oubliez de saisez ancien password.";
    // if (isset($newPassword, $confPassword)) $errors[] = "Le password doit etre vaut la valeur de confirmation de password.";
    if ($currentUser->updatePassword(new Model\DB\Mysql(), $oldPassword, $newPassword, $confPassword, $mobile)) {
      Core\App::redirect('?p=compte');
    };

  }

 ?>


<form class="" action="#" method="post" enctype="application/x-www-form-urlencoded">
  <fieldset>
    <legend>Chenger le mot de pass:</legend>
    <div class="row">
      <div class="form-group col-lg-6">
        <label for="oldPassword" class="form-control-addon">Ancien mot de pass</label>
        <input type="password" name="oldPassword" class="form-control" id="oldPassword" placeholder="*********">
      </div>
      <div class="form-group col-lg-6">
        <label for="mobile" class="form-control-addon">Mobile ou mobille Pro:</label>
        <input type="text" name="mobile" class="form-control" id="mobile" placeholder="036988795">
      </div>
    </div>
    <div class="row">
      <div class="form-group col-lg-6">
        <label for="newPassword" class="form-control-addon">Nouveau mot de pass</label>
        <input type="password" name="newPassword" class="form-control" placeholder="******" id="newPassword">
      </div>
      <div class="form-group col-lg-6">
        <label for="confPassword" class="form-control-label">Confirmer le mot de pass</label>
        <input type="password" name="confPassword" class="form-control" placeholder="******" id="confPassword">
      </div>
    </div>
    <div class="">
      <button type="submit" name="updatePassword" class="btn btn-outline-primary btn-block">Changer le mot de pass</button>
    </div>
  </fieldset>
</form>
