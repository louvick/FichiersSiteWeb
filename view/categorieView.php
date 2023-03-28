<?php $title = 'Categories'?>

<?php ob_start(); ?>
<h1><?= _('Les Catégories')?></h1>

<?php foreach($categories as $categorie) { ?>
    <div>
        <h3><?= _('Catégories').": ".htmlspecialchars($categorie->get_Categorie()) ?> </h3>        
        <p><?= _('Description').": ".htmlspecialchars($categorie->get_description()) ?> </p>
        <a href=<?="index.php?action=produitscategorie&id=".$categorie->get_id_categorie()?>><?= _('Voir')?> <?=$categorie->get_Categorie()?></a>        
        <hr>
    </div>
<?php } ?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>