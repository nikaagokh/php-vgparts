<?php

use function Core\partial;
use Core\Helper;

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
        <div class="submenu-container">
            <div class="submenu-wrapper">
                <?php foreach ($subcategories as $item) : ?>
                    <?php foreach ($item['cyear'] as $year) : ?>
                        <a class="submenu-card" href="/vgparts/category?yearId=<?php echo $year['yearId']; ?>&categoryId=<?php echo $item['id']; ?>&offset=1">
                            <div class="submenu-card-flexcol">
                                <div class="submenu-img-wrapper">
                                    <img class="submenu-img" src=<?php echo surl . $year['imageUrl']; ?>>
                                </div>
                                <div class="desci">
                                    <span class="title"><?php echo $item['name'] ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php partial('footer') ?>
    <div class="overlay-container"></div>
    <div class="toast-container"></div>
    <script src="/vgparts/public/js/subcategory.mjs" type="module"></script>
</body>