<?php use \Core\App; ?>
<?php $wilayas = $user->getAllWilaya(); ?>
<!-- menu pour ajouter ls clients et ls projets -->
<div class="card ">
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item"><a href="#addClient" data-toggle='collapse' class="nav-link active">Ajouter Client</a></li>
      <li class="nav-item"><a href="#addProjet" data-toggle='collapse' class="nav-link">Ajouter Projet</a></li>
      <li class="nav-item"><a href="#addSite" data-toggle='collapse' class="nav-link">Ajouter Site</a></li>
    </ul>
  </div>
  <div class="card-block" >
    <!-- ajouter un nouveau client  -->
    <?php

      if(isset($_POST['addClient'])){
        array_pop($_POST);//supprimer la dernier valeur de array qui vaut à button de summission
        if($currentUser->addClient($dbLink, App::escapeValues($_POST), Core\App::uploadImage($_FILES['rip'], ROOT. "/images/clientRip", $_POST['idClient'])))
          $_SESSION['notification']['success'] = "Vous avez ajouter un nouveau client.";
          \Core\App::redirect('?p=home');
      }

     ?>
    <div id="addClient" class="collapse show">
      <h4 class="card-title text-muted text-center">Ajouter un nouveau client</h4>
      <form class="" action="#" method="post" enctype="multipart/form-data">
        <div class="row">
          <?= $boot->wrap($boot->input('idClient', 'Id de client:', '15Ae'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('rai', 'RAI de client:', 'dayen'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('adresse', 'Adresse:', 'Amegroud Ait Berahim'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('registreComerce', 'Registre de commerce:', '12548678'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('tel', 'Numero de Telephone:', '036458798', 'tel'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('email', 'Adresse mail:', 'siemah@dayen.com', "mail"), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('nif', 'NIF de client:', 'kera da'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('fax', 'Numero de FAX:', '021548678', 'tel'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('nis', 'NIS client:', 'nis'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('ai', 'AI de client:', 'AI client'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <label for="idWilaya" class="form-control-label">Wilaya:</label>
            <select class="form-control" name="idWilaya" id="idWilaya">
              <?php foreach ($wilayas as $wilaya): ?>
                <option value="<?= $wilaya->id_wilaya ?>"><?= $wilaya->nom_wilaya ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col">
            <label class="form-control-label" for="rip">Rip de client</label>
            <input type="file" accept="image/jpeg,image/x-png,image/gif" name="rip" class="form-control-file" id='rip'>
          </div>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->button('addClient', "btn btn-outline-success btn-block", "Ajouter le client"), "col-sm-12") ?>
        </div>
      </form>
    </div>

    <!-- ajouter un nouveau projet -->
    <?php

      if(isset($_POST['addProjet'])){
        array_pop($_POST);//supprimer la dernier valeur de array qui vaut à button de summission
        if($currentUser->addProject($dbLink, App::escapeValues($_POST))){
          $_SESSION['notification']['success'] = "Vous avez ajouter un nouveau projet.";
          Core\App::redirect('?p=home');
        }
      }
      // recuperer la liste des clients
      $clients = $user->getAllClient();
     ?>
    <div id="addProjet" class="collapse">
      <h4 class="card-title text-muted text-center">Informations du nouveau projet</h4>
      <form class="" action="#" method="post" enctype="application/x-www-form-urlencoded">
        <div class="row">
          <?= $boot->wrap($boot->input('idProjet', 'Id de Projet:', 'DaY196'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('titreProjet', 'Titre de projet:', 'InstalationMob'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('dateDebut', 'Date de debut:', '12/07/2017'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('dateFin', 'Date de fin:', '02/04/2018', 'text', '00/00/2017'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('budget', 'Budget de projet:', '150000'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('pays', 'Pays:', 'Algeria', 'text', 'Algeria'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('nbrEmployesAssigne', 'Nombre d\'employes assignes:', '45'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('duree', 'Duree estimee:', '2 mois'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <label for="chef" class="form-control-label">Chef de projet</label>
            <select class="form-control" name="chef" id="chef">
              <?php foreach ($user->getAllProjectChef() as $chef): ?>
                <option value="<?= $chef->matricule ?>"><?= $chef->nom. ' ' .$chef->prenom ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="form-group col-sm-6">
            <label for="client" class="form-control-label">Client:</label>
            <select class="form-control" name="idClient">
              <?php foreach ($clients as $client): ?>
                <option value="<?= $client->id_client ?>"><?= $client->rai ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-12">
            <label for="natureTraveau" class="form-control-label">Nature des traveax:</label>
            <select class="form-control" name="natureTraveau" id="natureTraveau">
              <option value="Instalation">Instalation</option>
              <option value="Maintenance">Maintenance</option>
              <option value="Surveille">Surveille</option>
            </select>
          </div>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->button('addProjet', "btn btn-outline-primary btn-block", "Ajouter un projet"), "col-sm-12") ?>
        </div>
      </form>
    </div>

    <?php
      if(isset($_POST['addSite'])){
        array_pop($_POST);//supprimer la dernier valeur de array qui vaut à button de summission
        if($currentUser->addSite($dbLink, App::escapeValues($_POST))){
          $_SESSION['notification']['info'] = "Vous avez ajouter un nouveau site.";
          Core\App::redirect('?p=home');
        }
      }
     ?>
    <!-- ajouter un site -->
    <div id="addSite" class="collapse">
      <h4 class="card-title text-muted text-center">Ajouter un nouveau site</h4>
      <form class="" action="" method="post">
        <div class="row">
          <?= $boot->wrap($boot->input('idSite', 'Id de site:', '15Ae'), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('region', 'region site:', 'Amegroudh'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->select('nature', 'Nature de site:', array('green floor', 'micro cell', 'rt')), 'col-sm-6') ?>
          <?php
            $usersEmploye = array();
            $usersValues = array();
            foreach ($user->getAllUsers() as $userEmploye) {
              array_push($usersEmploye, $userEmploye->matricule);
              array_push($usersValues, $userEmploye->nom . " " . $userEmploye->prenom);
            }
            echo $boot->wrap($boot->select('employe', 'Responsable:', $usersEmploye, $usersValues), "col-sm-6");
           ?>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <?php if (!empty($clients)): ?>
              <label for="clientID" class="form-control-label">Client:</label>
              <select class="form-control" name="clientID" id="clientID">
                <?php foreach ($clients as $client): ?>
                  <option value="<?= $client->id_client ?>"><?= $client->rai ?></option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>
          </div>
          <div class="form-group col-sm-6">
            <?php
              // recuperer la liste des projets
              $projets = $user->getAllProjects();
               ?>
            <?php if (!empty($projets)): ?>
              <label for="projetID" class="form-control-label">Projet:</label>
              <select class="form-control" name="projetID" id="projetID">
                <?php foreach ($projets as $projet): ?>
                  <option value="<?= $projet->id_projet ?>"><?= $projet->titre_projet ?></option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <label for="idWilaya" class="form-control-label">Wilaya:</label>
            <select class="form-control" name="idWilaya" id="idWilaya">
              <?php foreach ($wilayas as $wilaya): ?>
                <option value="<?= $wilaya->id_wilaya ?>"><?= $wilaya->nom_wilaya ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <?= $boot->wrap($boot->input('longitude', 'Longitude de site:', '15\'45 35'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('altitude', 'Altitude de site:', "15¨5 35"), 'col-sm-6') ?>
          <?= $boot->wrap($boot->input('laltitude', 'Laltitude de site:', '15\'45 35'), 'col-sm-6') ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->button('addSite', "btn btn-outline-info btn-block", "Ajouter Site"), "col-sm-12") ?>
        </div>
      </form>
    </div>

  </div>

</div>

<!-- afficher ls liste ds clients -->
<?php if (!empty($clients)): ?>
  <h2 class="text-muted text-center">Les informations de tous les clients:</h2>
  <table class="table table-responsive table-inverse table-striped">
    <thead class="thead-default">
      <tr class="">
        <td>RAI client</td>
        <td>Adresse</td>
        <td>Email</td>
        <td>Telephone</td>
        <td>Fax client</td>
        <td>Modifier</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($clients as $client): ?>
        <tr>
          <td><?= $client->rai ?></td>
          <td><?= $client->adresse ?></td>
          <td><?= $client->emailClient ?></td>
          <td><?= $client->telClient ?></td>
          <td><?= $client->fax ?></td>
          <td><a href="?p=update&amp;client=<?= $client->id_client ?>" class="btn btn-sm btn-outline-success btn-block">Modifez <?= $client->rai ?></a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<!-- afficher ls liste ds projets -->
<?php if (!empty($projets)): ?>
  <h2 class="text-muted text-center">La liste des projets:</h2>
  <table class="table table-responsive table-striped table-bordered table-hover">
    <thead class="thead-default">
      <tr class="table-active">
        <td>Titre</td>
        <td>Nature</td>
        <td>Date de debut</td>
        <td>Date de fin</td>
        <td>Duree</td>
        <td>Budget</td>
        <td>Chef de projet</td>
        <td>Nombre d'employes assignes</td>
        <td>Modification</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($projets as $projet): ?>
        <tr>
          <td><?= $projet->titre_projet ?></td>
          <td><?= $projet->nature_traveaux ?></td>
          <td><?= $projet->date_debut ?></td>
          <td><?= $projet->date_fin ?></td>
          <td><?= $projet->duree ?></td>
          <td><?= $projet->budget ?></td>
          <td>
            <?php
              $projectChef = $user->getProjectChef($projet->chef);
              print($projectChef->nom . " " . $projectChef->prenom);
             ?>
          </td>
          <td><?= $projet->nombre_employes_assigne ?></td>
          <td><a href="?p=update&amp;projet=<?= $projet->id_projet ?>" class="btn btn-outline-primary btn-block btn-sm">Modifez ce projet</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<!-- afficher ls liste ds sites -->
<?php $sites = $user->getAllSites();
  if (!empty($sites)): ?>
  <h2 class="text-muted text-center">La liste des sites:</h2>
  <table class="table table-responsive table-striped table-bordered table-hover">
    <thead class="table-inverse">
      <tr class="table-active">
        <td>Region</td>
        <td>Wilaya</td>
        <td>Nature</td>
        <td>Client</td>
        <td>Person</td>
        <td>Projet</td>
        <td>Longitude</td>
        <td>Latitude</td>
        <td>Altitude</td>
        <td>Modification</td>
      </tr>
    </thead>
    <tbody class="text-center">
      <?php foreach ($sites as $site): ?>
        <tr>
          <td><?= $site->region ?></td>
          <td>
            <?php
            $wilaya = $user->getWilaya($site->id_wilaya);
            print($wilaya->nom_wilaya);
            ?>
           </td>
          <td><?= $site->nature ?></td>
          <td>
            <?php
              $client = $user->getClient($site->id_client);
              print($client->rai);
             ?>
           </td>
          <td>
           <?php
             $person = $user->getPerson($site->id_persone);
             print($person->nom . " " . $person->prenom);
            ?>
          </td>
          <td>
            <?php
            $projet = $user->getProjet($site->id_projet);
            print($projet->titre_projet);
            ?>
          </td>
          <td><?= $site->longitude ?></td>
          <td><?= $site->latitude ?></td>
          <td><?= $site->altitude ?></td>
          <td><a href="?p=update&amp;site=<?= $site->id_site ?>" class="btn btn-outline-info btn-block btn-sm">Modifez le site</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
