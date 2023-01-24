<?php $title = 'Categories'?>

<?php ob_start(); ?>
<h1>Les Catégories</h1>

<?php foreach($categories as $categorie) { ?>
    <div>
        <h3>Categories: <?= htmlspecialchars($categorie->get_Categorie()) ?> </h3>        
        <p>Description: <?= htmlspecialchars($categorie->get_description()) ?> </p>
        <a href=<?="produitscategorie/".$categorie->get_id_categorie().""?>>Voir <?=$categorie->get_Categorie()?></a>        
        <hr>
    </div>
<?php } ?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>