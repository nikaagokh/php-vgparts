import httpService from "./services/http.js";
import toastService from "./services/toast.js";
import overlayService from "./services/overlay.js";

export class Slider {
    constructor(group) {
        this.group = group;
        //this.socketService = socketService;
        this.httpService = httpService;
        this.overlayService = overlayService;
        this.toastService = toastService;
        this.size = document.querySelector(".app-slider__card").clientWidth;
        console.log(document.querySelector(`.${this.group}__container`));
        this.sliderContainer = document.querySelector(`.${this.group}__container`);
        this.productFlex = this.sliderContainer.querySelector(".app-slider__flex");
        console.log(this.sliderContainer.querySelector(`.slider-${this.group}`));
        this.products = JSON.parse(this.sliderContainer.querySelector(`.slider-${this.group}`).textContent);
        this.pos = 0;
        this.loc = 0;
        this.listeners();
    }
    listeners() {
            const zoomButtons = this.sliderContainer.querySelectorAll("#app-slider__zoom");
            const favButtons = this.sliderContainer.querySelectorAll("#app-slider__favorite");
            const cartButtons = this.sliderContainer.querySelectorAll("#app-slider__cart");
            const prevButton = this.sliderContainer.querySelector(".app-slider__prev");
            const nextButton = this.sliderContainer.querySelector(".app-slider__next");
            zoomButtons.forEach((zoom, i) => {
                zoom.addEventListener("click", (ev) => {
                    //const id = Number(ev.target.closest('article').getAttribute("data-id"));
                    //this.overlayService.openZoom((this.productsArray.find(obj => obj.id === id)).images[0].path);
                    this.overlayService.openZoom(this.products[i].images[0]);
                })
            })
    
            favButtons.forEach((fav,i) => {
                fav.addEventListener("click", () => {
                    this.httpService.loginTest().then(x => {
                        console.log(x);
                    })
                    this.toastService.showToast("თქვენ არ ხართ ავტორიზებული, გთხოვთ გაიაროთ რეგისტრაცია ან ავტორიზაცია");
                })
            })
    
            cartButtons.forEach((cart, i) => {
                cart.addEventListener("click", (ev) => {
                    console.log(1);
                    //this.socketService.emit();
                    //this.socketService.reconnectSocket();
                    //const id = Number(ev.target.closest('article').getAttribute("data-id"));
                    //this.httpService.addToCart(this.productsArray.find(obj => obj.id === id))
                    this.httpService.addToCart(this.products[i]);
                })
            })
    
            prevButton.addEventListener("click", () => {
                console.log('prev')
                if(this.pos !== 0) {
                    this.pos--;
                    this.updateSlidePosition();
                }
            })
    
            nextButton.addEventListener("click", () => {
                if(this.products.length > 4 && this.products.length > this.pos + 4) {
                    this.pos++;
                    this.updateSlidePosition();
                }
            })
    }

    updateSlidePosition() {
        this.loc = -(this.size * this.pos) - (this.pos * 10);
        this.productFlex.style.transform = `translateX(${this.loc}px)`;
    }
}