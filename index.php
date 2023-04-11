<?php
if(!isset($_SESSION)){
    session_start();
}

//header("Content-Type: application/json");
$paypalInfos = json_decode(file_get_contents('php://input'), true);

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
    else if($_REQUEST['action']=='achatProduit'&&isset($_SESSION['courriel'])){
        require('controller/controllerProduit.php');
        listProduitsPaypal();
    }
    else if($_REQUEST['action'] === 'paypal') {
         // Si l’utilisateur vient de cliquer sur le bouton Paypal, les informations de la requête AJAX seront traitées dans ce « else if ».
        require('./controller/controllerPaypal.php');

        // Générez une transaction Paypal à l’aide des informations reçues dans la variable $paypalINfos, de l’utilisateur connecté et
        // de la fonction « registerOrder() » du contrôleur controllerPaypal.php, puis remplissez les champs pertinents des tables
        // tbl_commande et tbl_commande_produit de la BD en passant, ici encore, par le contrôleur controllerPaypal.php. N’oubliez
        // pas de retourner la transaction PayPal générée en réponse à la requête AJAX (code de succès 200) ou de retourner une erreur
         // (code d’échec 400) si le processus connaît un raté.  
    }
    else if(isset($paypalInfos['event_type'])) {
        require('./controller/controllerPaypal.php');
    
        if($paypalInfos['event_type'] === 'CHECKOUT.ORDER.APPROVED') {
            // Enregistrez dans la BD les informations « id », « payer_id » et « email_address » de l’événement « checkout order approved »
            // et ce, en passant par une fonction du contrôleur controllerPaypal.php. N’oubliez pas de retourner un code de succès (200) ou
            // un code d’échec (400) aux serveurs PayPal si l’insertion réussit ou non en BD.
        }     
        else if($paypalInfos['event_type'] === 'PAYMENT.CAPTURE.COMPLETED') {
            // Faites passer à 1 le statut de la commande dans la BD dont l’identifiant correspond au champ
            // « order_id » de l’événement « payment capture completed » et ce, en passant par une fonction
            // du contrôleur controllerPaypal.php. N’oubliez pas d’envoyer un code de succès (200) ou un code
            // d’échec (400) aux serveurs PayPal si la modification réussit ou non en BD.
        }
    }            
    else {
        require('controller/controllerAccueil.php');
        listProduits();
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