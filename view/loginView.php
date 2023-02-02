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

    <div id="g_id_onload"
         data-client_id="728131155971-vmpvhnla4j66f5019ohdiam9gtbhhmp9.apps.googleusercontent.com"
         data-login_uri="https://localhost/FichiersSiteWeb/"
         data-auto_prompt="false">
      </div>
      <div class="g_id_signin"
         data-type="standard"
         data-size="large"
         data-theme="outline"
         data-text="sign_in_with"
         data-shape="rectangular"
         data-logo_alignment="left">
      </div>
</form>

<div class="g-signin2" data-onsuccess="onSignIn"></div>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>