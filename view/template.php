<?php $baseURL = "/FichiersSiteWeb/";
require_once('model/AutologManager.php')?>


<!DOCTYPE html>
<html>
    <head>
        
        <meta meta name="referrer" content="no-referrer-when-downgrade" charset="utf-8"/>
        <title><?= $title ?></title>
        <link href="<?= $baseURL;?>inc/css/style.css" rel="stylesheet" /> 
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        <script src="inc/js/ajax.js" defer></script>
        <script src="inc/js/calcul.js" defer></script>
    </head>
    

    <body>
        <?php
            echo '----------------------------<br />
                  Paramètres reçus :<br />
                  $_REQUEST :<br />
                  <pre>';
        
            print_r($_REQUEST);
        
            echo '</pre>
                  $_COOKIE :<br />
                  <pre>';
        
            print_r($_COOKIE);

            echo '</pre>
                  $_SESSION :<br />
                  <pre>';
        
            print_r($_SESSION);
        
            echo '</pre>----------------------------<br />';
        
            if(isset($_SESSION['courriel'])) {
                echo "Bienvenue ".$_SESSION['courriel'];
            }

            
        ?>
        <nav>
            
            <ul>
                <li><a href="<?= $baseURL;?>index.php">Accueil</a></li>
                <li><a href="<?= $baseURL;?>produits">Les produits</a></li>
                <li><a href="<?= $baseURL;?>categories">Les catégories</a></li>
                <?php 
                $am = new AutologManager();
                
                
                if(isset($_SESSION['courriel']) && $_SESSION['courriel']!=null||isset($_COOKIE['g_csrf_token'])) { 
                    echo '<li><a href="'.$baseURL.'index.php?action=achatProduit">Achat</a></li>';
                    echo "<li><a href=".$baseURL."deconnexion>Se déconnecter</a></li>";
                
                }
                else {
                    echo "<li><a href=".$baseURL."connexion>Se connecter</a></li>";
                    echo "<li><a href=".$baseURL."inscrire>S'inscrire</a></li>";
                }
                
                if(isset($_COOKIE['session']) && $am->verifyToken(json_decode($_COOKIE['session'])->user_id,json_decode($_COOKIE['session'])->token)!=null) {
                    echo "<li><a href=".$baseURL."delete>Se déconnecter</a></li>";
                }
                
                ?>
                
            </ul>
        </nav>
        <?= $content ?>
    </body>
</html>