<?php $title = 'Achat'?>

<?php ob_start(); ?>
<h1>Achat des produits</h1>



<form action="/index.php">
  <fieldset>

    <div class="grid-container">
        <h4>Produit</h4>
        <h4>Quantité</h4>  
        <h4>Prix/unité ($)</h4>
        <h4>Total ($)</h4>
    </div>
    <?php

      for ($i = 0;$i < sizeof($produits);$i++) {
        if($i!=sizeof($produits)-1) {
          echo '<div class="grid-container">'.$produits[$i]->get_produit();
          echo '<input type="text" id="produit'.$i.'" name="produit" value="0">';
          echo '<input type="text" id="produitl'.$i.'" name="produitl" value='.$produits[$i]->get_prix().' readonly>';
          echo '<input type="text" id="produitlt'.$i.'" name="produitt" value="0" readonly>';
          echo '</div>';
          echo '<br>';
        }
        else {
          echo '<div class="grid-container">';
          echo '<bold>Grand total ($) :</bold>';
          echo '<input type="text" id="produitltot" name="produitot" value="0" readonly>';
          echo '</div>';
        }
      }
      ?>
  </fieldset>
</form>
<div id="paypal-button-container"></div>

  

<?php $content = ob_get_clean(); ?>

<?php require('template.php'); ?>