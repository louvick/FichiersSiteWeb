<?php
if(!isset($_SESSION)){
    session_start();
}
/*if(!isset($_SESSION['courriel'])) {
    require('controller/controllerUtilisateur.php');
    print_r("asdadsa");
    getFormConnexion();
}*/
//Est-ce qu'un paramètre action est présent
if (isset($_REQUEST['action'])) {
    
    //Est-ce que l'action demandée est la liste des produits
    if ($_REQUEST['action'] == 'produits') {
        //Ajoute le controleur de Produit
        require('controller/controllerProduit.php');
        //Appel la fonction listProduits contenu dans le controleur de Produit
        listProduits();
    }
    // Sinon est-ce que l'action demandée est la description d'un produit
    elseif ($_REQUEST['action'] == 'produit') {
        
        // Est-ce qu'il y a un id en paramètre
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            produit($_REQUEST['id']);
        }
        else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    } 
    elseif ($_REQUEST['action'] == 'categories') {
        require('controller/controllerCategorie.php');
        listCategories();
    }
    elseif ($_REQUEST['action'] == 'produitscategorie') {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            require('controller/controllerProduit.php');

            listProduitsCategorie($_REQUEST['id']);
        }
    }
    elseif ($_REQUEST['action'] == 'connexion') {
        require('controller/controllerUtilisateur.php');
        getFormConnexion();
    }
    elseif ($_REQUEST['action'] == 'authentifier') {
        
        if(isset($_REQUEST['courriel']) && isset($_REQUEST['mdp'])) {
            require('controller/controllerUtilisateur.php');
            authentifier($_REQUEST);
        }
    }
    else if($_REQUEST['action'] == 'deconnexion') {
        require('controller/controllerUtilisateur.php');
        deconnexion();
    }
    else if($_REQUEST['action']== 'delete') {
        require('controller/controllerUtilisateur.php');
        deleteAutoLogin();
        
    }
    else if($_REQUEST['action']=='inscrire') {
        require('view/inscriptionView.php');
    }
    else if($_REQUEST['action']== 'inscription') {
        require('controller/controllerUtilisateur.php');
        inscription($_REQUEST);
    }
    else if($_REQUEST['action']=='validation') {
        require('controller/controllerUtilisateur.php');
        checkTokenInscription($_REQUEST);
    }
}
elseif (isset($_REQUEST['credential'])) {
    require('controller/controllerUtilisateur.php');
    authentificationGoogle($_REQUEST['credential']);
}
// Si pas de paramètre charge l'accueil
else {
    //Ajoute le controleur de Produit
    require('controller/controllerAccueil.php');
    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}