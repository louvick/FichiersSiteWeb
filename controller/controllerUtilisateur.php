<?php

require('model/UtilisateurManager.php');

function getFormConnexion()
{
    require('view/loginView.php');
}

function authentifier($courriel, $motPasse)
{
    require('controller/controllerAccueil.php');
    $um = new UtilisateurManager();
    $utilisateur = $um->verifAuthentification($courriel, $motPasse);
    if($utilisateur!=null) {
        $_SESSION['courriel'] = $courriel;
        $_SESSION['role'] = $utilisateur->get_role_utilisateur();
        listProduits(); 
    }
    else {
        echo 'Echec de l\'authentification';
    }
    
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
        $um->addUtilisateur($payload);        
    //$domain = $payload['hd'];
    } else {
    // Invalid ID token
    }

    require('controller/controllerAccueil.php');
    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}
