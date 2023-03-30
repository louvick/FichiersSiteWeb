<?php $title = 'S\'inscrire';?>

<?php //Démarre la tamporisation du contenu ?>
<?php ob_start(); ?>

<form action="index.php" method="post" class="Se connecter">
    <fieldset>
        <h2>S'inscrire</h2>
        <label for="prenom">Prenom</label>
        <input type="text" name="prenom" id="prenom" required>
        <br>
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" required>
        <br>
        <label for="courriel">Courriel</label>
        <input type="text" name="courriel" id="courriel" required>
        <br>
        <label for="mdp">Mot de passe</label>
        <input type="password" name="mdp" id="mdp" required>
        <br>
        <input type="hidden" name="action" value="inscription" required>
        <button type="submit">S'inscrire</button>
    </fieldset>
</form>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>