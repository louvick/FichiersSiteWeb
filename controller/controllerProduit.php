<?php

require('model/ProduitManager.php');

function listProduits($langue,$estApi=false)
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits($langue);


    if($estApi) {
        return json_encode($produits, JSON_PRETTY_PRINT);
    }
    else{
        require('view/produitsView.php');
    }

}

function listProduitsCategorie($langue,$idCategorie)
{
    $produitManager = new ProduitManager();
    $categorie = $produitManager->getProduitsCategorie($langue,$idCategorie)[0]->get_categorie();
    
    $produits = $produitManager->getProduitsCategorie($langue,$idCategorie);

    require('view/produitsView.php');
}

function produit($langue,$idProduit, $estApi=false)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($langue,$idProduit); 
    
    if($estApi) {
        return json_encode($produit, JSON_PRETTY_PRINT);
    }
    else{
        require('view/produitView.php');
    }
}

function insertProduit($langue,$produit,$categorie,$description)
{
    $produitManager = new ProduitManager();
    return $produitManager->addProduit($langue,$produit,$categorie,$description);
}

function removeProduit($idProduit,$estApi)
{
    $produitManager = new ProduitManager();
    $asd = $produitManager->removeProduit($idProduit);

    if($estApi==false) {
        require('view/produitView.php');
    }
    else {
        return $asd;
    }
}