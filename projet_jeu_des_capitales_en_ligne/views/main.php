<?php session_start();?>
<?php require("header.php"); ?>
<?php include("menu1.php"); ?>


<div class="text-center">
  <h1 id ="t1"> <?php echo "BIENVENUE ".$_SESSION['sessionInfos']['nom']." ".$_SESSION['sessionInfos']['prenom']; ?></h1>
</div>
<br>

 <?php require("caroussel.php"); ?>

<br>
<br>
<div id ="p2" class="text-center">
  <p>Si tu es un expert en drapeau, cela ne veut pas dire que tu connais parfaitement tous les pays ! <br>
  Connaître un drapeau, c'est bien. Mais connaître sa capitale demande encore plus de mémoire !</p>
</div>
<div class="text-center">
<a href="StamenTileLayerQst2.php" class="btn btn-primary btn btn-primary btn-lg" ><h5>Commencer le Jeu</h5></a>
</div>
<br>
<br>
 <?php require("footer.php"); ?>
