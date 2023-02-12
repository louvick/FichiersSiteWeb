<?php require_once("model/Manager.php");
require_once("model/Util.php");

$util = new Util();

class AutologManager extends Manager
{
    public function addAutolog($util) {
        $token = $util->get_token(16);
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO `tbl_autologin` (`id_utilisateur,`token_hash`,`est_valide`,`date_expiration`) VALUES (:id_utilisateur, :token_hash, :est_valide, :date_expiration)');
        $req->execute(array(':id_utilisateur'=>$util->get_id_utilisateur(), ':token_hash'=>password_hash($token, PASSWORD_DEFAULT), ':est_valide'=>1, ':date_expiration'=>86400));
        return $token;
    }
}

?>