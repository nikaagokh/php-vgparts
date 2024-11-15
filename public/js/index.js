import { Header } from "./header.js";
import { Home } from "./home.js";

async function init() {
    new Header();
    new Home();
    /*
    const iframe = document.querySelector("#myframe");
    document.querySelector("#framebutton").addEventListener("click", () => {
        //const popup = window.open('http://127.0.0.1:5500/index.html');
        //iframe.contentWindow.postMessage('hi', window.location.origin);
        const iframe = document.getElementById("myframe");
        const random = Math.random();
        iframe.contentWindow.postMessage(random, "*");
        console.log(iframe.contentWindow)
    })

   window.addEventListener("message", function (event) {
     console.log(event);
    })
*/
}
window.addEventListener("DOMContentLoaded", init);