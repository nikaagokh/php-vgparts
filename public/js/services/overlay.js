import { Auth } from "../auth.js";
import { Filtera } from "../filtera.js";
import { enableScroll } from "../../utils/enableScroll.js";
import { disableScroll } from "../../utils/disableScroll.js";
import { Register } from "../register.js";
import { Verify } from "../verify.js";
import { ImageZoom } from "../imagezoom.js";
import toastService from "./toast.js";
import { MenuMob } from "../menumob.js";
import { SubmenuMob } from "../submenumob.js";
class OverlayService {
    constructor() {
        this.toastService = toastService;
        this.spinner = null;
        this.globalSpinnerWrapper = null;
        this.globalSpinnerBackdrop = null;
        this.menuRef = null;
        this.submenuRef = null;
        this.searchMobile = null;
        this.overlayContainer = document.querySelector(".overlay-container");
        this.spinnerTemplate = `<svg class="spinner" width="35px" height="35px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                                   <circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>
                                </svg>`;
        this.mobsize = !window.matchMedia("(min-width:992px)").matches;
        window.matchMedia("(min-width:992px)").addEventListener("change", (mq) => {
            if(mq.matches) {
                this.mobsize = false;
            } else {
                this.mobsize = true;
            }
        })
    }

    openGlobalSpinner() {
        if(!this.globalSpinnerBackdrop && !this.globalSpinnerWrapper) {
            this.globalSpinnerWrapper = document.createElement("div");
            const spinnerWrapper = document.createElement("div");
            spinnerWrapper.classList.add("spinner-wrapper")
            this.globalSpinnerWrapper.classList.add("overlay-wrapper");
            this.globalSpinnerWrapper.classList.add("overlay-wrapper-dialog")
            this.globalSpinnerBackdrop = document.createElement("div");
            this.globalSpinnerBackdrop.classList.add("dialog-backdrop");
            spinnerWrapper.innerHTML = this.spinnerTemplate;
            this.globalSpinnerWrapper.appendChild(spinnerWrapper);

            this.globalSpinnerBackdrop.addEventListener("click", () => {
                this.overlayContainer.removeChild(this.globalSpinnerBackdrop);
                this.overlayContainer.removeChild(this.globalSpinnerWrapper);
                this.globalSpinnerBackdrop = null;
                this.globalSpinnerWrapper = null;
            })
            this.overlayContainer.appendChild(this.globalSpinnerWrapper);
            this.overlayContainer.appendChild(this.globalSpinnerBackdrop);


        }
    }

    closeGlobalSpinner() {
        if(this.globalSpinnerWrapper && this.globalSpinnerBackdrop) {
            this.overlayContainer.removeChild(this.globalSpinnerBackdrop);
            this.overlayContainer.removeChild(this.globalSpinnerWrapper);
            this.globalSpinnerBackdrop = null;
            this.globalSpinnerWrapper = null;
        }
    }

    openSpinner(parent) {
        if(!this.spinner) {
            this.spinner = new Loader();
            this.spinnerparent = parent;
            this.spinnerparent.appendChild(this.spinner.element);
        }
    }

    closeSpinner() {
        if(this.spinner) {
            this.spinnerparent.removeChild(this.spinner.element);
            this.spinner = null;
            this.spinnerparent = null;
        }
    }

    createDialog() {
        const globalWrapper = document.createElement("div");
        globalWrapper.classList.add("overlay-wrapper");
        globalWrapper.classList.add("overlay-wrapper-dialog");
        const dialogBackdrop = document.createElement("div");
        dialogBackdrop.classList.add("dialog-backdrop");
        const dialogComponent = document.createElement("div"); 
        return {globalWrapper, dialogBackdrop, dialogComponent};
    }

    openFilter() {
        
        const {globalWrapper, dialogBackdrop, dialogComponent} = this.createDialog();
        const filter = new Filtera();
        dialogComponent.appendChild(filter.element);
        dialogComponent.classList.add("overlay-pane");
        dialogComponent.classList.add("dialog-size");
        globalWrapper.appendChild(dialogComponent)
        disableScroll();
        this.overlayContainer.appendChild(globalWrapper);
        this.overlayContainer.appendChild(dialogBackdrop);
        //filter.listeners();
        dialogBackdrop.addEventListener("click", () => {
            filter.detach();
            globalWrapper.remove();
            dialogBackdrop.remove();
            enableScroll()
        })
        filter.close$.addEventListener("closed", () => {
            filter.detach();
            globalWrapper.remove();
            dialogBackdrop.remove();
            enableScroll()
        })
    }

