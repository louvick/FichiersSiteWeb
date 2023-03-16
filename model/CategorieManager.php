<?php



require_once("model/Manager.php");
require_once("model/Categorie.php");

class CategorieManager extends Manager
{
    public function getCategories()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM tbl_categorie ORDER BY id_categorie');

        $categories = array();

        while($data = $req->fetch()){
            array_push($categories, new Categorie($data));
        }

        $req->closeCursor();
        return $categories;
    }

    public function getCategorieId($id)
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM tbl_categorie WHERE id_categorie = ?');

        $req->execute(array($id));
        $cat= new Categorie($req->fetch());

        return $cat;
    }
}