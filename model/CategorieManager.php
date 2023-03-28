<?php



require_once("model/Manager.php");
require_once("model/Categorie.php");

class CategorieManager extends Manager
{
    public function getCategories($langue)
    {
        $db = $this->dbConnect();
        $req = $db->query(str_replace(':lang', $langue, 'SELECT id_categorie,categorie_:lang AS categorie, description_:lang AS description FROM tbl_categorie'));

        $categories = array();

        while($data = $req->fetch()){
            array_push($categories, new Categorie($data));
        }

        $req->closeCursor();
        return $categories;
    }

    public function getCategorieId($langue,$id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare(str_replace(':lang', $langue,'SELECT id_categorie,categorie_:lang AS categorie, description_:lang AS description FROM tbl_categorie WHERE id_categorie=?'));

        $req->execute(array($id));
        
        
        $cat = $req->fetch();
        $req->closeCursor();

        if($cat) {
            $asd = new Categorie($cat);
            return $asd;
        }

        return null;
    }
}