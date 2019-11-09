<?php 
session_start();
require("header.php");
require("menu.php"); 
?>


<h1 class="text-center">Connection</h1>
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


<form action="../controller/manageConnection.php" method="post" class="w-50 mx-auto">
  <div class="form-group">
    <label for="email">Mail</label>
    <input type="email" class="form-control" name="email" id="email" placeholder="Entrer Mail">
  </div>
  <div class="form-group">
    <label for="password">Mot de Passe</label>
    <input type="password" class="form-control" name="password" id="password" placeholder="Entrer Password">
  </div>
  
  <button type="submit" class="btn btn-primary ">Submit</button>
</form>

<?php require("footer.php"); ?>