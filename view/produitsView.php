

<?php $titreH1= _('Les produits')?>


<?php if(isset($categorie)) {
    $titreH1.= ' '._('de catégorie ').$categorie;
    $title = $categorie;
}
else {
    $title = _('Produits');
}
require('controller/controllerCategorie.php');

$categories = getCategories(substr($_SESSION['langue'], 0, 2));
?>

<?php ob_start(); ?>
<h1><?=$titreH1?></h1><input type="image" src="./inc/img/add-icon.png" alt="Ajouter un produit" />
<form action="index.php" method="post" class="hidden Se connecter" id="addProduitForm">
    <fieldset>
        <legend><?= _('Gestion d\'un produit')?></legend>
        <label for="produit"><?= _('Produit'). ': '?> </label>
        <input type="text" name="produit">
        <br>
        <label for="categorie"><?= _('Catégorie'). ': '?></label>
        <select name="categorie" id="categorie">
            <?php foreach($categories as $c) {
                echo '<option value="'.$c->get_id_categorie().'">'.$c->get_categorie().'</option>';
            }?>
        </select>
        <br>
        <label for="description"><?= _('Description')?></label>
        <input type="text" name="description">
        <br>
        <input type="hidden" name="action" value="createProduit" required>
        <button type="submit"><?= _('Envoyer')?></button>
    </fieldset>
</form>
<?php foreach($produits as $produit) {?>
    <div>
        <h3><?= _('Produit'). ': '.htmlspecialchars($produit->get_produit()) ?> </h3>        
        <p><?= _('Description').' '.htmlspecialchars($produit->get_description()) ?> </p>
        <input type="image" src="./inc/img/delete-icon.png" alt="Supprimer un produit"
       value="<?= htmlspecialchars($produit->get_id_produit()) ?>" />
        <hr>
    </div>
<?php } ?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>