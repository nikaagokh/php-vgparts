<div class="gallery-container">
    <div class="gallery-product-touch">
        <div class="product-flex">
          <?php foreach ($product['images'] as $image): ?>
            <div class="gallery-product-card">
              <div class="gallery-image-wrapper">
                <img src="<?= purl . $image ?>" width="200" height="100">
              </div>
             </div>
          <?php endforeach; ?>
        </div>
    </div>
</div>