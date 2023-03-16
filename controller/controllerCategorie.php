<?php

require('model/CategorieManager.php');

function listCategories()
{
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories();

    require('view/categorieView.php');
}

function getCategories()
{
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories();
    return $categories;
}

function getCategorieId($id)
{
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategorieId($id);
    return $categories;
}
?>