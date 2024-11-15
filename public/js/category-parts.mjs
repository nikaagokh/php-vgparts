import { CategoryParts } from "./category-parts.js";
import { Header } from "./header.js";

function init() {
    new Header();
    new CategoryParts();
}
window.addEventListener("DOMContentLoaded", init);