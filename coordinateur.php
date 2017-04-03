<?php use Core\App;
$wilayas = $user->getAllWilaya(); ?>

<!-- l'ajout des sites et des missions taches -->
<div class="card ">
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <li class="nav-item"><a href="#addSite" data-toggle='collapse' class="nav-link active">Ajouter Site</a></li>
    </ul>
  </div>
  <div class="card-block" >

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
    <div id="addSite" class="collapse show">
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
            <?php
              // recuperer la liste des clients
              $clients = $user->getAllClient(); ?>
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
