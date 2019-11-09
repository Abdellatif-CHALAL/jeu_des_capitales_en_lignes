<?php 
session_start(); 
require("header.php");
require("menu.php"); 

?>

<h1 class="text-center">Inscription</h1> 
  
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
<?php session_destroy();  ?>
              
<form action="../controller/manageInscription.php" method="post" class="w-75 mx-auto">
  <div class="form-group">
    <label for="nom">Nom</label>    
    <input type="text" class="form-control" name="nom" id="nom" placeholder="Entrer Nom" >
  </div>
  <div class="form-group">
    <label for="prenom">Prenom</label>
    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Entrer Prenom" >
  </div>


  <div class="form-group">
    <label for="email">Email</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="Entrer Email" >
  </div>


  <div class="form-group">
    <label for="password">Mot de Passe</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Entrer Password" >
  </div>


    <div class="form-group">
    <label for="passwordConf">Confirmation de mot de passe</label>
    <input type="password" class="form-control" name="passwordConf" id="passwordConf" placeholder="Entrer la confirmation de Mot de Passe" >
  </div>


  <button type="submit" class="btn btn-primary ">Submit</button>
</form>

<?php require("footer.php"); 
?>