import { Header } from './header.js';
import { Buy } from './buy.js';

function init() {
    new Header();
    new Buy();
}
window.addEventListener("DOMContentLoaded", init);