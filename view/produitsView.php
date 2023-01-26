

<?php $titreH1= 'Les produits'?>

<?php if(isset($categorie)) {
    $titreH1.= ' de catégorie '.$categorie;
    $title = $categorie;
}
else {
    $title = 'Produits';
}
?>

<?php ob_start(); ?>
<h1><?=$titreH1?></h1>
<?php foreach($produits as $produit) {?>
    <div>
        <h3>Produit: <?= htmlspecialchars($produit->get_produit()) ?> </h3>        
        <p>Description: <?= htmlspecialchars($produit->get_description()) ?> </p>        
        <hr>
    </div>
<?php } ?>

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>