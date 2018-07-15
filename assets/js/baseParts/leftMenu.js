import constants from '../constants.js';

class LeftMenu {
    constructor() {
        this.leftMenu = document.getElementById('left-menu');
        this.leftMenuToggle = document.getElementById('left-menu-toggle');
        if(this.leftMenu && this.leftMenuToggle) {
            this.bpMediumWatch = window.matchMedia(`(max-width: ${constants.breakpoints.medium.max}px)`);
            this.leftMenuToggleText = this.leftMenuToggle.querySelector('.text');
            this.leftMenuOverlay = this.leftMenu.querySelector('.overlay');

            this.onCrossMediumBreakpoint();
            this.bpMediumWatch.addListener(this.onCrossMediumBreakpoint.bind(this));
            document.addEventListener('DOMContentLoaded', this.onDocumentReady.bind(this));
            this.leftMenu.querySelector('.bg').addEventListener('transitionend', () => {
                if(!this.leftMenu.classList.contains('open')) this.leftMenu.classList.add('transparent');
            });
        }
    }
    open(withoutAnimation = false) {
        if(!this.leftMenu || !this.leftMenuToggle) return;
        if(typeof(withoutAnimation) !== "boolean") withoutAnimation = false;

        if(withoutAnimation) { this.leftMenu.classList.add('no-anim'); this.leftMenuToggle.classList.add('no-anim'); }

        this.leftMenu.classList.remove('transparent');
        this.leftMenu.classList.add('open');
        this.leftMenuToggle.classList.add('open');
        if(this.bpMediumWatch.matches) document.body.style.setProperty('overflow-y', 'hidden');
        this.leftMenuToggle.title = this.leftMenuToggle.dataset.closeText;
        if(this.leftMenuToggleText) {
            if(withoutAnimation) this.leftMenuToggleText.textContent = this.leftMenuToggle.dataset.closeText;
            else {
                this.leftMenuToggleText.style.setProperty('opacity', 0);
                setTimeout(() => {
                        this.leftMenuToggleText.textContent = this.leftMenuToggle.dataset.closeText;
                        this.leftMenuToggleText.style.removeProperty('opacity')
                    },
                    (constants.baseDuration * 1000) / 2
                );
            }
        }
        void this.leftMenu.offsetWidth;

        if(withoutAnimation) setTimeout(() => { this.leftMenu.classList.remove('no-anim'); this.leftMenuToggle.classList.remove('no-anim'); } );
    }
    close(withoutAnimation = false) {
        if(!this.leftMenu || !this.leftMenuToggle) return;
        if(typeof(withoutAnimation) !== "boolean") withoutAnimation = false;

        if(withoutAnimation) {
            this.leftMenu.classList.add('no-anim');
            //this.leftMenu.classList.add('transparent');
            this.leftMenuToggle.classList.add('no-anim');
            document.getElementById('main-content').style.transition = 'none';
        }
        this.leftMenu.classList.remove('open');
        this.leftMenuToggle.classList.remove('open');
        document.body.style.removeProperty('overflow-y');
        this.leftMenuToggle.title = this.leftMenuToggle.dataset.openText;
        if(this.leftMenuToggleText) {
            if(withoutAnimation) this.leftMenuToggleText.textContent = this.leftMenuToggle.dataset.openText;
            else {
                this.leftMenuToggleText.style.setProperty('opacity', 0);
                setTimeout(() => {
                        this.leftMenuToggleText.textContent = this.leftMenuToggle.dataset.openText;
                        this.leftMenuToggleText.style.removeProperty('opacity')
                    },
                    (constants.baseDuration * 1000) / 2
                );
            }
        }
        void this.leftMenu.offsetWidth;

        if(withoutAnimation) setTimeout(() => { this.leftMenu.classList.remove('no-anim'); this.leftMenuToggle.classList.remove('no-anim'); } );
    }
    onCrossMediumBreakpoint() {
        if (this.bpMediumWatch.matches) { // is tablet or smaller
            this.close(true);
        } else { // is desktop
            this.open(true);
        }
    }
    onDocumentReady() {
        if(!this.leftMenu) this.leftMenu= document.getElementById('left-menu');
        if(!this.leftMenuToggle) this.leftMenuToggle = document.getElementById('left-menu-toggle');
        if(!this.leftMenuToggleText) this.leftMenuToggleText = this.leftMenuToggle.querySelector('.text');
        if(!this.leftMenuOverlay) this.leftMenuOverlay = this.leftMenu.querySelector('.overlay');

        if(this.leftMenu && this.leftMenuToggle) {
            this.leftMenuToggle.addEventListener('click', () => {
                if (this.leftMenu.classList.contains('open')) {
                    this.close();
                } else {
                    this.open();
                }
            });

            if(this.leftMenuOverlay) {
                document.querySelectorAll('.close-left-menu').forEach((el) => {
                    el.addEventListener('click', this.close.bind(this));
                });
            }
        }
    }
}

export default new LeftMenu();