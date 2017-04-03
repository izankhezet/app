<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php if(isset($title)) echo $title ?></title>
    <link rel="stylesheet" href="http://127.0.0.1/app/View/default/css/bootstrap.min.css"/>
    <style media="screen">
      body{background: url('http://127.0.0.1/app/View/default/imgs/bg.jpg') fixed no-repeat; background-size: cover;}
      .btn{cursor: pointer;}
    </style>
  </head>
  <body >

    <!-- navbar of app -->
    <nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse">
      <a class="navbar-brand" href="?p=home" style="border-radius:2px;">D@y£n</a>
      <?php if (!empty($_SESSION['__user'])): ?>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav mr-auto mt-2 mt-md-0">
            <li class="nav-item" style="border-bottom:1px solid #444444;">
              <a class="nav-link" href="?p=compte" style="position:relative;"><span class="badge badge-pill badge-default" style="font-size:16px;"><?= $_SESSION['__user']->privileges ?></span> <?= $_SESSION['__user']->nom . " " . $_SESSION['__user']->prenom ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?p=home&amp;deconnect=<?= hash("sha256", "yes") ?>">Deconnecter</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
      <?php endif; ?>
    </nav>

    <!-- succes de connexion  -->
    <?php if (isset($_SESSION['loggedSuccess'])): ?>
      <div class="alert alert-info fade show alert-dismissible text-center">
        <button type="button" class="close" data-dismiss='alert'>&times;</button>
        <p><?= $_SESSION['loggedSuccess']; ?></p>
      </div>
    <?php endif; $_SESSION['loggedSuccess'] = NULL;?>

    <!-- afficher une notification  -->
    <?php if (isset($_SESSION['notification'])): ?>
      <?php foreach ($_SESSION['notification'] as $type => $notificationValue): ?>
        <div class="alert alert-<?= $type ?> fade show alert-dismissible text-center">
          <button type="button" class="close" data-dismiss='alert'>&times;</button>
          <p><?= $notificationValue; ?></p>
        </div>
      <?php endforeach; ?>
    <?php endif;$_SESSION['notification'] = NULL; ?>

    <!-- afficher les errors d insertion -->
    <?php if (isset($_SESSION['errors'])): ?>
      <?php foreach ($_SESSION['errors'] as $type => $errors): ?>
        <div class="alert alert-<?= $type ?> fade show alert-dismissible">
          <button type="button" class="close" data-dismiss='alert'>&times;</button>
          <ol>
            <?php foreach ($errors as $error): ?>
              <li><?= $error ?></li>
            <?php endforeach; ?>
          </ol>
        </div>
      <?php endforeach; ?>
    <?php endif;$_SESSION['errors'] = NULL; ?>

    <!-- load content of pages -->
    <div class="container" style="margin-top:40px">
      <div class="card carrd-outline-primary">
        <div class="card-block"><?= $content ?></div>
        <div class="card-footer">
          <div class="row text-muted text-center">
            <div class="col-sm-4"><a href="mailto:siemaahlsidem@gmail.com?subject=feedback" class="card-link">Contact via email</a></div>
            <div class="col-sm-4"><a href="#" class="card-link">Notre site</a></div>
            <div class="col-sm-4">Amegroudh Ait Berahim, Setif</div>
          </div>
        </div>
      </div>
    </div>

    <!-- cherger les script de type javascript pour affiner les dependeance -->
    <script src="http://127.0.0.1/app/View/default/js/jquery-3.2.0.min.js" charset="utf-8" type="text/javascript"></script>
    <script src="http://127.0.0.1/app/View/default/js/bootstrap.min.js" charset="utf-8" type="text/javascript"></script>
    <script type="text/javascript">
      $('.nav-link').click(function(event) {
        var $target = $(this).attr('href');
        $('.nav-link.active').removeClass('active');
        $(this).addClass('active');
        $('.collapse.show').toggleClass('show');
      });
    </script>
  </body>
</html>
