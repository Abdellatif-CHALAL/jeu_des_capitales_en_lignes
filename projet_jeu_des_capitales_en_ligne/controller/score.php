<?php 
require('connectSQL.php'); //$connexion est défini dans ce fichier
$sql="INSERT INTO partie(id_ut,id_quest,score,num_quest) 
                              VALUES (:id_ut,:id_quest,:score,:num_quest)";
try {
    $commande = $connexion->prepare($sql);
    $commande->bindParam(':id_ut',$_POST['id_ut']);
    $commande->bindParam(':id_quest',$_POST['id_quest']);
    $commande->bindParam(':score',$_POST['score']);
    $commande->bindParam(':num_quest',$_POST['num_quest']);
    $commande->execute();
    $resultat = $commande->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($resultat);   
}
catch (PDOException $e) {
    echo utf8_encode("Echec de Insertion : " . $e->getMessage() . "\n");
    die(); // On arrête tout.
}
?>