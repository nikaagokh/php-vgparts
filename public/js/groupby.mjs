import { Header } from "./header.js";
import { GroupBy } from "./groupby.js";

function init() {
    new Header();
    new GroupBy();
}
window.addEventListener("DOMContentLoaded", init);