import { Header } from "./header.js";
import { Product } from "./product.js";

function init() {
    new Header();
    new Product();
}
window.addEventListener("DOMContentLoaded", init);