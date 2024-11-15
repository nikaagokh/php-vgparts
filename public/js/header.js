import httpService from "./services/http.js";
import authService from "./services/auth.js";
import overlayService from "./services/overlay.js";
import toastService from "./services/toast.js";
import { MiniCart } from "./minicart.js";
import { MenuDesktop } from "./menudesktop.js";
import { SearchBox } from "./searchbox.js";
export class Header {
    constructor() {
        this.toastService = toastService;
        this.auth = authService;
        this.httpService = httpService;
        this.searchBox = null;
        this.cartOverlay = null;
        this.categoryOverlay = null;
        this.element = document.querySelector(".header");
        this.headerCategory = document.querySelector(".header__category-desktop");
        this.headerCategoryMob = document.querySelector(".header__category-mobile");
        this.headerFilter = document.querySelectorAll("#headerFilter");
        this.headerFavorite = document.querySelectorAll("#headerFavorite");
        this.headerCart = document.querySelectorAll("#headerCart");
        this.headerUser = document.querySelectorAll("#headerUser");
        this.badgeFavorite = document.querySelector("#badgeFavorite");
        this.badgeCart = document.querySelectorAll("#badgeCart");
        this.headerInput = document.querySelector(".header__input-search");
        this.headerInputBox = document.querySelector(".header__input-box");
        this.listContainer = document.querySelector(".header__input-box-list");
        this.spinnerContainer = document.querySelector(".header__input-spinner");
        this.notExistContainer = document.querySelector(".header__input-not-exist-wrapper");
        this.headerInput.addEventListener("input", this.debounce(this.handleInputDebounced,500));
        this.headerFilter.forEach(filter => {
            filter.addEventListener("click", () => {
                overlayService.openFilter();
            })
        });
        this.headerFavorite.forEach(icon => {
            
            icon.addEventListener("click", (ev) => {
                this.auth.isAuthenticated().then(response => {
                    if(!response) {
                        this.toastService.showToast("თქვენ არ ხართ ავტორიზებული, გთხოვთ გაიაროთ რეგისტრაცია ან ავტორისზაცია");
                    } else {
                        /*
                        const favorite = new Favorites();
                        favorite.cart$.addEventListener("cart", (ev) => {
                            // add to cart
                        })
                        favorite.buy$.addEventListener("buy", (ev) => {
                            // buy
                        })
                        */
                        
                    }
                })
                //overlayService.openGlobalSpinner()
                
            })
            
           

        })
    
        this.headerCart.forEach(icon => {
            icon.addEventListener("click", () => {
                console.log('header-cart');
                if(!this.cartOverlay) {
                    
                    this.cartOverlay = new MiniCart();
                    this.cartOverlay.cart$.addEventListener("cart", () => {
                        //add to cart
                    })
                    this.cartOverlay.buy$.addEventListener("buy", () => {
                        // buy
                        
                    })
                    this.cartOverlay.close$.addEventListener("closed", () => {
                        this.cartOverlay = null;
                    })
                    
                } else {
                    this.cartOverlay.detach();
                    this.cartOverlay = null;
                }
                
            
            })
        });
        this.headerUser.forEach(user => {
            user.addEventListener("click", () => {
                overlayService.openAuth();
                
            })
        });

        this.headerCategory.addEventListener("click", async () => {
            console.log('123');
            if(!this.categoryOverlay) {
                try {
                    const response = await fetch("http://localhost/vgparts/api/category/full");
                    if(!response.ok) {
                        throw new Error("errr");
                    }
                    const fullCategories = await response.json();
                    console.log(123);
                    this.categoryOverlay = new MenuDesktop(fullCategories);
                    this.categoryOverlay.closed$.addEventListener("closed", () => {
                        this.categoryOverlay = null;
                    })
                    
                } catch(err) {
                    console.log(err);
                }
            } else {
                this.categoryOverlay.detach();
                this.categoryOverlay = null;
            }
        })
       this.headerCategoryMob.addEventListener("click", () => {
          console.log(1);
          overlayService.openMenu();
       })
       this.httpService.cartProducts$.subscribe(cartObject => {
        console.log(cartObject)
        if(cartObject.products.length > 0) {
            console.log('>0')
            this.cartProductsQuantity = cartObject.products?.reduce((acc, curr) => {
                console.log(acc)
                console.log(curr)
                return acc + curr.quantity;
            }, 0)
        } else {
            this.cartProductsQuantity = 0;
        }
        console.log(this.cartProductsQuantity)
        this.badgeCart.forEach(badge => {
            badge.textContent = this.cartProductsQuantity;
        })
       })
    }

    debounce(func, delay) {
        return function(...args) {
          clearTimeout(this.timeoutId);
          this.timeoutId = setTimeout(() => {
            func.apply(this, args);
          }, delay);
        }.bind(this);
    }

    handleInputDebounced(ev) {
        const word = ev.target.value;
        if (word.length !== 0) {
          if (this.searchBox === null) {
            this.createOverlay(word);
          } else {
            this.changeOverlayInput(word);
          }
        } else {
          this.searchBox.detach();
          this.searchBox = null;

        }
    }

    createOverlay(word) {
        
        this.searchBox = new SearchBox();
        this.searchBox.changeInput = word;
        this.searchBox.notifier.addEventListener("detach", () => {
            this.searchBox = null;
        })
        
    }

    changeOverlayInput(word) {
        
        this.searchBox.changeInput = word;
        
    }

}