<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Produit.php");

class ProduitManager extends Manager
{
    public function getProduits()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM tbl_produit ORDER BY id_produit');

        $produits = array();

        while($data = $req->fetch()){
            array_push($produits, new Produit($data));
        }

        $req->closeCursor();
        return $produits;
    }

    public function getProduit($produitId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT p.*, categorie FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE id_produit = ?');
        $req->execute(array($produitId));
        $produit = new Produit($req->fetch());

        return $produit;
    }

    public function getProduitsCategorie($categorieId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT p.*, categorie FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE p.id_categorie = ?');
        $req->execute(array($categorieId));
        $produits = array();

        foreach($req->fetchAll() as $value) {
            array_push($produits, new Produit($value));
        };
        return $produits;
    }

}

