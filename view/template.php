<?php $baseURL = "/FichiersSiteWeb/";
require_once('model/AutologManager.php')?>
<script src="inc/js/ajax.js" defer></script>
<!DOCTYPE html>
<html>
    <head>
        <meta meta name="referrer" content="no-referrer-when-downgrade" charset="utf-8"/>
        <title><?= $title ?></title>
        <link href="<?= $baseURL;?>inc/css/style.css" rel="stylesheet" /> 
        <script src="https://accounts.google.com/gsi/client" async defer></script>
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
                echo _("Bienvenue")." ".$_SESSION['courriel'];
            }

            
        ?>
        <nav>
            
            <ul>
                <li><a href="<?= $baseURL;?>index.php"><?= _('Accueil')?></a></li>
                <li><a href="<?= $baseURL;?>produits"><?= _('Les produits')?></a></li>
                <li><a href="<?= $baseURL;?>categories"><?= _('Les catégories')?></a></li>
                <?php 
                $am = new AutologManager();
                
                
                if(isset($_SESSION['courriel']) && $_SESSION['courriel']!=null||isset($_COOKIE['g_csrf_token'])) { 
                    echo "<li><a href=".$baseURL."deconnexion>"._('Se déconnecter')."</a></li>";
                
                }
                else {
                    echo "<li><a href=".$baseURL."connexion>"._('Se connecter')."</a></li>";
                    echo "<li><a href=".$baseURL."inscrire>"._('S\'inscrire')."</a></li>";
                }
                
                if(isset($_COOKIE['session']) && $am->verifyToken(json_decode($_COOKIE['session'])->user_id,json_decode($_COOKIE['session'])->token)!=null) {
                    echo "<li><a href=".$baseURL."delete>"._('Se déconnecter')."</a></li>";
                }
                
                ?>
                <li><a href="index.php?action=changerLangue&langue=en_ca"><?= _("Anglais") ?></a></li>
                <li><a href="index.php?action=changerLangue&langue=fr_ca"><?= _("Français") ?></a></li>
                <li><a href="index.php?action=changerLangue&langue=pt_br"><?= _("Portugais") ?></a></li>
                
            </ul>
        </nav>
        <?= $content ?>
    </body>
</html>