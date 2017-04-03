<?php

  use Core\App;

  $currentUser = $_SESSION['__user'];
  $privileges = $currentUser->privileges;
  // verifier si il n'y a aucune valuer de _GET
  if((empty($_GET['client']) && $privileges != "c")
    && (empty($_GET['employe']) && $privileges != "d")
    && (empty($_GET['projet']) && $privileges != "c")
    && (empty($_GET['site'] && ($privileges != "c" || $privileges != "b")))) App::redirect('?p=home');

  $dbLink= new \Model\DB\Mysql();
  $user  = new Model\Uses\User($dbLink);
  $boot  = new View\Bootstrap();
  $title= $currentUser->nom . ' ' . $currentUser->prenom ;
  ?>

<?php if ($privileges === "a"): ?>
  <h2>Admin</h2>
<?php elseif ($privileges === "b"): ?>
  <?php
    // update le site
    if (isset($_POST['updateSite'])) {
      array_pop($_POST);
      if($currentUser->updateSite($dbLink, App::escapeValues($_POST))) App::redirect('?p=home');
    }
   ?>

   <!-- verfier si on update le client ou projet -->
   <?php
     if (!empty($_GET['site'])){
       $site = $user->getSite($_GET['site']);
       if(!$site) App::redirect('?p=home');
       ?>
       <form action="#" method="post" enctype="application/x-www-form-urlencoded">
         <div class="row">
           <?= $boot->wrap($boot->input('region', "Region de site:", "Azzaba", "text", $site->region), "col-sm-6") ?>
           <?= $boot->wrap($boot->input('nature', "Natude de site:", "install..", "text", $site->nature), "col-sm-6") ?>
         </div>
         <div class="row">
           <?php
             $clients = $user->getAllClient();
             $persons = $user->getAllUsers();
            ?>
            <div class="form-group col-sm-6">
              <label for="client" class="form-control-label">Client(owner):</label>
              <select class="form-control" name="client" id="client">
                <?php foreach ($clients as $client): ?>
                  <?php $selected = ""; if($site->id_client == $client->id_client) $selected = "selected='selected'" ?>
                  <option value="<?= $client->id_client ?>" <?= $selected ?>><?= $client->rai ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-sm-6">
              <label for="employe" class="form-control-label">Responsable de site:</label>
              <select class="form-control" name="employe" id="employe">
                <?php foreach ($persons as $person): ?>
                  <?php $selected = ""; if($site->id_persone == $person->matricule) $selected = "selected='selected'" ?>
                  <option value="<?= $person->matricule ?>" <?= $selected ?>><?= $person->nom . " " .$person->prenom ?></option>
                <?php endforeach; ?>
              </select>
            </div>
         </div>
         <div class="row">
           <?php
             $projets = $user->getAllProjects();
             $wilayas = $user->getAllWilaya();
            ?>
            <div class="form-group col-sm-6">
              <label for="projet" class="form-control-label">Projet:</label>
              <select class="form-control" name="projet" id="projet">
                <?php foreach ($projets as $projet): ?>
                  <?php $selected = ""; if($site->id_projet == $projet->id_projet) $selected = "selected='selected'" ?>
                  <option value="<?= $projet->id_projet ?>" <?= $selected ?>><?= $projet->titre_projet ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group col-sm-6">
              <label for="wilaya" class="form-control-label">Wilaya:</label>
              <select class="form-control" name="wilaya" id="wilaya">
                <?php foreach ($wilayas as $wilaya): ?>
                  <?php $selected = ""; if($site->id_wilaya == $wilaya->id_wilaya) $selected = "selected='selected'" ?>
                  <option value="<?= $wilaya->id_wilaya ?>" <?= $selected ?>><?= $wilaya->nom_wilaya ?></option>
                <?php endforeach; ?>
              </select>
            </div>
         </div>
         <div class="row">
           <?= $boot->wrap($boot->input('longitude', "Longitude:", "15'45895", "text", $site->longitude), "col-sm-4") ?>
           <?= $boot->wrap($boot->input('latitude', "Laltitude:", "15'45895", "text", $site->latitude), "col-sm-4") ?>
           <?= $boot->wrap($boot->input('altitude', "Altitude:", "15'45895", "text", $site->altitude), "col-sm-4") ?>
         </div>
         <div class="row">
           <input type="hidden" name="siteID" value="<?= $site->id_site ?>">
           <?= $boot->wrap($boot->button('updateSite', "btn btn-info btn-block active", "Valider les modifications"), "form-group col-sm-12") ?>
         </div>
       </form>
       <?php
     }
    ?>



