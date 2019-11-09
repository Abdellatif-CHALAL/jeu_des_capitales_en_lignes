<?php require("header.php"); ?>
<?php require("menu.php"); ?>


<div class="text-center">
  <h1 id ="t1"> LE JEU DES CAPITALES DU MONDE</h1>
</div>
<!--<h1 class="text-center"style="background-color:DodgerBlue;"> Jeu Des Capitales Du Monde</h1>-->
<br>


 <?php require("caroussel.php"); ?>

<br>
<br>
<div id ="p2" class="text-center">
  <p>Si tu es un expert en drapeau, cela ne veut pas dire que tu connais parfaitement tous les pays ! <br>
  Connaître un drapeau, c'est bien. Mais connaître sa capitale demande encore plus de mémoire !</p>
</div>
<div class="text-center">
  <a href="StamenTileLayer.php" class="btn btn-primary btn btn-primary btn-lg" ><h5>Commencer le Jeu</h5></a>
</div>


<div class="container">
  <h4><div>
  <p id="p3"><strong>LES RÈGLES DU JEU DES CAPITALES DU MONDE</strong></p>
</div>
</h4>
  <button type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo">Règle de Jeu</button>
  <div id="demo" class="collapse">
  <br>
      <div id="regle">
    <div id="p4">
      <p>T'as deux types de questionnaires : </p>
      <p>Le premier type est le suivant :</p>
    </div>
    <span id="p4">
    <p>Tu peux jouer d'une façon anonyme, pas besoin de t'inscrire.</p>
      <ol>
        <li>Tu dois répondre à 7 questions.</li>
        <li>On te donne un nom de pays et son drapeau : tu dois trouver le nom de sa capitale.</li>
        <li>Pour chaque bonne réponse ton score augmente d'un certain nombre de points, plus t'es plus proche de la capitale du pays, plus t'as un nombre de points importants.</li>
        <li>Les questions sont de plus en plus difficiles.</li>
      </ol>
    </span>
    <p id="p4">Le deuxième type est le suivant :</p>
    <span id="p4">
    <p>Pour jouer tu dois t'inscrire.</p>
      <ol>
        <li>Tu dois répondre à 7 questions.</li>
        <li>On te donne une capitale et à toi de trouver sur la carte le pays qui l'a comme capitale.</li>
        <li>Pour chaque bonne réponse ton score augmente d'un certain nombre de points, la surface du pays est petite, plus t'as un nombre de points importants.</li>
        <li>Les questions sont de plus en plus difficiles.</li>
      </ol>
    </span>
    </div>
  </div>
</div>

<br>
<br>
<br><br><br><br><br>
 <?php require("footer.php"); ?>