    openAuth() {
        const {globalWrapper:authGlobalWrapper, dialogBackdrop:authDialogBackdrop, dialogComponent:authDialogComponent} = this.createDialog();
        const auth = new Auth();
        authDialogComponent.appendChild(auth.element);
        authDialogComponent.classList.add("overlay-pane");
        authDialogComponent.classList.add("dialog-size");
        authGlobalWrapper.appendChild(authDialogComponent)
        disableScroll();
        this.overlayContainer.appendChild(authGlobalWrapper);
        this.overlayContainer.appendChild(authDialogBackdrop);
        auth.listeners();
        authDialogBackdrop.addEventListener("click", () => {
            auth.detach();
            authGlobalWrapper.remove();
            authDialogBackdrop.remove();
            enableScroll()
        })

        auth.close$.addEventListener("closed", () => {
            auth.detach();
            authGlobalWrapper.remove();
            authDialogBackdrop.remove();
            enableScroll()
        })

        auth.reg$.addEventListener("reg", () => {
            const {globalWrapper:regGlobalWrapper, dialogBackdrop:regDialogBackdrop, dialogComponent:regDialogComponent} = this.createDialog();
            const reg = new Register();
            regDialogComponent.appendChild(reg.element);
            regDialogComponent.classList.add("overlay-pane");
            regDialogComponent.classList.add("dialog-size");
            regGlobalWrapper.appendChild(regDialogComponent);
            this.overlayContainer.appendChild(regGlobalWrapper);
            this.overlayContainer.appendChild(regDialogBackdrop);
            reg.listeners();
            regDialogBackdrop.addEventListener("click", () => {
                reg.detach();
                this.overlayContainer.innerHTML = '';
                enableScroll();
            })
            reg.close$.addEventListener("closed", () => {
                reg.detach();
                regGlobalWrapper.remove();
                regDialogBackdrop.remove();
            })
            reg.submit$.addEventListener("submited", () => {
                reg.detach();
                auth.detach();
                regGlobalWrapper.remove();
                regDialogBackdrop.remove();
                authDialogBackdrop.remove();
                authGlobalWrapper.remove();
                
                const {globalWrapper:verifyGlobalWrapper, dialogBackdrop:verifyDialogBackdrop, dialogComponent:verifyDialogComponent} = this.createDialog();
                const verify = new Verify();
                verifyDialogComponent.appendChild(verify.element);
                verifyDialogComponent.classList.add("overlay-pane");
                verifyDialogComponent.classList.add("dialog-size");
                verifyGlobalWrapper.appendChild(verifyDialogComponent);
                this.overlayContainer.appendChild(verifyGlobalWrapper);
                this.overlayContainer.appendChild(verifyDialogBackdrop);
                verifyDialogBackdrop.addEventListener("click", () => {
                    verify.detach();
                    verifyGlobalWrapper.remove();
                    verifyDialogBackdrop.remove();
                    enableScroll();
                })

                verify.close$.addEventListener("closed", () => {
                    verify.detach();
                    verifyGlobalWrapper.remove();
                    verifyDialogBackdrop.remove();
                    enableScroll();
                })

                verify.verify$.addEventListener("verified", () => {
                    this.toastService.createSuccessToast("თქვენ წარმატებით გაიარეთ რეგისტრაცია");
                    verify.detach();
                    verifyGlobalWrapper.remove();
                    verifyDialogBackdrop.remove();
                    enableScroll();
                })
            })
            
        })
    }

    openZoom(image) {
        const {globalWrapper, dialogBackdrop, dialogComponent} = this.createDialog();
        const zoom = new ImageZoom(image);
        dialogComponent.appendChild(zoom.element);
        dialogComponent.classList.add("overlay-pane");
        dialogComponent.classList.add("dialog-size");
        globalWrapper.appendChild(dialogComponent);
        this.overlayContainer.appendChild(globalWrapper);
        this.overlayContainer.appendChild(dialogBackdrop);
        disableScroll();
        dialogBackdrop.addEventListener("click", () => {
            zoom.detach();
            globalWrapper.remove();
            dialogBackdrop.remove();
            enableScroll();
        })

        zoom.close$.addEventListener("closed", () => {
            zoom.detach();
            globalWrapper.remove();
            dialogBackdrop.remove();
            enableScroll();
        })
    }

