<!-- ajouter un utilisateur soit de employe de terrain ou de bureau -->
<?php

  use Core\App;
  
  if (!empty($_POST) && isset($_POST['addUser']) && !empty($_POST['userGrade']) && !empty($_POST['newUser'])) {
    if($currentUser->addUser($pdo, $_POST['userGrade'], $_POST['newUser'])){
      $_SESSION['notification']['success'] = "Vous avez ajouter un nouveau utilisateur avec succes.";
      App::redirect('?p=home');
    }
    else
      $_SESSION['notification']['success'] = "Vous ne pouvez pas ajouter un nouveau utilisateur, verfiez bien svp!";
  } else if(isset($_POST['addUser'])) $_SESSION['notification']['warning'] = "Vous voulez ajouter un utilisateur n'existe plus!";
 ?>
<form class="" action="#" method="post" enctype="application/x-www-form-urlencoded">
  <legend>Ajouter un utilisateur:</legend>
  <div class="row">
    <div class="col-sm-4">
      <label class="form-control-label" for="newUser">Nom: </label>
      <select class="form-control" name="newUser" id="newUser">
        <?php foreach ($user->getAllNonUsers() as $employe): ?>
          <option value="<?= $employe->matricule ?>"><?= $employe->nom. " " .$employe->prenom ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-sm-4">
      <label class="form-control-label" for="userGrade">Grade:</label>
      <select class="form-control" name="userGrade" id="userGrade">
        <option value="a">Admin</option>
        <option value="c">Chef de projet</option>
        <option value="d">DRH</option>
        <option value="b">Coordinateur</option>
        <option value="e" selected="selected">Employe de terrain</option>
      </select>
    </div>
    <div class="col-sm-4">
      <label class="form-control-label" for="userGrade">&nbsp;</label>
      <button type="submit" name="addUser" class="btn btn-outline-primary btn-block">Ajouter</button>
    </div>
  </div>
</form><br>

<!-- la liste des utilisateur crees et les modifications -->
<?php
  if(!empty($_GET[hash('sha256', 'userToRemove')])){
    $isAdmin = $dbLink->query('SELECT privileges FROM personnel WHERE matricule=?', array($_GET[hash('sha256', 'userToRemove')]));
    if($isAdmin->privileges != 'a'){
      if ($currentUser->removeUser($pdo, $_GET[hash('sha256', 'userToRemove')])) {
        $_SESSION['notification']['danger'] = "Vous supprimez un utilisateur.";
        \Core\App::redirect('?p=home');
      }
    } else {
      $_SESSION['notification']['info'] = "Vous ne pouvez pas supprimez cet utilisateur(soit est Admin ou un utilisateur n'existe pas.)";
      \Core\App::redirect('?p=home');
    }
  }
  $utilisateurs = $user->getAllUsers();
 ?>
<?php if (!empty($utilisateurs)): ?>
  <h2 class="text-muted text-center">La liste des utilisateurs:</h2>
  <table class="table table-responsive table-bordered table-hover table-striped ">
    <thead class="table-inverse">
      <tr class="active">
        <td>Nom</td>
        <td>Prenom</td>
        <td>Mobile (pseudoname)</td>
        <td>Email</td>
        <td>Grade</td>
        <td>Supprission</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($utilisateurs as $utilisateur): ?>
        <tr >
          <td><?= $utilisateur->nom ?></td>
          <td><?= $utilisateur->prenom ?></td>
          <td><?= $utilisateur->mobile ?></td>
          <td><?= $utilisateur->email ?></td>
          <td><?php
            if($utilisateur->privileges == "a") echo 'Admin';
            elseif($utilisateur->privileges == "b") echo "coordinateur";
            elseif($utilisateur->privileges == "c") echo 'chef de projet';
            elseif($utilisateur->privileges == "d") echo 'drh';
            elseif($utilisateur->privileges == "e") echo 'employe de terrain';
           ?></td>
          <td><a href="?p=home&amp;<?= hash('sha256', 'userToRemove') . '=' . $utilisateur->matricule ?>" class="btn btn-outline-danger btn-sm btn-block">supprimer</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>

  </table>
<?php endif; ?>
