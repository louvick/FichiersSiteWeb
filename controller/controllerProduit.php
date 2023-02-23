<?php

require('model/ProduitManager.php');

function listProduits()
{
    $produitManager = new ProduitManager();
    $produits = $produitManager->getProduits();

    require('view/produitsView.php');
}

function listProduitsCategorie($idCategorie)
{
    $produitManager = new ProduitManager();
    $categorie = $produitManager->getProduitsCategorie($idCategorie)[0]->get_categorie();
    
    $produits = $produitManager->getProduitsCategorie($idCategorie);

    require('view/produitsView.php');
}

function produit($idProduit)
{
    $produitManager = new ProduitManager();
    $produit = $produitManager->getProduit($idProduit);    

    require('view/produitView.php');
}

function insertProduit($produit,$categorie,$description)
{
    $produitManager = new ProduitManager();
    return $produitManager->addProduit($produit,$categorie,$description);
}

function removeProduit($idProduit)
{
    $produitManager = new ProduitManager();
    $produitManager->removeProduit($idProduit);    

    require('view/produitView.php');
}