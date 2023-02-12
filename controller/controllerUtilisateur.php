<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require('model/UtilisateurManager.php');

function getFormConnexion()
{
    require('view/loginView.php');
}

function authentifier($request)
{
    require('controller/controllerAccueil.php');
    require('model/Util.php');
    require('model/AutologManager.php');

    $um = new UtilisateurManager();
    $am = new AutologManager();

    $utilisateur = $um->verifAuthentification($request['courriel'], $request['mdp']);
    if($utilisateur!=null) {
        $_SESSION['courriel'] = $request['courriel'];
        $_SESSION['role'] = $utilisateur->get_role_utilisateur();
        
        if(isset($request['souvenir'])&&$request['souvenir']=='on') {
            $randomToken = $am->addAutolog($utilisateur);
            $cookieValues = array('user_id' => $utilisateur->get_id_utilisateur(), 'token' => $randomToken);
            setcookie('session', json_encode($cookieValues), time()+60);
        }
        header("Refresh:0");
        listProduits(); 
    }
    else {
        echo 'Echec de l\'authentification';
    }
    
}

function deconnexion() {
    $_SESSION= array();
    session_destroy();
    header("Refresh:0; url=index.php"); 
}

function deleteAutoLogin() {
    require('model/AutologManager.php');
    $am = new AutologManager();
    if(isset($_COOKIE['session'])) {
        $am->removeValide($am->verifyToken(json_decode($_COOKIE['session'])->user_id,json_decode($_COOKIE['session'])->token));
        setcookie('session', "", time()+1);
    }
    
    header("Refresh:0; url=index.php");
}

function inscription($result) {
    $um = new UtilisateurManager();
    if(isset($result)) {
        $resultat = $um->inscription($result);
        
        if($resultat!=null) {
            require('controller/controllerAccueil.php');
            
            require 'vendor/autoload.php';
            
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->Host = 'localhost';
            $mail->Port = 1025;
            $mail->SMTPAuth = true;
            $mail->setFrom("test@gmail.com", "lou");
            $mail->addReplyTo('moi@monCourriel.com', 'Votre nom');
            $mail->addAddress($result['courriel'], $result['prenom']);
            $mail->Subject = "Validation compte";
            $id = $resultat[1]->get_id_utilisateur();
            $token = $resultat[0];
            $mail->msgHTML('<a href="http://localhost/FichiersSiteWeb/index.php?action=validation&id=' . $id . '&token=' . $token . '">Cliquer ici pour activer votre compte</a>');
            echo '<a href="http://localhost/FichiersSiteWeb/index.php?action=validation&id=' . $id . '&token=' . $token . '">Cliquer ici pour activer votre compte</a>';


            if (!$mail->send())
                echo 'Erreur de Mailer : ' . $mail->ErrorInfo;
            else
                echo 'Le message a été envoyé.';
            listProduits();
        }
        else {
            echo 'L\'utilisateur existe déjà';
            require('view/inscriptionView.php');
        }
    }
    else {
        echo 'L\'utilisateur existe déjà';
        require('view/inscriptionView.php');
    }
}

function authentificationGoogle($credential) {
    require_once 'vendor/autoload.php';

    // Get $id_token via HTTPS POST.
    $CLIENT_ID = "728131155971-vmpvhnla4j66f5019ohdiam9gtbhhmp9.apps.googleusercontent.com";
    $client = new Google_Client(['client_id' => $CLIENT_ID]);  // Specify the CLIENT_ID of the app that accesses the backend
    $payload = $client->verifyIdToken($credential);
    if ($payload) {
        $um = new UtilisateurManager();
        if(!$um->getUtilisateurParCourriel($payload['email'])) {
            $um->addUtilisateur($payload);
        }
        else {
            $_SESSION['courriel']=$payload['email'];
        }
    //$domain = $payload['hd'];
    } else {
    // Invalid ID token
    }

    require('controller/controllerAccueil.php');
    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}

function checkTokenInscription($request) {
    $um = new UtilisateurManager();
    $utilisateur = $um->verifyToken($request['id'],$request['token']);
    
    if(isset($utilisateur)) {
        $um->actif($utilisateur);
        require('controller/controllerAccueil.php');
    
        listProduits();
    }
    else {
        echo 'Le token est invalide';
    }
}
