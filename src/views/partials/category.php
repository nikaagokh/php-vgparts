<div class="category__container">
    <div class="category__header">
        <div class="category-title">
            კატეგორიები
        </div>
    </div>
    <div class="category__wrapper">
        <?php foreach ($categories as $category): ?>
            <a href="/vgparts/subcategory?id=<?= $category['id'] ?>&category=<?= $category['name'] ?>" class="category-card" data-link>
                <div class="image-wrapper">
                    <img src="<?= curl . $category['image'] ?>" class="img category-img" priority alt="<?= $category['name'] ?>">
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>