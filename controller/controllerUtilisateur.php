<?php

require('model/UtilisateurManager.php');

function getFormConnexion()
{
    require('view/loginView.php');
}

function authentifier($courriel, $motPasse)
{
    
    require('controller/controllerAccueil.php');
    $utilisateur = verifAuthentification($courriel, $motPasse);
    if($utilisateur!=null) {
        listProduits();
        $_SESSION['courriel'] = $courriel;
        $_SESSION['role'] = $utilisateur->get_role();

    }
    else {
        echo 'Echec de l\'authentification';
    }
    
}
