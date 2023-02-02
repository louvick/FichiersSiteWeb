<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Utilisateur.php");

class UtilisateurManager extends Manager
{
    public function verifAuthentification($courriel, $motPasse) {
        $utilisateur = $this->getUtilisateurParCourriel($courriel);
        if($utilisateur!=null) {
            if(password_verify($motPasse,$utilisateur->get_mdp())) {
                return $utilisateur;
            }
            else {
                return null;
            }
        }
        else {
            return null;
        }
    }

    public function getUtilisateurParCourriel($courriel) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM tbl_utilisateur WHERE courriel = ?');
        $req->execute(array($courriel));
        $utilisateur = new Utilisateur($req->fetch());

        if(isset($utilisateur)) {
            return $utilisateur;
        }
        else{
            return null;
        }
    }

    public function addUtilisateur($infosUtilisateur) {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO `tbl_utilisateur` (`nom`,`prenom`,`courriel`,`mdp`,`est_actif`,`role_utilisateur`,`type_utilisateur`) VALUES (:nom, :prenom, :courriel, :mdp, :est_actif, :role_utilisateur, :type_utilisateur)');
        $req->execute(array(':nom'=>$infosUtilisateur['family_name'],':prenom'=>$infosUtilisateur['given_name'],':courriel'=>$infosUtilisateur['email'],':mdp'=>password_hash($infosUtilisateur['sub'], PASSWORD_DEFAULT),':est_actif'=>'1',':role_utilisateur'=>'0',':type_utilisateur'=>'1'));

        //$req = $db->prepare('INSERT INTO `tbl_utilisateur` (`nom`,`prenom`,`courriel`,`mdp`,`est_actif`,`role_utilisateur`,`type_utilisateur`)');
        //$req->execute(array($infosUtilisateur['family_name'],$infosUtilisateur['given_name'],$infosUtilisateur['email'],password_hash($infosUtilisateur['sub'], PASSWORD_DEFAULT),'1','0','1'));
        $utilisateur = new Utilisateur($req->fetch());

    }
}
