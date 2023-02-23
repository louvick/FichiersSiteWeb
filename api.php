<?php
    // Le contenu sera formaté en JSON (Peut être mis en commentaire pour fins de débogage)
    header('Content-Type: application/json');

    if (isset($_REQUEST['objet'])&&$_REQUEST['objet']=="produit") {
        switch ($_REQUEST['objet']) {
            case 'produit':
                switch ($_SERVER["REQUEST_METHOD"]) {
                    case 'GET':
                        echo "GET";
                        require('controller/controllerProduit.php');
                        if($_REQUEST['id']==null) {
                            listeProduits();
                        }
                        else if($_REQUEST['id']!="") {
                            
                            //Appel la fonction produit contenu dans le controleur de Produit
                            echo produit($_REQUEST['id'],true);
                        }
                        else {
                            echo "Il n'y a pas d'id";
                        }
                        
                        break;
                    case 'POST':
                        echo "POST";
                        break;
                    case 'PUT':
                        echo "PUT";
                        break;
                    case 'DELETE':
                        echo "DELETE";
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