
<?php
   session_start();
   $errors = array();   
   if (empty($_POST['prenom'])){
        $errors['prenom'] = "Veuillez entrer votre prenom";
    }
   if (empty($_POST['nom'])){
        $errors['nom'] = "Veuillez entrer votre nom";
   }
   if (empty($_POST['email'])){
        $errors['email'] = "Veuillez entrer votre email";
    }
    else{
        if(!verif_email($_POST['email'])){
            $errors['email'] = "Cet email est déjà utilisé pour un autre compte";
        }
    }
    if (empty($_POST['password'])){
        $errors['password'] = "Veuillez entrer votre mot de passe"; 
    }

   if (empty($_POST['passwordConf'])){
        $errors['passwordConf'] = "Veuillez entrer le mot de passe de confirmation";
    }
    if ((!empty($_POST['passwordConf'])) && (!empty($_POST['password']))) {
        if ($_POST['password'] != $_POST['passwordConf']) {
            $errors['edentique'] = "Les mots de passe ne sont pas identique";
        }
    }
   if(!empty($errors)){    
        $_SESSION['erreurs'] = $errors;
        header("Location: ../views/inscription.php");
   }else{
            require('connectSQL.php'); //$connexion est défini dans ce fichier
            $passwordCrypt =  md5($_POST['password']);
            $sql="INSERT INTO utilisateur(pass,email,prenom,nom) 
                              VALUES (:pass,:email,:prenom,:nom)";
            try {
                $commande = $connexion->prepare($sql);
                $commande->bindParam(':pass',$passwordCrypt);
                $commande->bindParam(':email',$_POST['email']);
                $commande->bindParam(':prenom',$_POST['prenom']);
                $commande->bindParam(':nom',$_POST['nom']);
                $bool = $commande->execute();
                header("Location: ../views/connection.php");
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