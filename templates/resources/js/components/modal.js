document.addEventListener('DOMContentLoaded', () => {
  class Modal {
    constructor() {
      this.bodyScrollLock = false;
      this.init();
    }

    init() {
      this.initModalTriggers();
      this.initModalClosers();
    }

    // Lock/unlock body scroll
    toggleBodyScroll(lock) {
      document.body.style.overflow = lock ? 'hidden' : '';
      this.bodyScrollLock = lock;
    }

    // Show modal
    showModal(modal, trigger) {
      if (!modal) return;
      modal.classList.add('active');
      this.toggleBodyScroll(true);
      this.dispatchModalEvent('modalOpen', modal, trigger);
    }

    // Hide modal
    hideModal(modal, trigger) {
      if (!modal) return;
      modal.classList.remove('active');
      this.toggleBodyScroll(false);
      this.dispatchModalEvent('modalClose', modal, trigger);
    }

    // Custom event dispatcher
    dispatchModalEvent(eventName, modal, trigger = null) {
      const event = new CustomEvent(eventName, {
        detail: {
          modal,
          trigger,
        },
      });
      document.dispatchEvent(event);
    }

    // Initialize modal triggers
    initModalTriggers() {
      document.addEventListener('click', (e) => {
        const trigger = e.target.closest('.modal__show');
        if (!trigger) return;

        e.preventDefault();
        const modalId = trigger.getAttribute('data-modal');
        const modal = document.querySelector(`.modal_${modalId}`);

        this.showModal(modal, trigger);
      });
    }

    // Инициализация закрывающих элементов через делегирование
    initModalClosers() {
      document.addEventListener('click', (e) => {
        // Кнопка закрытия внутри модального окна
        const closeBtn = e.target.closest('.modal__close');
        if (closeBtn) {
          const modal = closeBtn.closest('.modal');
          this.hideModal(modal, closeBtn);
          const dataRemove = modal.dataset.remove;
          if (dataRemove === 'true') {
            setTimeout(() => {
              modal.remove();
            }, 100);
          }
          return;
        }

        // Кнопка «назад» внутри модального окна
        const backBtn = e.target.closest('.modal__back');
        if (backBtn) {
          const modal = backBtn.closest('.modal');
          this.hideModal(modal, backBtn);
          const dataRemove = modal.dataset.remove;
          if (dataRemove === 'true') {
            setTimeout(() => {
              modal.remove();
            }, 100);
          }
          return;
        }

        // Нажатие вне содержимого модального окна
        const clickedOverlay = e.target.closest('.modal__ceil');
        if (clickedOverlay && e.target === clickedOverlay) {
          const modal = clickedOverlay.closest('.modal');
          this.hideModal(modal, clickedOverlay);
          const dataRemove = modal.dataset.remove;
          if (dataRemove === 'true') {
            setTimeout(() => {
              modal.remove();
            }, 100);
          }
          return;
        }
      });
    }
  }

  // Initialize modal functionality
  const modal = new Modal();
  window.Modal = modal;
});
