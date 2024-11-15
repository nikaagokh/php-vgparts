<?php
use Core\Helper;
?>
<div class="app-slider__container <?= $category ?>__container">
    <div class="app-slider__title">
        <h4 class="app-slider__category"><?= $category ?></h4>
        <div class="app-slider__nav">
            <button class="button button-icon back-white app-slider__prev">
                <i class="material-symbols-outlined">keyboard_arrow_left</i>
            </button>
            <button class="button button-icon back-white app-slider__next">
                <i class="material-symbols-outlined">keyboard_arrow_right</i>
            </button>
        </div>
    </div>
    <div class="app-slider__body">
        <section class="<?= $category ?>__flex app-slider__flex">
            <?php foreach ($products as $product): ?>
                <article class="app-slider__card" data-id="<?= $product['id'] ?>">
                    <a href="/vgparts/product/<?= $product['id'] ?>" class="app-slider__link" data-link>
                        <div class="app-slider__image-wrapper">
                            <img src="<?= purl . $product['images'][0] ?>" class="app-slider__image" width="120" height="60">
                        </div>
                        <div class="app-slider__product-desc">
                            <h4 class="app-slider__product-title"><?= $product['nameGeo'] ?></h4>
                            <div class="app-slider__product-available">
                                <?php if ($product['available']): ?>
                                    <i class="material-symbols-outlined app-slider__availability-icon">check</i>
                                    <?php if ($product['type']): ?>
                                        <span>გასაქირავებელი</span>
                                    <?php else: ?>
                                        <span>მარაგშია</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <i class="material-symbols-outlined app-slider__not-availability-icon">check_indeterminate_small</i>
                                    <?php if ($product['type']): ?>
                                        <span>გაქირავებული</span>
                                    <?php else: ?>
                                        <span>ამოიწურა</span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="app-slider__product-price">
                            <?= $product['price'] ?>₾
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
            <div class="slider-<?= $category ?>" style="display:none;"><?= Helper::encode($hydration); ?></div>
        </section>
    </div>
    <div class="app-slider__see-all-wrapper">
        <a class="app-slider__see-all-flex" href="/vgparts/groupby?path=<?= $path ?>&group=<?= $category ?>&offset=1" data-link>
            ყველას ნახვა
            <i class="material-symbols-outlined">keyboard_arrow_right</i>
        </a>
    </div>
</div>