<?php
use function Core\partial;
use Core\Helper;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>პროდუქტი</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" /><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href= <?= url . '/public/css/styles.css' ?>>
</head>
<body>
    <?php partial('header') ?>
    <div class="app-container">
        <div class="product-container">
            <div class="product-wrapper">
                <?php partial('gallery', ['product' => $product]) ?>
                <?php partial('price', ['priceObj' => $priceObj]) ?>
                <?php partial('info', ['product' => $product]) ?>
                <?php partial('simillars', ['simillars' => $simillars]) ?>
            </div>
            <div class="product-hydration" style="display: none;"><?= Helper::encode($product) ?></div>
        </div>
    </div>
    <?php partial('footer') ?>
    <div class="overlay-container"></div>
    <div class="toast-container"></div>
    <script src='/vgparts/public/js/product.mjs' type="module"></script>
</body>
</html>