<?php
  use \Core\App;

  //deconnexion de user
  if(isset($_GET['p'], $_GET['deconnect']) && $_GET['p'] == "home" && $_GET['deconnect'] == hash('sha256', "yes")){
    unset($_SESSION);
    unset($_COOKIE['__user']);
    session_destroy();
    Core\App::redirect("?p=login");
  }
  //titre de partie content
  $title = $_SESSION['__user']->nom . " " . $_SESSION['__user']->prenom;
  $privileges = $_SESSION['__user']->privileges;

  //recuperer 1instance de DB de Mysql
  $dbLink = new Model\DB\Mysql();
  $pdo = $dbLink->getPDO();
  // charger Bootstrap
  $boot = new View\Bootstrap();
  // instancier la class User
  $user  = new Model\Uses\User($dbLink);
  // l'utilisateur courant
  $currentUser = $_SESSION['__user'];
  ?>

<!-- afficher pour chaque user son UI -->
<?php if ($privileges == 'a'): ?>
  <?php require"View/pages/userHome/admin.php"; ?>

<!-- es privileges de coordinateur -->
<?php elseif($privileges == 'b'): ?>
  <?php require "View/pages/userHome/coordinateur.php" ?>

<!-- les privileges de chef de projet -->
<?php elseif($privileges == 'c'): ?>
  <?php require "View/pages/userHome/chef.php" ?>

<?php elseif($privileges == 'd'): ?>
  <?php

    if(isset($_POST['addEmploye'])){
      array_pop($_POST);//supprimer la dernier valeur de array qui vaut à button de summission
      $outils = array();
      if(!empty($_POST['outils'])) $outils = array_pop($_POST);
      if(
        $currentUser->addEmploye(
          $dbLink,
          App::escapeValues($_POST),
          App::uploadImage($_FILES['rip'], ROOT. "/images/employeRips", $_POST['matricule'].ucwords($_POST['nom'].$_POST['prenom'])),
          App::uploadImage($_FILES['photo'], ROOT. "/images/employePhotos", $_POST['matricule'].ucwords($_POST['nom'].$_POST['prenom'])),
          $outils
          )
        )
        $_SESSION['notification']['success'] = "Vous avez ajouter un nouveau employe {$_POST['nom']} {$_POST['prenom']}.";
        \Core\App::redirect('?p=home');
    }

   ?>
  <form class="" action="#" method="post" enctype="multipart/form-data">
    <fieldset>
      <legend class="text-muted text-center" style="font-size:22px;font-weight:500">Ajouter un employe:</legend>
      <div class="row">
        <?= $boot->wrap($boot->input('matricule', 'Matricule de l\'employe:', '15Ae'), 'col-sm-6') ?>
        <?= $boot->wrap($boot->input('nom', 'nom de l\'employe:', 'Winathan'), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('prenom', 'Prenom de l\'employe:', 'Thiziri'), 'col-sm-6') ?>
        <?= $boot->wrap($boot->input('adresse', 'Adresse:', 'thala u legradj'), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('mobile', 'Num Tel (mobile personnel):', '0122334455'), 'col-sm-6') ?>
        <?= $boot->wrap($boot->input('mobilePro', 'Num Tel (mobile professionnel):', '0122334455'), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('email', 'Email:', 'khezet@dayen.com', 'mail'), 'col-sm-6') ?>
        <?= $boot->wrap($boot->select('sexe', 'Sexe:', array("Male", "Female")), 'col-sm-6') ?>
      </div>
      <div class="row">
        <div class="form-group col-sm-6">
          <label for="photo" class="form-control-label">Photo:</label>
          <input type="file" name="photo" class="form-control-file" id="photo" style="border: 1px #dadada solid;border-radius:2px; width:100%">
        </div>
        <?= $boot->wrap($boot->input('dateNaissance', 'Date de naissance:', '02/02/2017'), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('lieuNaissance', 'Lieu de naissance:', 'Aghalad Imedjat'), 'col-sm-6') ?>
        <?= $boot->wrap($boot->input('titrePoste', 'Titre de poste:', 'manager'), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->select('deparetement', 'Deparetement:', array('Engennring', 'Finance', 'DRH', 'Informatique')), 'col-sm-6') ?>
        <?= $boot->wrap($boot->input('dureeContrat', 'Duree de contrat:', '6 mois'), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('dateDebutContrat', 'Date debut de contrat:', '15/07/2017'), 'col-sm-6') ?>
        <?= $boot->wrap($boot->select('natureContrat', 'Nature de contart:', array('CDD', 'CDI')), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->select('vehiculeService', 'Vehicule service:', array(1, 0), array('Oui', "Non")), 'col-sm-6') ?>
        <?= $boot->wrap($boot->input('diplome', 'Diplome:', 'ingenieur'), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('experince', 'Experience:', '2 annees'), 'col-sm-6') ?>
        <?= $boot->wrap($boot->select('groupSanguin', 'Group sanguin:', array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', "O+", 'O-')), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('nss', 'Numero de securite social:', '15072017'), 'col-sm-6') ?>
        <div class="form-group col-sm-6">
          <label for="rip" class="form-control-label">Rip:</label>
          <input type="file" name="rip" class="form-control-file" id="rip" style="border: 1px #dadada solid;border-radius:2px; width:100%">
        </div>
      </div>
      <div class="row">
        <label class="form-control-label col-12">Outils:</label>
        <div class="form-group col">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="outils[]" value="PC">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Pc</span>
          </label>
        </div>
        <div class="form-group col">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="outils[]" value="Sim">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Sim</span>
          </label>
        </div>
        <div class="form-group col">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="outils[]" value="chargeur">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Chargeur</span>
          </label>
        </div>
        <div class="form-group col">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="outils[]" value="Camera">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Camera</span>
          </label>
        </div>
        <div class="form-group col">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="outils[]" value="GPS">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Gps</span>
          </label>
        </div>
        <div class="form-group col">
          <label class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" name="outils[]" value="Batterie">
            <span class="custom-control-indicator"></span>
            <span class="custom-control-description">Batterie</span>
          </label>
        </div>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->button('addEmploye', "btn btn-outline-primary btn-block", "Ajouter Employe"), 'col') ?>
      </div>
    </fieldset>
  </form>

  <!-- afficher la liste des Employes -->
  <?php
    $employes = $user->getAllEmployes();
    if(!empty($employes)){
    ?>
    <table class="table table-responsive table-bordered table-inverse table-hover">
      <thead>
        <tr>
          <td>Photo</td>
          <td>Nom et Prenom</td>
          <td>Adresse</td>
          <td>Email</td>
          <td>Mobile</td>
          <td>Mobile Pro</td>
          <td>Modifier</td>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($employes as $employe): ?>
          <tr>
            <td ><img class="img-fluid" style="height:50px; width:70px" src="http://127.0.0.1/app/images/employePhotos<?= $employe->photo ?>" alt=""></td>
            <td><?= $employe->nom . " " . $employe->prenom ?></td>
            <td><?= $employe->adresse ?></td>
            <td><?= $employe->email ?></td>
            <td><?= $employe->mobile ?></td>
            <td><?= $employe->mobilePro ?></td>
            <td><a href="?p=update&amp;employe=<?= $employe->matricule ?>" class="btn btn-block btn-outline-warning">Modifie <?= $employe->nom . " " . $employe->prenom ?></a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php
    }
   ?>

<?php elseif($privileges == 'e'): ?>
  <h1>Employe de terrain</h1>
<?php endif; ?>

























<!--  -->
