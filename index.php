<?php
//Débogage afficher ce qui est reçu en paramètres
echo "----------------------------<br/>";
echo "Paramètres reçus:<br/><pre>";
echo "</pre>----------------------------<br/>";

//Est-ce qu'un paramètre action est présent
if (isset($_GET['action'])) {

    //Est-ce que l'action demandée est la liste des produits
    if ($_GET['action'] == 'produits') {
        //Ajoute le controleur de Produit
        require('controller/controllerProduit.php');
        //Appel la fonction listProduits contenu dans le controleur de Produit
        listProduits();
    }
    // Sinon est-ce que l'action demandée est la description d'un produit
    elseif ($_GET['action'] == 'produit') {
        
        // Est-ce qu'il y a un id en paramètre
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            //Ajoute le controleur de Produit
            require('controller/controllerProduit.php');
            //Appel la fonction produit contenu dans le controleur de Produit
            produit($_GET['id']);
        }
        else {
            //Si on n'a pas reçu de paramètre id, mais que la page produit a été appelé
            echo 'Erreur : aucun identifiant de produit envoyé';
        }
    } 
    elseif ($_GET['action'] == 'categories') {
        require('controller/controllerCategorie.php');
        listCategories();
    }
    elseif ($_GET['action'] == 'produitscategorie') {
        if (isset($_GET['id']) && $_GET['id'] > 0) {
            require('controller/controllerProduit.php');

            listProduitsCategorie($_GET['id']);
        }
    }
}
// Si pas de paramètre charge l'accueil
else {
    //Ajoute le controleur de Produit
    require('controller/controllerAccueil.php');
    //Appel la fonction listProduits contenu dans le controleur de Produit
    listProduits();
}