<?php elseif ($privileges === "c"): ?>

  <!-- appliquer ls mis à jours  -->
  <?php
    // update le client
    if (isset($_POST['updateClient'])) {
      array_pop($_POST);
      if($currentUser->updateClient($dbLink, App::escapeValues($_POST))) App::redirect('?p=home');
    }
    // update le projet
    if (isset($_POST['updateProject'])) {
      array_pop($_POST);
      if($currentUser->updateProject($dbLink, App::escapeValues($_POST))) App::redirect('?p=home');
    }
    // update le site
    if (isset($_POST['updateSite'])) {
      array_pop($_POST);
      if($currentUser->updateSite($dbLink, App::escapeValues($_POST))) App::redirect('?p=home');
    }
   ?>

  <!-- verfier si on update le client ou projet -->
  <?php
    if (!empty($_GET['client'])){
      $client = $user->getClient($_GET['client']);
      if(!$client) App::redirect('?p=home');
      ?>
      <form action="#" method="post" enctype="application/x-www-form-urlencoded">
        <div class="row">
          <?= $boot->wrap($boot->input('rai', "RAI de client:", "Dayen Entr", "text", $client->rai), "col-sm-6") ?>
          <?= $boot->wrap($boot->input('adresse', "Adresse client:", "cite 32 juillet 56", "text", $client->adresse), "col-sm-6") ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('registreComerce', "Registre de commerce:", "12 548 789", "number", $client->registreCommerce), "col-sm-6") ?>
          <?= $boot->wrap($boot->input('telClient', "Numero de Telephone:", "021548795", "number", $client->telClient), "col-sm-6") ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('email', "Email:", "johndoe@dayen.com", "mail", $client->emailClient), "col-sm-6") ?>
          <?= $boot->wrap($boot->input('fax', "Numero de Fax:", "021548795", "number", $client->fax), "col-sm-6") ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('nif', "NIF de client:", "NIF", "text", $client->nif), "col-sm-6") ?>
          <?= $boot->wrap($boot->input('nis', "NIS de client:", "NIS", "text", $client->nis), "col-sm-6") ?>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <?php
              $wilayas = $user->getAllWilaya();
             ?>
             <label for="wilaya" class="form-control-label">Wilaya: </label>
             <select class="form-control" name="wilaya" id="wilaya">
               <?php foreach ($wilayas as $wilaya): ?>
                 <?php $selected = ""; if($wilaya->id_wilaya == $client->id_wilaya) $selected = "selected='selected'" ?>
                 <option value="<?= $wilaya->id_wilaya ?>" <?= $selected ?>><?= $wilaya->nom_wilaya ?></option>
               <?php endforeach; ?>
             </select>
          </div>
          <?= $boot->wrap($boot->input('ai', "AI de client:", "AI client", "text", $client->ai), "col-sm-6") ?>
        </div>
        <figure >
          <div class="row">
            <img src="http://127.0.0.1/app/images/clientRip<?= substr($client->ripClient, strpos($client->ripClient, "/")) ?>" alt="image de rip" class="col-sm-12" height="200px">
          </div>
          <figcaption class="text-center text-muted"><strong class="badge badge-danger">Rip de client</strong></figcaption>
        </figure>
        <div class="row">
          <input type="hidden" name="clientID" value="<?= $client->id_client ?>">
          <?= $boot->wrap($boot->button('updateClient', "btn btn-success btn-block", "Valider les modifications"), "form-group col-sm-12") ?>
        </div>
      </form>
      <?php
    }
    elseif (!empty($_GET['projet'])){
      $projet = $user->getProjet($_GET['projet']);
      if(!$projet) App::redirect('?p=home');
      ?>
      <form action="#" method="post" enctype="application/x-www-form-urlencoded">
        <div class="row">
          <?= $boot->wrap($boot->input('titreProjet', "Titre de projet:", "Instal..", "text", $projet->titre_projet), "col-sm-6") ?>
          <?= $boot->wrap($boot->input('budget', "Budget de projet:", "1562000", "text", $projet->budget), "col-sm-6") ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('dateDebut', "Date de debut:", "12/04/2017", "text", $projet->date_debut), "col-sm-6") ?>
          <?= $boot->wrap($boot->input('dateFin', 'Date de fin:', "12/03/2019", "text", $projet->date_fin), "col-sm-6") ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('pays', "Pays:", "Algeria", "text", $projet->pays), "col-sm-6") ?>
          <?= $boot->wrap($boot->input('nbrEmployesAssignes', "Nombre d'employes assignes:", "5", "number", $projet->nombre_employes_assigne), "col-sm-6") ?>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('duree', "Duree de projet:", "2 mois", "text", $projet->duree), "col-sm-6") ?>
          <div class="col-sm-6 form-group">
            <?php
              $clients = $user->getAllClient();
             ?>
             <label for="clientName" class="form-control-label">Client: </label>
             <select class="form-control" name="clientName" id="clientName">
               <?php foreach ($clients as $client): ?>
                 <?php $selected = ""; if($projet->id_client == $client->id_client) $selected = "selected='selected'" ?>
                 <option value="<?= $client->id_client ?>" <?= $selected ?>><?= $client->rai ?></option>
               <?php endforeach; ?>
             </select>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-sm-6">
            <?php
              $chefs = $user->getAllProjectChef();
             ?>
             <label for="chef" class="form-control-label">Chef de projet: </label>
             <select class="form-control" name="chef" id="chef">
               <?php foreach ($chefs as $chef): ?>
                 <?php $selected = ""; if($chef->matricule == $projet->chef) $selected = "selected='selected'" ?>
                 <option value="<?= $chef->matricule ?>" <?= $selected ?>><?= $chef->nom . ' ' . $chef->prenom ?></option>
               <?php endforeach; ?>
             </select>
          </div>
          <div class="form-group col-sm-6">
            <?php
              $natureTraveau = array('Instalation', 'Maintenance', 'Surveille');
             ?>
             <label for="natureTraveau" class="form-control-label">Nature des traveax: </label>
             <select class="form-control" name="natureTraveau" id="natureTraveau">
               <?php foreach ($natureTraveau as $nature): ?>
                 <?php $selected = ""; if($nature == $projet->nature_traveaux) $selected = "selected='selected'" ?>
                 <option value="<?= $nature ?>" <?= $selected ?>><?= $nature ?></option>
               <?php endforeach; ?>
             </select>
          </div>
        </div>
        <div class="row">
          <input type="hidden" name="projetID" value="<?= $projet->id_projet ?>">
          <?= $boot->wrap($boot->button('updateProject', "btn btn-primary btn-block", "Valider les modifications"), "form-group col-sm-12") ?>
        </div>
      </form>
      <?php
    }
    elseif (!empty($_GET['site'])){
      $site = $user->getSite($_GET['site']);
      if(!$site) App::redirect('?p=home');
      ?>
      <form action="#" method="post" enctype="application/x-www-form-urlencoded">
        <div class="row">
          <?= $boot->wrap($boot->input('region', "Region de site:", "Azzaba", "text", $site->region), "col-sm-6") ?>
          <?= $boot->wrap($boot->input('nature', "Natude de site:", "install..", "text", $site->nature), "col-sm-6") ?>
        </div>
        <div class="row">
          <?php
            $clients = $user->getAllClient();
            $persons = $user->getAllUsers();
           ?>
           <div class="form-group col-sm-6">
             <label for="client" class="form-control-label">Client(owner):</label>
             <select class="form-control" name="client" id="client">
               <?php foreach ($clients as $client): ?>
                 <?php $selected = ""; if($site->id_client == $client->id_client) $selected = "selected='selected'" ?>
                 <option value="<?= $client->id_client ?>" <?= $selected ?>><?= $client->rai ?></option>
               <?php endforeach; ?>
             </select>
           </div>
           <div class="form-group col-sm-6">
             <label for="employe" class="form-control-label">Responsable de site:</label>
             <select class="form-control" name="employe" id="employe">
               <?php foreach ($persons as $person): ?>
                 <?php $selected = ""; if($site->id_persone == $person->matricule) $selected = "selected='selected'" ?>
                 <option value="<?= $person->matricule ?>" <?= $selected ?>><?= $person->nom . " " .$person->prenom ?></option>
               <?php endforeach; ?>
             </select>
           </div>
        </div>
        <div class="row">
          <?php
            $projets = $user->getAllProjects();
            $wilayas = $user->getAllWilaya();
           ?>
           <div class="form-group col-sm-6">
             <label for="projet" class="form-control-label">Projet:</label>
             <select class="form-control" name="projet" id="projet">
               <?php foreach ($projets as $projet): ?>
                 <?php $selected = ""; if($site->id_projet == $projet->id_projet) $selected = "selected='selected'" ?>
                 <option value="<?= $projet->id_projet ?>" <?= $selected ?>><?= $projet->titre_projet ?></option>
               <?php endforeach; ?>
             </select>
           </div>
           <div class="form-group col-sm-6">
             <label for="wilaya" class="form-control-label">Wilaya:</label>
             <select class="form-control" name="wilaya" id="wilaya">
               <?php foreach ($wilayas as $wilaya): ?>
                 <?php $selected = ""; if($site->id_wilaya == $wilaya->id_wilaya) $selected = "selected='selected'" ?>
                 <option value="<?= $wilaya->id_wilaya ?>" <?= $selected ?>><?= $wilaya->nom_wilaya ?></option>
               <?php endforeach; ?>
             </select>
           </div>
        </div>
        <div class="row">
          <?= $boot->wrap($boot->input('longitude', "Longitude:", "15'45895", "text", $site->longitude), "col-sm-4") ?>
          <?= $boot->wrap($boot->input('latitude', "Laltitude:", "15'45895", "text", $site->latitude), "col-sm-4") ?>
          <?= $boot->wrap($boot->input('altitude', "Altitude:", "15'45895", "text", $site->altitude), "col-sm-4") ?>
        </div>
        <div class="row">
          <input type="hidden" name="siteID" value="<?= $site->id_site ?>">
          <?= $boot->wrap($boot->button('updateSite', "btn btn-info btn-block active", "Valider les modifications"), "form-group col-sm-12") ?>
        </div>
      </form>
      <?php
    }
      ?>


