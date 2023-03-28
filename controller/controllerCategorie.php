<?php

require('model/CategorieManager.php');

function listCategories($langue)
{
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories($langue);

    require('view/categorieView.php');
}

function getCategories($langue)
{
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategories($langue);
    return $categories;
}

function getCategorieId($langue,$id)
{
    $categorieManager = new CategorieManager();
    $categories = $categorieManager->getCategorieId($langue,$id);
    return $categories;
}
?>