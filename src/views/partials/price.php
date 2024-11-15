<div class="price-container">
    <div class="price-wrapper">
        <div class="price-flex">
            <div class="price">
                პროდუქტის ღირებულება
                <span><?= $priceObj['oldPrice'] ?>₾</span>
            </div>
            <div class="price sale">
                ფასდაკლება
                <span>-<?= $priceObj['discountPrice'] ?>₾</span>
            </div>
            <div class="price total">
                საბოლოო ღირებულება
                <span><?= $priceObj['newPrice'] ?>₾</span>
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