<?php elseif ($privileges === "d"): ?>
  <?php

    if (isset($_POST['updateEmploye'])) {
      array_pop($_POST);
      $outils = array();
      if(!empty($_POST['outils'])) $outils = array_pop($_POST);
      if($currentUser->updateEmploye($dbLink, App::escapeValues($_POST), $outils)) App::redirect('?p=home');
    }

   ?>

  <?php $employe = $user->getEmploye($_GET['employe']);
        #if(!$employe) App::redirect('?p=home');?>

  <form class="" action="#" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
      <legend class="text-muted text-center" style="font-size:22px;font-weight:500">Modifiez l'employe:</legend>
      <div class="row" >
        <div class="col-sm-3">
          <img class="rounded img-fluid" style='min-height: 100%;' src="http://127.0.0.1/app/images/employePhotos<?= $employe->photo ?>" alt="photo de <?= $employe->nom ?>">
        </div>
        <div class="col-sm-9">
            <div class="col row">
              <?= $boot->wrap($boot->input('nom', 'nom de l\'employe:', 'Winathan', "text",$employe->nom), 'col') ?>
              <?= $boot->wrap($boot->input('prenom', 'prenom de l\'employe:', 'Tezehk', "text", $employe->prenom), 'col') ?>
            </div>
            <div class="row col">
              <?= $boot->wrap($boot->input('mobile', 'Num Tel (mobile personnel):', '0122334455', "text", $employe->mobile), 'col') ?>
              <?= $boot->wrap($boot->input('mobilePro', 'Num Tel (mobile professionnel):', '0122334455', "text", $employe->mobilePro), 'col') ?>
            </div>
            <div class="col row">
              <?= $boot->wrap($boot->input('dateNaissance', 'Datede naissance:', '12/01/2000', "text", $employe->date_de_naissance), 'col') ?>
              <?= $boot->wrap($boot->input('lieuNaissance', 'Lieu de naissance:', 'Aghalad Imedjat', "text", $employe->lieu_de_naissance), 'col') ?>
            </div>
        </div>
      </div>
      <div class="row">
              <?= $boot->wrap($boot->input('adresse', 'Adresse:', 'thala u legradj', "text", $employe->adresse), 'col-sm-6') ?>
              <?= $boot->wrap($boot->input('email', 'Email:', 'khezet@dayen.com', "mail", $employe->email), 'col-sm-6') ?>
            </div>
      <div class="row">
          <?= $boot->wrap($boot->select('sexe', 'Sexe:', array('Male', "Female"), NULL, 'form-control', $employe->sexe), 'form-group col-sm-6') ?>
          <?= $boot->wrap($boot->input('titrePoste', 'Titre de poste:', 'manager', 'text', $employe->titre_de_poste), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->select('deparetement', 'Deparetement:', array('Engennring', 'Finance', 'DRH', 'Informatique'), NULL, 'form-control', $employe->deparetement), 'col-sm-6') ?>
        <?= $boot->wrap($boot->input('dureeContrat', 'Duree de contrat:', '6 mois', 'text', $employe->duree_de_contrat), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('dateDebutContrat', 'Date debut de contrat:', '15/07/2017', 'text', $employe->date_debut_contrat), 'col-sm-6') ?>
        <?= $boot->wrap($boot->select('natureContrat', 'Nature de contart:', array('CDD', 'CDI'), NULL, "form-control", $employe->nature_de_contrat), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->select('vehiculeService', 'Vehicule service:', array(1, 0), array('Oui', "Non"), "form-control", $employe->vehicule_service), 'col-sm-6') ?>
        <?= $boot->wrap($boot->input('diplome', 'Diplome:', 'ingenieur', 'text', $employe->diplome), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('experince', 'Experience(/ mois):', '2 annees', "text", $employe->experience), 'col-sm-3') ?>
        <?= $boot->wrap($boot->select('groupSanguin', 'Group sanguin:', array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', "O+", 'O-'), NULL, "form-control", $employe->group_sanguin), 'col-sm-3') ?>
        <?= $boot->wrap($boot->input('nss', 'Numero de securite social (chiffres):', '15072017', "text", $employe->numero_securite_social), 'col-sm-6') ?>
      </div>
      <div class="row">
        <?= $boot->wrap($boot->input('dateFinContrat', 'Date Fin de coontrat:', '12/05/2019', "text", $employe->date_fin_contrat), 'col-sm-3') ?>
        <?= $boot->wrap($boot->input('dateDepart', 'Date de depart:', '12/05/2019', "text", $employe->date_depart), 'col-sm-3') ?>
        <?= $boot->wrap($boot->input('motifDepart', 'Motif de depart:', 'Ur zerigh ara ...', "text", $employe->motif_depart), 'col-sm-6') ?>
      </div>
      <div class="row">
        <input type="hidden" name="matricule" value="<?= $employe->matricule ?>">
        <label class="form-control-label col-12">Rajouter des outils(ancienes: <?= $employe->outils ?>):</label>
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
      <figure>
        <div class="row">
          <img src="http://127.0.0.1/app/images/employeRips/<?= $employe->rip ?>" alt="image de rip" class="" style="border-radius:0.25em;min-width:100%" height="200px">
        </div>
        <figcaption class="text-center text-muted"><strong class="badge badge-danger">Rip de l'employe</strong></figcaption>
       </figure>
      <div class="row">
        <?= $boot->wrap($boot->button('updateEmploye', "btn btn-outline-primary btn-block", "Mettre à jour l'employe"), 'col') ?>
      </div>
    </fieldset>
  </form>

<?php elseif ($privileges === "e"): ?>
  <h2>employe de terrain</h2>
<?php endif; ?>
