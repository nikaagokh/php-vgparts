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
        <div class="category-container">
            <div class="category-wrapper">
                <section class="category-product-flex">
                <?php foreach ($products as $product) : ?>
                        <article class="app-slider__card">
                            <a href="/vgparts/product/<?php echo $product['id']; ?>" class="app-slider__link" data-link>
                                <div class="app-slider__image-wrapper">
                                    <img src="<?php echo isset($product['images'][0]) ? purl . ($product['images'][0]) : ''; ?>" class="app-slider__image" width="120" height="60">
                                </div>
                                <div class="app-slider__product-desc">
                                    <h4 class="app-slider__product-title"><?php echo $product['nameGeo']; ?></h4>
                                    <div class="app-slider__product-available">
                                        <?php if ($product['available']) : ?>
                                            <i class="material-symbols-outlined app-slider__availability-icon">check</i>
                                            <?php if ($product['type']) : ?>
                                                <span>გასაქირავებელი</span>
                                            <?php else : ?>
                                                <span>მარაგშია</span>
                                            <?php endif; ?>
                                        <?php else : ?>
                                            <i class="material-symbols-outlined app-slider__not-availability-icon">check_indeterminate_small</i>
                                            <?php if ($product['type']) : ?>
                                                <span>გაქირავებული</span>
                                            <?php else : ?>
                                                <span>ამოიწურა</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="app-slider__product-price">
                                    <?php echo $product['price']; ?>₾
                                </div>
                            </a>
                            <div class="app-slider__actions">
                                <div class="flex">
                                    <button class="button button-icon" id="app-slider__zoom">
                                        <i class="material-symbols-outlined">zoom_in</i>
                                        <span class="tooltip">გადიდება</span>
                                    </button>
                                    <button class="button button-icon" id="app-slider__favorite">
                                        <i class="material-symbols-outlined">favorite</i>
                                        <span class="tooltip">ფავორიტები</span>
                                    </button>
                                </div>
                                <button class="button button-icon" id="app-slider__cart">
                                    <i class="material-symbols-outlined">shopping_bag</i>
                                    <span class="tooltip">კალათა</span>
                                </button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                    <div class="products-hydration" style="display: none;"><?= $hydration?></div>
                </section>
                <div class="pagination-container" id="paginationContainer">
                    <div class="pagination-flex">
                        <div class="prev pad<?php echo $isFirstPage ? ' inactive' : ''; ?>">
                            <i class="arrow material-symbols-outlined<?php echo $isFirstPage ? ' inactive' : ''; ?>">chevron_left</i>
                        </div>
                        <?php foreach ($pagesToShow as $page) : ?>
                            <a href="/vgparts/filtered?yearIds=<?php echo $yearIds ?>&offset=<?php echo $page; ?>" class="number pad<?php echo Helper::isCurrentPage($page, $currentPage) ? ' active-pagination' : ''; ?>" data-page="<?php echo $page; ?>">
                                <?php echo $page; ?>
                            </a>
                        <?php endforeach; ?>
                        <div class="next pad<?php echo $isLastPage ? ' inactive' : ''; ?>">
                            <i class="arrow material-symbols-outlined<?php echo $isLastPage ? ' inactive' : ''; ?>">chevron_right</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php partial('footer') ?>
    <div class="overlay-container"></div>
    <div class="toast-container"></div>
    <script src="/vgparts/public/js/filter.mjs" type="module"></script>
</body>