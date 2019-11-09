<?php 
session_start();
?>

<?php require("header.php"); ?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a id ="active" class="navbar-brand" href="mainDec.php">
    <span class="glyphicon glyphicon-home"></span>
    Accueil
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul id="nav" class="nav navbar-nav navbar-right">
      <li class="nav-item">
        <a class="nav-link" href="../controller/deconnexion.php">
          <span class="glyphicon glyphicon-log-out"></span>
          Déconnexion
        </a>
      </li>
    </ul>
  </div>
</nav>
<div class="text-center">
  <h1 id ="t1"> CONFIGURATION DES DONNÉES</h1>
</div>
<br>
<p style="margin-left:20px;">
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample1" aria-expanded="false" aria-controls="multiCollapseExample1">Liste Questionnaires</button>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample2" aria-expanded="false" aria-controls="multiCollapseExample2">Ajouter Questionnaire</button>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample3" aria-expanded="false" aria-controls="multiCollapseExample3">Supprimer Questionnaire</button>
</p>
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample1">
      <div class="card card-body">
          <div class="alert alert-info">
              <ul id="listQ">  
              </ul>
          </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample2">
      <div class="card card-body">
          <form action="../controller/AjouterQuestionnaire.php" method="post">
              <div class="form-group">
                <label for="description"></label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Entrer Discription de questionnaire">
              </div>
              <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample3">
      <div class="card card-body">
          <form action="../controller/SupprimerQuestionnaire.php" method="post">
              <div class="form-group">
                <label for="description"></label>
                <input type="text" class="form-control" id="description" name="description" placeholder="Entrer Discription de questionnaire"   >
              </div>
              <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
      </div>
    </div>
  </div>
</div>

<br>
<p style="margin-left:20px;">
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample11" aria-expanded="false" aria-controls="multiCollapseExample11">Liste Joueurs</button>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample22" aria-expanded="false" aria-controls="multiCollapseExample22">Supprimer Joueurs</button>
</p>
<div class="row">
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample11">
      <div class="card card-body">
          <div class="alert alert-info">
              <ul id="listJ">
              </ul>
          </div>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="collapse multi-collapse" id="multiCollapseExample22">
      <div class="card card-body">
          <form action="../controller/SupprimerJoueur.php" method="post">
              <div class="form-group">
                <label for="email"></label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Entrer Mail">
              </div>
              <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
      </div>
    </div>
  </div>
</div>

<?php if(!empty($_SESSION['erreurs'])){ ?>
              <div class="alert alert-danger">
                <p>Vous n'avez pas rempli le formulaire correctement </p>
                <ul>  
                    <?php foreach($_SESSION['erreurs'] as $error){
                        ?>
                        <li><?= $error; ?></li>
                    <?php
                    } ?>
                </ul>
            </div>
  <?php } ?>
  <?php session_destroy(); ?>
<script>
	$.ajax({
        url: "../controller/ListeQuestionnaire.php",
	    	method: "POST",
        success: function (data) {
            var v = JSON.parse(data);
            var i = 0;
            while (i < v.length) {
              $("#listQ").append("<li>"+v[i].description+"</li>");
	                i++;
              }
				    console.log(v);

        },
        error: function (err) {
            alert("j'ai echoué ");
        },
    });

    $.ajax({
        url: "../controller/ListeJoueur.php",
	    	method: "POST",
        success: function (data) {
            var v = JSON.parse(data);
            var i = 0;
            while (i < v.length) {
              $("#listJ").append("<li>Nom: "+v[i].nom+" Prenom: "+v[i].prenom+" Email: "+v[i].email+"</li>");
	                i++;
              }
				    console.log(v);
        },
        error: function (err) {
            alert("j'ai echoué ");
        },
    });

</script>

 <?php require("footer.php"); ?>
