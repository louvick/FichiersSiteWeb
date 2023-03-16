<?php
    // Le contenu sera formaté en JSON (Peut être mis en commentaire pour fins de débogage)
    header('Content-Type: application/json');

    if (isset($_REQUEST['objet'])&&$_REQUEST['objet']=="produit") {
        switch ($_REQUEST['objet']) {
            case 'produit':
                switch ($_SERVER["REQUEST_METHOD"]) {
                    case 'GET':
                        require('controller/controllerProduit.php');
                        
                        if(!isset($_REQUEST['id'])) {
                            http_response_code(200);
                            echo listProduits(true);
                        }
                        else if(isset($_REQUEST['id'])&&$_REQUEST['id']!="") {
                            $reponse = produit($_REQUEST['id'],true);
                            
                            if($_REQUEST['id']>0&&$reponse!= null) {
                                echo $reponse;
                            }
                            else {
                                http_response_code(400);
                                echo '{"ÉCHEC" : "Aucun produit ne correspond à votre requête."}';
                            }
                            
                        }
                        else {
                            echo "Il n'y a pas d'id";
                        }
                        
                        break;
                    case 'POST':
                        require('controller/controllerCategorie.php');
                        require('controller/controllerProduit.php');
                        $infosNouveauProduit = json_decode(file_get_contents('php://input'), true);
                        
                        if(isset($infosNouveauProduit['produit'])&&isset($infosNouveauProduit['id_categorie'])&&isset($infosNouveauProduit['description'])&&getCategorieId($infosNouveauProduit['id_categorie'])!=null) {
                            if(insertProduit($infosNouveauProduit['produit'],$infosNouveauProduit['id_categorie'],$infosNouveauProduit['description'])) {
                                http_response_code(200);
                                echo '{"SUCCÈS" : "L\'ajout du produit a fonctionné."}';
                            }
                            else {
                                http_response_code(400);
                                echo '{"ÉCHEC" : "L\'ajout du produit n\'a pas fonctionné."}';
                            }
                        }
                        else if(isset($infosNouveauProduit['id_categorie'])&&$infosNouveauProduit['id_categorie']<0) {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "L\'ajout du produit a échoué. L\'ID de la catégorie n’est pas un chiffre positif."}';
                        }
                        else if(isset($infosNouveauProduit['id_categorie'])&&!getCategorieId($infosNouveauProduit['id_categorie'])) {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "L\'ajout du produit a échoué. L\'ID de la catégorie n’existe pas en BD."}';
                        }
                        else {
                            http_response_code(400);
                            echo '{"ÉCHEC" : "Il manque des paramètres."}';
                        }

                        break;
                    case 'PUT':
                        echo "PUT";
                        break;
                    case 'DELETE':
                        require('controller/controllerProduit.php');
                        if(isset($_REQUEST["id"])&&$_REQUEST["id"]>0) {
                            if(removeProduit($_REQUEST["id"],true)>0) {
                                echo '{"SUCCÈS " : "La suppression du produit a fonctionné."}';
                                http_response_code(200);
                            }
                            else {
                                http_response_code(400);
                                echo '{"ÉCHEC " : "La suppression du produit a échoué. L\'ID du produit n\'existe pas."}';
                            }
                        }
                        else {
                            http_response_code(400);
                            echo '{"ÉCHEC " : "La suppression du produit a échoué. L\'ID du produit est erronné."}';
                            
                        }
                        break;
                    default:
                        http_response_code(400);
                        echo '{"ÉCHEC" : "Seuls GET, POST, PUT ou DELETE sont permis."}';
                }
                break;
            default:
                http_response_code(400);
                echo '{"ÉCHEC" : "Seuls les produits peuvent être traités."}';
        }
    }

?>