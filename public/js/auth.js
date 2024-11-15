import { JWT_ACCESS_TOKEN, JWT_REFRESH_TOKEN } from "./services/auth.js";
import overlayService from "./services/overlay.js";
import toastService from "./services/toast.js";
export class Auth {
    constructor() {
        this.overlayService = overlayService;
        this.toastService = toastService;
        this.reg$ = document.createElement("div");
        this.auth$ = document.createElement("div");
        this.renew$ = document.createElement("div");
        this.close$ = document.createElement("div");
        this.loaded = false;
        this.element = this._createElement();
        this.userMail = this.element.querySelector('#user-mail-input');
        this.userPassword = this.element.querySelector("#user-password-input");
    }

    _createElement() {
        const template = `
          <div class="auth-container">
            <div class="auth__header-wrapper">
              <div class="auth__header">
                ავტორიზაცია 
                <i class="material-symbols-outlined" style="display:none;">maximize</i>
                <button class="button button-icon" id="auth__close-button">
                  <i class="material-symbols-outlined">close</i>
                </button>
              </div>
            </div>
            <div class="auth__body">
               <div class="toaster slide-down">
                 
               </div>
               <div class="form">
                 <div class="auth-input-wrapper">
                   <label for="user-mail" class="input-label">მომხმარებელი</label>
                   <div class="input-wrapper">
                     <input type="text" id="user-mail-input" class="auth-input">
                     <div class="input-group-append">
                       <i class="material-symbols-outlined">person</i>
                     </div>
                   </div>
                 </div>
                 <div class="auth-input-wrapper">
                   <label for="user-mail" class="input-label">პაროლი</label>
                   <div class="input-wrapper">
                     <input type="password" id="user-password-input" class="auth-input">
                     <div class="input-group-append">
                       <i class="material-symbols-outlined">lock</i>
                     </div>
                   </div>
                 </div>
                 <div class="auth__renew-suggest">
                   დაგავიწყდა პაროლი?
                 </div>
                 <button class="button button-success" id="auth__authorization-button">
                    ავტორიზაცია
                 </button>
                 <button class="button button-light" id="auth__register-button">
                   რეგისტრაცია
                 </button>
               </div>
            </div>
          </div>
        `

        const tempContainer = document.createElement("div");
        tempContainer.innerHTML = template;
        return tempContainer.firstElementChild;
    }

    listeners() {
      this.closeButton = document.querySelector("#auth__close-button");
      console.log(this.closeButton);
      this.authButton = document.querySelector("#auth__authorization-button");
      this.regButton = document.querySelector("#auth__register-button");
      this.closeButton.addEventListener("click", () => {
        this.close$.dispatchEvent(new CustomEvent("closed"));
      })
      this.authButton.addEventListener("click", () => {
        const userObject = {email:this.userMail.value, password:this.userPassword.value};
        this.userAuth(userObject);
        //this.auth$.dispatchEvent(new CustomEvent("auth", {detail:userObject}));
      })
      this.regButton.addEventListener("click", () => {
        this.reg$.dispatchEvent(new CustomEvent("reg"));
      })
    }

    detach() {
        //detach logic
    }

    userAuth(userObject) {
      this.overlayService.openGlobalSpinner();
      fetch("http://localhost/vgparts/api/user/login", {
        method:"POST",
        headers: {
          'Content-Type':'application/json'
        },
        body: JSON.stringify(userObject)
      })
      .then(res => res.json())
      .then(data => {
        //localStorage.setItem(JWT_ACCESS_TOKEN, x.accessToken);
        //localStorage.setItem(JWT_REFRESH_TOKEN, x.refreshToken);
        this.overlayService.closeGlobalSpinner();
        this.toastService.createSuccessToast('თქვენ წარმატებით გაიარეთ აუტორიზაცია');
        this.close$.dispatchEvent(new CustomEvent("closed"));
      }, e => {
        this.overlayService.closeGlobalSpinner();
        this.toastService.createDangerToast('მომხმარებლის მეილი ან პაროლი არასწორია');
      });
    }
}