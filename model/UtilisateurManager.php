<?php

// Ce fichier sert à communiquer avec la BD et construire les objets pour les retourner au controleur.
// Ces fonctions sont généralement appelé par le routeur (index.php) ou d'autres contrôleurs.

require_once("model/Manager.php");
require_once("model/Utilisateur.php");

class UtilisateurManager extends Manager
{
    public function verifAuthentification($courriel, $motPasse) {
        $utilisateur = getUtilisateurParCourriel($courriel);
        if($utilisateur!=null) {
            if(password_verify($utilisateur->get_mdp(),$motPasse)) {
                return $utilisateur;
            }
            else {
                return null;
            }
        }
        return null;
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
}

