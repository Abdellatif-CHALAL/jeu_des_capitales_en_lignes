<?php
   session_start();
   $errors = array();   
   
   if (empty($_POST['description'])){
        $errors['questionnaire'] = "Veuillez entrer la description de questionnaire";
   }
   if(verif_questionnaire($_POST['description'])){
    $errors['questionnaireExiste'] = "Ce questionnaire n'existe pas";
}
   if(!empty($errors)){    
        $_SESSION['erreurs'] = $errors;
        header("Location: ../views/mainDec.php");
   }else{
            require('connectSQL.php'); //$connexion est défini dans ce fichier
            $sql="DELETE FROM questionnaire WHERE description=:description";
            try {
                $commande = $connexion->prepare($sql);
                $commande->bindParam(':description',$_POST['description']);
                $bool = $commande->execute();
                header("Location: ../views/mainDec.php");
            }
            catch (PDOException $e) {
                echo utf8_encode("Echec de Insertion : " . $e->getMessage() . "\n");
                die(); // On arrête tout.
            }
    }

   function verif_questionnaire($description) {
        require('connectSQL.php'); //$connexion est défini dans ce fichier

        $sql="SELECT * FROM questionnaire WHERE description=:description";
        try {
            $commande = $connexion->prepare($sql);
            $commande->bindParam(':description',$description);
            $commande->execute();
            $resultat = $commande->fetch();
        }
        catch (PDOException $e) {
            echo utf8_encode("Echec de Insertion : " . $e->getMessage() . "\n");
            die(); // On arrête tout.
        }
        return empty($resultat);
    }
?>