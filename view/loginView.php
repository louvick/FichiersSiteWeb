<?php $title = 'Accueil';?>

<?php //Démarre la tamporisation du contenu ?>
<?php ob_start(); ?>

<form action="index.php" method="post" class="Se connecter">
    <fieldset>
        <h2>Se connecter</h2>
        <label for="courriel">Courriel</label>
        <input type="text" name="courriel" id="courriel">
        <br>
        <label for="mdp">Mot de passe</label>
        <input type="text" name="mdp" id="mdp">
        <br>
        <label for="souvenir">Se souvenir de moi</label>
        <input type="checkbox" name="souvenir" id="souvenir">
        <br>
        <input type="hidden" name="action" value="authentifier">
        <button type="submit">Se connecter</button>
    </fieldset>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>