    clearOverlay() {
        while(this.overlayContainer.firstChild) {
            this.overlayContainer.removeChild(this.overlayContainer.firstChild)
        }
    }
    async openMenu() {
        console.log(3);
        if(this.mobsize) {
            if(!this.menuRef) {
                try {
                    const {globalWrapper, overlayBackDrop} = this.createSideOverlay();
                    const response = await fetch("https://vgpart-production.up.railway.app/api/categories/full");
                    if(!response.ok) {
                        throw new Error("errr");
                    }
                    const fullCategories = await response.json();
                    this.menuRef = new MenuMob(fullCategories);
                    globalWrapper.appendChild(this.menuRef.element);
                    this.overlayContainer.appendChild(overlayBackDrop);
                    this.overlayContainer.appendChild(globalWrapper);
                    disableScroll();
                    overlayBackDrop.addEventListener("click", () => {
                        this.menuRef = null;
                        globalWrapper.classList.add("slide-out");
                        setTimeout(() => {
                            globalWrapper.remove()
                            overlayBackDrop.remove();
                            enableScroll();
                        }, 200);
                    })
    
                    this.menuRef.notifier.addEventListener("closed", () => {
                        this.menuRef = null;
                        globalWrapper.classList.add("slide-out");
                        bottomBackdrop.remove();
                        setTimeout(() => {
                            globalWrapper.remove()
                            overlayBackDrop.remove();
                            enableScroll();
                        }, 200);
                    })
    
                    this.menuRef.selected.addEventListener("selected", (ev) => {
                        console.log(123);
                        console.log(this.submenuRef)
                        if(!this.submenuRef) {
                            console.log(ev)
                            const {globalWrapper:submenuWrapper, overlayBackDrop:submenuBackdrop} = this.createSideOverlay();
                            this.submenuRef = new SubmenuMob(fullCategories[ev.detail].subcategories);
                            submenuWrapper.appendChild(this.submenuRef.element);
                            submenuBackdrop.classList.add("transparent-backdrop")
                            this.overlayContainer.appendChild(submenuBackdrop);
                            this.overlayContainer.appendChild(submenuWrapper);
                            submenuBackdrop.addEventListener("click", () => {
                                overlayBackDrop.remove();
                                globalWrapper.remove();
                                submenuBackdrop.remove();
                                submenuWrapper.remove();
                                this.menuRef = null;
                                this.submenuRef = null;
                                enableScroll();
                            })
                            this.submenuRef.selected.addEventListener("selected", () => {
                                
                                this.menuRef = null;
                                this.submenuRef = null;
                            })
                            this.submenuRef.closed.addEventListener("closed", () => {
                                submenuBackdrop.remove();
                                submenuWrapper.remove();
                                this.submenuRef = null;
                            })
                        }
                    })
                    
                } catch(err) {
                    console.log(err);
                }
            } else {
                this.menuRef.detach();
                this.menuRef = null;
            }
        } else {
            if(!this.menuRef) {
                try {
                    const response = await fetch("https://vgpart-production.up.railway.app/api/categories/full");
                    if(!response.ok) {
                        throw new Error("errr");
                    }
                    const fullCategories = await response.json();
                    new MenuDesktop(fullCategories);
                    
                } catch(err) {
                    console.log(err);
                }
            }
        }
    }

    createSideOverlay() {
        const globalWrapper = document.createElement("div");
        globalWrapper.classList.add("overlay-container__menu-mobile-panel");
        const randId = Math.floor(Math.random() * 900) + 100;
        globalWrapper.id = `overlay-pane-${randId}`;
        const overlayBackDrop = document.createElement("div");
        overlayBackDrop.classList.add("overlay-container__menu-mobile-backdrop");
        return {globalWrapper, overlayBackDrop};
    }

}

const overlayService = new OverlayService();
export default overlayService;