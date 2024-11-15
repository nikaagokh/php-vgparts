import overlayService from "./services/overlay.js";
import authService from "./services/auth.js";
export class Register {
    constructor() {
        this.authService = authService;
        this.overlayService = overlayService;
        this.close$ = document.createElement("div");
        this.submit$ = document.createElement("div");
        this.loaded = false;
        this.element = this._createElement();
        this.errorMessage = this.element.querySelector(".error-message");
        this.validatePasswords = this.validatePasswords.bind(this);
        this.formGroup = {
          firstName:this.element.querySelector("#user-fname-input"),
          lastName:this.element.querySelector("#user-lname-input"),
          email:this.element.querySelector("#user-mail-input"),
          password:this.element.querySelector("#user-pass-input"),
          repassword:this.element.querySelector("#user-repass-input"),
        }

        this.formGroup.repassword.addEventListener("input", this.validatePasswords);
    }
    
    _createElement() {
        const template = `
        <div class="auth-container">
        <div class="auth__header-wrapper">
          <div class="auth__header">
            რეგისტრაცია 
            <i class="material-symbols-outlined" style="display:none;">maximize</i>
            <button class="button button-icon" id="register__close-button">
              <i class="material-symbols-outlined">close</i>
            </button>
          </div>
        </div>
        <div class="auth__body">
           <div class="toaster slide-down">
             
           </div>
           <div class="form">
             <div class="auth-input-wrapper">
               <label for="user-mail" class="input-label">სახელი</label>
               <div class="input-wrapper">
                 <input type="text" id="user-fname-input" class="auth-input" autocomplete="off">
                 <div class="input-group-append">
                   <i class="material-symbols-outlined">person</i>
                 </div>
               </div>
             </div>
             <div class="auth-input-wrapper">
               <label for="user-mail" class="input-label">გვარი</label>
               <div class="input-wrapper">
                 <input type="text" id="user-lname-input" class="auth-input" autocomplete="off">
                 <div class="input-group-append">
                   <i class="material-symbols-outlined">person</i>
                 </div>
               </div>
             </div>
             <div class="auth-input-wrapper">
               <label for="user-mail" class="input-label">მეილი</label>
               <div class="input-wrapper">
                 <input type="text" id="user-mail-input" class="auth-input">
                 <div class="input-group-append">
                   <i class="material-symbols-outlined">email</i>
                 </div>
               </div>
             </div>
             <div class="auth-input-wrapper">
               <label for="user-mail" class="input-label">პაროლი</label>
               <div class="input-wrapper">
                 <input type="password" id="user-pass-input" class="auth-input" autocomplete="off">
                 <div class="input-group-append">
                   <i class="material-symbols-outlined">lock</i>
                 </div>
               </div>
             </div>
             <div class="auth-input-wrapper">
               <label for="user-mail" class="input-label">გაიმეორეთ პაროლი</label>
               <div class="input-wrapper">
                 <input type="password" id="user-repass-input" class="auth-input" autocomplete="off">
                 <div class="input-group-append">
                   <i class="material-symbols-outlined">lock</i>
                 </div>
               </div>
             </div>
             <div class="error-message" style="display:none;">*პაროლები ერთმანეთს არ ემთხვევა</div>
             <button class="button button-success" id="register__register-button">
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
        this.closeButton = document.querySelector("#register__close-button");
        this.registerButton = document.querySelector("#register__register-button");
        this.closeButton.addEventListener("click", () => {
            this.close$.dispatchEvent(new CustomEvent("closed"));
        })
        this.registerButton.addEventListener("click", () => {
            let registerUser = {};
            for (const key in this.formGroup) {
              if (Object.hasOwnProperty.call(this.formGroup, key) && key !== 'repassword') {
                  const input = this.formGroup[key];
                  registerUser[key] = input.value;
              }
            }
            if(!this.error) {
              this.overlayService.openGlobalSpinner();
              this.authService.register(registerUser).then(_ => {
                this.overlayService.closeGlobalSpinner();
                this.submit$.dispatchEvent(new CustomEvent("submited"));
              }).catch(_ => {
                this.overlayService.closeGlobalSpinner();
              })
            }
        })
    }

    validatePasswords() {
      let password = this.formGroup.password.value;
      let repassword = this.formGroup.repassword.value;
      console.log(password)
      console.log(repassword)
      if(password === repassword) {
        this.errorMessage.style.display = 'none';
        this.error = false;
      } else {
        console.log('!=')
        this.errorMessage.style.display = 'block';
        this.error = true;
      }
    }

    detach() {

    }
}