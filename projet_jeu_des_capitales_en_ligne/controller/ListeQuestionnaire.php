<?php 
require('connectSQL.php'); //$connexion est défini dans ce fichier

$sql="SELECT * FROM questionnaire";
try {
    $commande = $connexion->prepare($sql);
    $commande->execute();
    $resultat = $commande->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultat);
}
catch (PDOException $e) {
    echo utf8_encode("Echec de Insertion : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
}

?>