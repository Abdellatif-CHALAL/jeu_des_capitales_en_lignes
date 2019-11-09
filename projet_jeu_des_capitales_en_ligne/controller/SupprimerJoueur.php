<?php
   session_start();
   $errors = array();   
   if (empty($_POST['email'])){
        $errors['questionnaire'] = "Veuillez entrer l'email de joueur";
   }
   if(verif_email($_POST['email'])){
    $errors['questionnaireExiste'] = "Cet email n'existe pas";
}
   if(!empty($errors)){    
        $_SESSION['erreurs'] = $errors;
        header("Location: ../views/mainDec.php");
   }else{
            require('connectSQL.php'); //$connexion est défini dans ce fichier
            $sql="DELETE FROM utilisateur WHERE email=:email";
            try {
                $commande = $connexion->prepare($sql);
                $commande->bindParam(':email',$_POST['email']);
                $bool = $commande->execute();
                header("Location: ../views/mainDec.php");
            }
            catch (PDOException $e) {
                echo utf8_encode("Echec de Insertion : " . $e->getMessage() . "\n");
                die(); // On arrête tout.
            }
    }

   function verif_email($email) {
        require('connectSQL.php'); //$connexion est défini dans ce fichier

        $sql="SELECT * FROM utilisateur WHERE email=:email";
        try {
            $commande = $connexion->prepare($sql);
            $commande->bindParam(':email',$email);
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