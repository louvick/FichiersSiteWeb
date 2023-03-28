<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Produit.php");

class ProduitManager extends Manager
{
    public function getProduits($langue)
    {
        $db = $this->dbConnect();
        $req = $db->query(str_replace(':lang', $langue,'SELECT id_produit, id_categorie, description_:lang AS description, produit_:lang as produit FROM tbl_produit ORDER BY id_produit'));

        $produits = array(); 

        while($data = $req->fetch()){
            array_push($produits, new Produit($data));
        }
        $req->closeCursor();
        return $produits;
    }

    public function getProduit($langue,$produitId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare(str_replace(':lang', $langue,'SELECT p.id_produit AS id_produit, p.id_categorie AS categorie_id, c.categorie_:lang AS categorie, p.produit_:lang AS produit, p.description_:lang AS description FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE id_produit = ?'));
        $req->execute(array($produitId));
        $produit = $req->fetch();
        

        if($produit) {
            return new Produit($produit);
        }
        return null;
    }

    public function getProduitsCategorie($langue,$categorieId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare(str_replace(':lang', $langue,'SELECT p.id_produit AS id_produit, p.id_categorie AS categorie_id, c.categorie_:lang AS categorie, p.produit_:lang AS produit, p.description_:lang AS description FROM tbl_produit AS p INNER JOIN tbl_categorie AS c ON p.id_categorie = c.id_categorie WHERE p.id_categorie = ?'));
        $req->execute(array($categorieId));
        $produits = array();

        foreach($req->fetchAll() as $value) {
            array_push($produits, new Produit($value));
        };
        return $produits;
    }

    public function addProduit($langue,$produit,$categorie,$description) {
        $db = $this->dbConnect();
        $req = $db->prepare(str_replace(':lang', $langue,'INSERT INTO `tbl_produit` (`id_categorie`,`produit_:lang`,`description_:lang`) VALUES (:id_categorie,:produit,:descriptio)'));
        $req->execute(array(':id_categorie'=>$categorie,':produit'=>$produit,':descriptio'=>$description));
        return $db->lastInsertId();
    }

    public function removeProduit($id){
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM tbl_produit WHERE `tbl_produit`.`id_produit` = ?');
        $req->execute(array($id));
        return $req->rowCount();
    }

}

