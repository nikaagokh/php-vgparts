<?php

use function Core\partial;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>მთავარი გვერდი</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href=<?= url . '/public/css/styles.css' ?>>

</head>

<body>
    <?php partial('header') ?>
    <div class="app-container">
        <div class="inner-wrapper">
            <div class="cart-container">
                <div class="header__cart-empty-wrapper" style="display:none;">
                    <div class="header__cart-empty-flex">
                        <img src="/vgparts/public/images/assets/empty-cart.png" width="100" height="70">
                    </div>
                    <div class="header__cart-message">
                        თქვენი კალათა ცარიალია!
                    </div>
                </div>
            </div>
            <div class="price-container">
                <div class="price-wrapper">
                    <div class="price-flex">
                        <div class="price">
                            პროდუქტის ღირებულება
                            <span class="oldPrice"></span>
                        </div>
                        <div class="price sale">
                            ფასდაკლება
                            <span class="newPrice"></span>
                        </div>
                        <div class="price total">
                            საბოლოო ღირებულება
                            <span class="totalPrice"></span>
                        </div>
                        <div class="delivery">
                            <i class="material-symbols-outlined">local_shipping</i>
                            მიტანა + 15ლ
                        </div>
                        <div class="delivery">
                            <i class="material-symbols-outlined">phone</i>
                            555 555-555
                        </div>
                        <div class="button-actions">
                            <button class="button back-button button-cart" id="buy-button">ყიდვა</button>
                            <button class="button cart-button button-buy" id="cart-button">კალათაში</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php partial('footer') ?>
    <div class="overlay-container"></div>
    <div class="toast-container"></div>
    <script src="/vgparts/public/js/cart.mjs" type="module"></script>
</body>