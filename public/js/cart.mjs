import { Header } from "./header.js";
import { Cart } from "./cart.js";

function init() {
    new Header();
    new Cart();
}
window.addEventListener("DOMContentLoaded", init);