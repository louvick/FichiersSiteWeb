<?php require_once("model/Manager.php");
require_once("model/Util.php");



class AutologManager extends Manager
{
    public function addAutolog($util) {
        $utila = new Util();
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO `tbl_autologin` (`id_utilisateur`,`token_hash`,`est_valide`,`date_expiration`) VALUES (:id_utilisateur, :token_hash, :est_valide, :date_expiration)');
        $token = $utila->getToken(24);
        $req->execute(array(':id_utilisateur'=>$util->get_id_utilisateur(), ':token_hash'=> password_hash($token,PASSWORD_DEFAULT), ':est_valide'=>1, ':date_expiration'=>date('Y-m-d', strtotime("+1 month", strtotime(date("Y/m/d"))))));
        return $token;
    }

    public function verifyToken($id,$token) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM tbl_autologin WHERE id_utilisateur = ?');
        $req->execute(array($id));
        $result = $req->fetchAll();     
        if(isset($result)) {
            foreach($result as $value) {
                if(password_verify($token,$value['token_hash'])) {
                    if($this->estValide($value)) {
                        return $value;
                    }
                }
            }
            return null;
        }
        else{
            return null;
        }
    }

    public function removeValide($result) {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE `tbl_autologin` SET `est_valide`=0 WHERE token_hash  = ?');
        $req->execute(array($result['token_hash']));        
    }

    public function estValide($result) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT `est_valide` FROM `tbl_autologin` WHERE token_hash  = ?');
        $req->execute(array($result['token_hash']));      
        return $req->fetch();  
    } 
}

?>