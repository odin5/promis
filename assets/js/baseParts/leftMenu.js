import constants from '../config.js';

class LeftMenu {
  constructor() {
    this.M_sidenav_options = {
      inDuration: constants.baseDuration * 1000,
      outDuration: constants.baseDuration * 1000
    };
    this.M_sidenav = null;
    this.enabled = false;
    this.leftMenu = document.getElementById('left-menu');
    this.leftMenuToggle = document.getElementById('left-menu-toggle');
    if(this.leftMenu && this.leftMenuToggle) {
      this.bpMediumWatch = window.matchMedia(`(max-width: ${constants.breakpoints.medium.max}px)`);
      this.leftMenuToggleText = this.leftMenuToggle.querySelector('.text');

      this.onCrossMediumBreakpoint();
      this.bpMediumWatch.addListener(this.onCrossMediumBreakpoint.bind(this));
      document.addEventListener('DOMContentLoaded', this.onDocumentReady.bind(this));
      this.leftMenu.querySelector('.sidenav').addEventListener('transitionend', () => {
        if(!this.leftMenu.classList.contains('open') && !this.M_sidenav) this.leftMenu.classList.add('transparent');
      });
    }
  }
  open(withoutAnimation = false) {
    if(!this.leftMenu || !this.leftMenuToggle || !this.enabled) return;
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
    if(!this.leftMenu || !this.leftMenuToggle || !this.enabled) return;
    if(typeof(withoutAnimation) !== "boolean") withoutAnimation = false;

    if(withoutAnimation) {
      this.leftMenu.classList.add('no-anim');
      //this.leftMenu.classList.add('transparent');
      this.leftMenuToggle.classList.add('no-anim');
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
      this.enabled = false;
      this.leftMenuToggle.classList.add('sidenav-trigger');
      if(!this.M_sidenav) this.M_sidenav = M.Sidenav.init(this.leftMenu.querySelector('.sidenav'), this.M_sidenav_options);
    } else { // is desktop
      if(this.M_sidenav) {
        this.M_sidenav.destroy();
        this.M_sidenav = null;
      }
      this.leftMenuToggle.classList.remove('sidenav-trigger');
      this.enabled = true;
      if(!this.leftMenu.classList.contains('closed-on-load')) {
        this.open(true);
      } else {
        this.close(true);
      }
    }
  }
  onDocumentReady() {
    if(!this.leftMenu) this.leftMenu = document.getElementById('left-menu');
    if(!this.leftMenuToggle) this.leftMenuToggle = document.getElementById('left-menu-toggle');
    if(!this.leftMenuToggleText) this.leftMenuToggleText = this.leftMenuToggle.querySelector('.text');

    if(this.leftMenu && this.leftMenuToggle) {
      this.onCrossMediumBreakpoint();

      this.leftMenuToggle.addEventListener('click', () => {
        if (!this.bpMediumWatch.matches || this.enabled) {
          if (this.leftMenu.classList.contains('open')) {
            this.close();
          } else {
            this.open();
          }
        }
      });

      (document.querySelectorAll('.close-left-menu')||[]).forEach((el) => {
        el.addEventListener('click', () => {
          if (this.bpMediumWatch.matches || !this.enabled) { // is tablet or smaller
            if (this.M_sidenav) this.M_sidenav.close();
          } else {
            this.close();
          }
        });
      });
    }
  }
}

export default new LeftMenu();