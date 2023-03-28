<?php
if(!isset($_SESSION)) {
    session_start();
}

/* Importation de la librairie "gettext" (en supposant que
   les fichiers de la librairie ont été placés dans un dossier
   "gettext" lui-même situé à la racine du site Web). */
require_once './inc/LibrairieGettext/gettext.inc';

// Le nom des fichiers de traduction ".mo" (sans l'extension)
define('TRANSLATE_FILENAME', 'traduction');

/* La variable $langue pourra toujours être modifiée en fonction
   du choix qu'aura fait l'utilisateur (par exemple, par le biais
   d'une valeur enregistrée dans la session PHP). Pour le moment,
   cette variable est simplement forcée à 'fr_ca'. */

if(!isset($_SESSION['langue'])) {
    $langue = 'fr_ca';
    $_SESSION['langue'] = $langue;
}
else {
    $langue = $_SESSION['langue'];
}

T_setlocale(LC_MESSAGES, $langue);
echo ($langue);

/* On associe le nom des fichiers de traduction ".mo" au chemin
   complet permettant d'y accéder (ici, il s'agit de la racine
   de notre site Web concaténée au dossier 'locale'). */
bindtextdomain(TRANSLATE_FILENAME, (realpath('./') . '\\locale\\'));

// L'encodage des fichiers de traduction ".mo" est établi ici.
if (function_exists('bind_textdomain_codeset'))
    bind_textdomain_codeset(TRANSLATE_FILENAME, 'UTF-8');

/* Le bon fichier de traduction ".mo" tout dépendant de la
   langue choisie par l'utilisateur est automatiquement
   appliqué ici. */
textdomain(TRANSLATE_FILENAME);

$langueBd = substr($_SESSION['langue'], 0, 2);

//Est-ce qu'un paramètre action est présent
if (isset($_REQUEST['action'])) {
    
    //Est-ce que l'action demandée est la liste des produits
    if ($_REQUEST['action'] == 'produits') {
        //Ajoute le controleur de Produit
        require('controller/controllerProduit.php');
        //Appel la fonction listProduits contenu dans le controleur de Produit
        listProduits($langueBd);
    }
    // Sinon est-ce que l'action demandée est la description d'un produit
    else if ($_REQUEST['action'] == 'produit') {
        
        // Est-ce qu'il y a un id en paramètre
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            produit($langueBd,$_REQUEST['id']);
        }
        else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    } 
    else if ($_REQUEST['action'] == 'categories') {
        require('controller/controllerCategorie.php');
        listCategories($langueBd);
    }
    else if ($_REQUEST['action'] == 'produitscategorie') {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] > 0) {
            require('controller/controllerProduit.php');

            listProduitsCategorie($langueBd,$_REQUEST['id']);
        }
    }
    else if ($_REQUEST['action'] == 'connexion') {
        require('controller/controllerUtilisateur.php');
        getFormConnexion();
    }
    else if ($_REQUEST['action'] == 'authentifier') {
        
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
    else if($_REQUEST['action']=='createProduit') {
        require('controller/controllerProduit.php');
        print_r(insertProduit($_REQUEST['produit'],$_REQUEST['categorie'],$_REQUEST['description']));
    }
    else if($_REQUEST['action']=='supression') {
        require('controller/controllerProduit.php');
        removeProduit($_REQUEST['id_produit']);
    }
    else if($_REQUEST['action']=='testajax') {
        require('controller/controllerProduit.php');
        //insertProduit($_REQUEST['produit'],$_REQUEST['categorie'],$_REQUEST['description']);
    }
    else if($_REQUEST['action']=='changerLangue') {
        if(isset($_REQUEST['langue'])) {
            $_SESSION['langue']=$_REQUEST['langue'];
        }
        header("Location: ".$_SERVER['HTTP_REFERER']);
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
    listProduits($langueBd);
}