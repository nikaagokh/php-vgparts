import { Slider } from "./slider.js";

export class Home {
    constructor() {
        this.loaded = false;
        this.products = null;
        new Slider('ფასდაკლებები');
        new Slider('პოპულარულები')
    }
}