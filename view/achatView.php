<?php $title = 'Achat des produits';?>

<?php //Démarre la tamporisation du contenu ?>
<?php ob_start(); ?>

<form action="index.php" method="post" class="Se connecter" id="paypalform">
    <fieldset>
        <h2><?= _('Achat des produits')?></h2>
        <label for="produit"><?= _('Prenom')?></label>
        <input type="text" name="prenom" id="prenom" required>
        <br>
        <label for="nom"><?= _('Nom')?></label>
        <input type="text" name="nom" id="nom" required>
        <br>
        <label for="courriel"><?= _('Courriel')?></label>
        <input type="text" name="courriel" id="courriel" required>
        <br>
        <label for="mdp"><?= _('Mot de passe')?></label>
        <input type="password" name="mdp" id="mdp" required>
        <br>
        <input type="hidden" name="action" value="inscription" required>
        <button type="submit"><?= _('S\'inscrire')?></button>
    </fieldset>
</form>

<div id="paypal-button-container"></div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>