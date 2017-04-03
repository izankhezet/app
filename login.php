<?php

  if (isset($_POST['logged']) && isset($_POST['pseudoname'], $_POST['password'])) {
    extract($_POST);
    $auth = new Control\Auth\Auth(new Model\DB\Mysql());
    
    if($auth->tryToConnect($pseudoname, $password)) {
      $_SESSION['loggedSuccess'] = "Bienvenue {$_SESSION['__user']->nom} {$_SESSION['__user']->prenom}, Vous connectez à " . date('G:i:s d/m/y');
      // if(isset($_POST['stayConnect'])) setcookie("__user", hash('sha256', "d@y£n" . $_SESSION['__user']->matricule), time() + 3600 * 24 * 30);
      Core\App::redirect('?p=home');
    }
  }

  $title = "Login";
  $boot = new \View\Bootstrap();
?>
<form class="row  " action="#" method="post" enctype="application/x-www-form-urlencoded">

  <?php if (empty($_SESSION['loggedError']['pseudoname'])): ?>
    <?= $boot->wrap($boot->input("pseudoname", "Numero de Tel: ", "0122334455", "text"), "col-sm-6"); ?>
  <?php else: ?>
    <?= $boot->wrap($boot->input("pseudoname", "Numero de Tel: ", "0122334455", "text", $_POST['pseudoname'], $_SESSION['loggedError']['pseudoname']), "col-sm-6"); ?>
  <?php endif; ?>

  <?php if (empty($_SESSION['loggedError']['password'])): ?>
    <?= $boot->wrap($boot->input("password", "Mot de pass:", "********", "password"), 'col-sm-6'); ?>
  <?php else: ?>
    <?= $boot->wrap($boot->input("password", "Mot de pass:", "********", "password", NULL, $_SESSION['loggedError']['password']), 'col-sm-6'); ?>
  <?php endif; ?>
  <!-- ce checkbox pour injecter un cookie ou non -->
  <div class="row col-sm-12">
    <label class="custom-control custom-checkbox">
      <input type="checkbox" name="stayConnect" class="custom-control-input" checked="true">
      <div class="custom-control-indicator"></div>
      <div class="custom-control-description">Reste en ligne.</div>
    </label>
    <div class="col">Si vous oubliez le mot de pass <a href="#" title="cliquer pour recuperer votre mot de pass">cliquez ici.</a></div>
  </div>

  <?= $boot->wrap($boot->button("logged", "btn btn-outline-success btn-block", "Se connecter"), "col-sm-12"); ?>

</form>
<?php $_SESSION['loggedError'] = NULL; ?>
