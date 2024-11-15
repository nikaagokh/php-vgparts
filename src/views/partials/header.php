<div class="header">
    <div class="header__wrapper flex justify-c align-c">
        <div class="header__left align-c">
            <button class="button button-icon header__category-mobile">
                <i class="material-symbols-outlined">menu</i>
            </button>
            <a href="/vgparts/" class="header__logo" data-link>
                <div class="header__logo-wrapper">
                    VG <span class="header__logo-content">Parts</span>
                </div>
                <img src="<?= aurl . 'car-logo.png' ?>" alt="ავტომანქანის ლოგო" width="100" height="50">
            </a>
            <button class="button button-bordered header__category-desktop">
                <i class="material-symbols-outlined">menu</i>
                კატეგორიები
                <i class="material-symbols-outlined">keyboard_arrow_down</i>
            </button>
        </div>
        <div class="header__right">
            <button class="button button-icon mobile header__input-search-icon">
                <i class="material-symbols-outlined">search</i>
            </button>
            <div class="header__input-wrapper desktop">
                <i class="material-symbols-outlined header__input-icon">search</i>
                <input type="text" placeholder="ძიება" class="header__input-search">
            </div>
            <div class="header__right-wrapper-mobile">
                <div class="header__button-overlay">
                    <button class="button button-icon" id="headerFilter">
                        <i class="material-symbols-outlined">filter_alt</i>
                        <span class="tooltip">ფილტრი</span>
                        <span class="badge flex justify-c align-c">0</span>
                    </button>
                </div>
                <div class="header__button-overlay">
                    <button class="button button-icon" id="headerFavorite">
                        <i class="material-symbols-outlined">favorite</i>
                        <span class="tooltip">ფავორიტები</span>
                    </button>
                </div>
                <div class="header__button-overlay">
                    <button class="button button-icon" id="headerCart">
                        <i class="material-symbols-outlined">shopping_bag</i>
                        <span class="tooltip">კალათა</span>
                        <span class="badge" id="badgeCart">0</span>
                    </button>
                </div>
                <div class="header__button-overlay">
                    <button class="button button-icon desktop" id="headerUser">
                        <i class="material-symbols-outlined">person</i>
                        <span class="tooltip">ანგარიში</span>
                    </button>
                </div>
            </div>
            <div class="header__right-wrapper-desktop">
                <div class="header__filter-button-wrapper">
                    <button class="button button-icon-desktop" id="headerFilter">
                        <i class="material-symbols-outlined">filter_alt</i>
                        <span>ფილტრი</span>
                    </button>
                </div>
                <div class="header__favorites-button-wrapper relative">
                    <button class="button button-icon-desktop" id="headerFavorite">
                        <i class="material-symbols-outlined">favorite</i>
                        <span class="badge" id="badgeFavorite">0</span>
                        <span>ფავორიტები</span>
                    </button>
                </div>
                <div class="header__cart-button-wrapper relative">
                    <button class="button button-icon-desktop" id="headerCart">
                        <i class="material-symbols-outlined">shopping_bag</i>
                        <span class="badge" id="badgeCart">0</span>
                        <span>კალათა</span>
                    </button>
                </div>
                <div class="header__user-button-wrapper">
                    <button class="button button-icon-desktop" id="headerUser">
                        <i class="material-symbols-outlined">person</i>
                        <span>ანგარიში</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>