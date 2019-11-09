
<?php
session_start();
   $errors = array();
   $sessionInfos = array(); 
   if (empty($_POST['email'])){
        $errors['email'] = "Veuillez entrer votre email";
    }
    if(empty($_POST['password'])){
        $errors['password'] = "Veuillez entrer votre mot de passe"; 
    }
   if(!empty($errors)){
        $_SESSION['erreurs'] = $errors;
        header("Location: ../views/connection.php");
   }else{   
            
            require('connectSQL.php'); //$connexion est défini dans ce fichier
            $sql="SELECT * FROM utilisateur WHERE email=:email";
            try {
                $commande = $connexion->prepare($sql);
                $commande->bindParam(':email',$_POST['email']);
                $commande->execute();
                $resultat = $commande->fetch();
                if (empty($resultat)){
                    $errors['emailIntrouvable']= "Email introuvable, Veuillez sisair un autre email"; 
                    header("Location: ../views/connection.php");   
                }else{
                    if($resultat['pass'] == md5($_POST['password'])){
                        $sessionInfos['nom'] = $resultat['nom'];
                        $sessionInfos['prenom'] = $resultat['prenom'];
                        $sessionInfos['email'] = $resultat['email'];
                        $sessionInfos['id_ut'] = $resultat['id_ut'];
                        $sessionInfos['pass'] = $resultat['pass'];
                        $_SESSION['sessionInfos'] = $sessionInfos;
                        if($resultat['pass'] == md5("admin"))
                            header("Location: ../views/mainDec.php");    
                        else
                            header("Location: ../views/main.php");
                    }else{
                        $errors['motDePasseIntrouvable']= "Mot de passe introuvable, Veuillez sisair un autre mot de passe";
                        $_SESSION['erreurs'] = $errors;
                        header("Location: ../views/connection.php");
                    }
                }
            }
            catch (PDOException $e) {
                echo utf8_encode("Echec de Insertion : " . $e->getMessage() . "\n");
                die(); // On arrête tout.
            }
    }
?>