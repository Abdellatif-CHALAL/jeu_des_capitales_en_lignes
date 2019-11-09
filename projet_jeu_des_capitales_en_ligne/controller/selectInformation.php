<?php 
require('connectSQL.php'); //$connexion est défini dans ce fichier

$id_quest = 1;
$id_question = $_POST["num_quest"];

$sql="SELECT * FROM question WHERE id_quest=:id_quest AND id_question=:id_question";
try {
    $commande = $connexion->prepare($sql);
    $commande->bindParam(':id_quest', $id_quest);
    $commande->bindParam(':id_question', $id_question);
    $commande->execute();
    $resultat = $commande->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultat);   
}
catch (PDOException $e) {
    echo utf8_encode("Echec de Insertion : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
}

?>