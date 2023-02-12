<?php

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

    $personne = new Utilisateur($um->verifAuthentification($request['courriel'], $request['mdp']));
    print_r($personne->get_nom());

    /*if($utilisateur!=null) {
        $_SESSION['courriel'] = $request['courriel'];
        $_SESSION['role'] = $utilisateur->get_role_utilisateur();
        
        
        
        #$randomToken = $am->addAutolog($utilisateur);
        

        #$cookieValues = array('user_id' => $utilisateur->get_id_utilisateur(), 'token' => $randomToken);

        #setcookie('session', json_encode($cookieValues), 86400);

        //listProduits(); 
    }
    else {
        echo 'Echec de l\'authentification';
    }*/
    
}

function deconnexion() {
    $_SESSION= array();
    session_destroy();
    require('controller/controllerAccueil.php');
    listProduits();
    
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
