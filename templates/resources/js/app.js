import.meta.glob(['../images/**', '../fonts/**']);

import './components/modal';

document.addEventListener('DOMContentLoaded', () => {
  // Phone number formatting functionality
  const phoneInputs = document.querySelectorAll('input[type="tel"]');

  if (phoneInputs.length > 0) {
    const formatPhoneNumber = (value) => {
      if (!value) return '';

      // Оставляем только цифры
      let digits = value.replace(/\D/g, '');

      // Обработка первой цифры (8-ку меняем на 7, если это начало)
      if (digits.startsWith('8')) {
        digits = '7' + digits.substring(1);
      } else if (digits.length > 0 && !digits.startsWith('7')) {
        digits = '7' + digits;
      }

      digits = digits.substring(0, 11); // Ограничение 11 цифр

      let formatted = '+7';
      if (digits.length > 1) formatted += ' (' + digits.substring(1, 4);
      if (digits.length >= 5) formatted += ') ' + digits.substring(4, 7);
      if (digits.length >= 8) formatted += '-' + digits.substring(7, 9);
      if (digits.length >= 10) formatted += '-' + digits.substring(9, 11);

      return formatted;
    };

    phoneInputs.forEach((input) => {
      input.addEventListener('input', function (e) {
        const selectionStart = this.selectionStart;
        const oldLength = this.value.length;

        // Если пользователь пытается стереть всё, оставляем пустое поле или +7
        if (!e.target.value || e.target.value.length < 3) {
          e.target.value = '+7';
          return;
        }

        const formatted = formatPhoneNumber(e.target.value);
        e.target.value = formatted;

        // Восстанавливаем положение курсора
        const newLength = formatted.length;
        const pos = selectionStart + (newLength - oldLength);
        this.setSelectionRange(pos, pos);
      });

      // Обработка удаления (чтобы нельзя было стереть +7)
      input.addEventListener('keydown', function (e) {
        if (e.key === 'Backspace' && this.value.length <= 2) {
          e.preventDefault();
        }
      });

      // При фокусе, если пусто, подставляем +7
      input.addEventListener('focus', function () {
        if (!this.value) {
          this.value = '+7';
        }
      });
    });
  }

  document.addEventListener(
    'wpcf7invalid',
    function (event) {
      const invalidFields = event.detail.apiResponse.invalid_fields;
      const form = event.srcElement;
      if (invalidFields[0]) {
        invalidFields.forEach((invalidField) => {
          const input = document.querySelector(
            `input[name="${invalidField.field}"]`,
          );

          if (!input.dataset.originalPlaceholder) {
            input.dataset.originalPlaceholder = input.placeholder || '';
          }

          input.placeholder = invalidField.message;

          input.addEventListener(
            'input',
            function () {
              // 1. Убираем красную обводку (удаляем класс ошибки CF7)
              const wrapper = input.closest('.wpcf7-form-control-wrap');
              if (wrapper) {
                wrapper.classList.remove('wpcf7-not-valid');
                // Удаляем стандартный текстовый блок ошибки под полем, если он есть
                const errorMsg = wrapper.querySelector('.wpcf7-not-valid-tip');
                if (errorMsg) errorMsg.remove();
              }

              input.classList.remove('wpcf7-not-valid');

              // 2. Возвращаем исходный плейсхолдер
              if (input.dataset.originalPlaceholder !== undefined) {
                input.placeholder = input.dataset.originalPlaceholder;
              }
            },
            {once: true},
          );
        });
      }
    },
    false,
  );

  document.addEventListener(
    'wpcf7mailfailed',
    function (event) {
      console.group('!!! CF7 Mail Failed !!!');
      console.warn('ID формы:', event.detail.contactFormId);
      console.error('Статус ответа:', event.detail.apiResponse.status);
      console.log('Сообщение от сервера:', event.detail.apiResponse.message);

      // Если сервер вернул детальные ошибки
      if (event.detail.apiResponse.invalid_fields) {
        console.table(event.detail.apiResponse.invalid_fields);
      }

      // Полный объект ответа для изучения
      console.log('Полный объект события:', event);
      console.groupEnd();
    },
    false,
  );

  document.addEventListener(
    'wpcf7mailsent',
    function (event) {
      if (event.detail.apiResponse.contact_form_id === 5) {
        Modal.showModal(document.querySelector('.modal_exit'));
      }

      if (event.detail.apiResponse.contact_form_id === 394) {
        Modal.showModal(document.querySelector('.modal_faqs'));
      }

      if (event.detail.apiResponse.contact_form_id === 406) {
        Modal.hideModal(document.querySelector('.modal_cons'));
        Modal.showModal(document.querySelector('.modal_cons-message'));
      }

      if (event.detail.apiResponse.contact_form_id === 407) {
        Modal.hideModal(document.querySelector('.modal_outlay'));
        Modal.showModal(document.querySelector('.modal_outlay-message'));
      }

      if (event.detail.apiResponse.contact_form_id === 411) {
        Modal.hideModal(document.querySelector('.modal_calculator'));
        Modal.showModal(document.querySelector('.modal_cons-message'));
      }

      if (event.detail.apiResponse.contact_form_id === 410) {
        Modal.hideModal(document.querySelector('.modal_know-price'));
        Modal.showModal(document.querySelector('.modal_cons-message'));
      }
    },
    false,
  );

  const pSelects = document.querySelectorAll('.p-select');

  if (pSelects[0]) {
    // Close all selects except the provided one
    const closeAllSelects = (exceptSelect = null) => {
      pSelects.forEach((select) => {
        if (select !== exceptSelect) {
          select.classList.remove('active');
        }
      });
    };

    // Handle click outside to close all selects
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.p-select')) {
        closeAllSelects();
      }
    });

    pSelects.forEach((select) => {
      const current = select.querySelector('.p-select__current');
      const options = select.querySelector('.p-select__options');
      const optionsList = select.querySelectorAll('.p-select__option');

      // Handle click on current element to toggle dropdown
      current.addEventListener('click', (e) => {
        e.stopPropagation();

        // Close all other selects first
        closeAllSelects(select);

        // Toggle current select
        select.classList.toggle('active');
      });

      // Handle option selection
      optionsList.forEach((option) => {
        const radio = option.querySelector('input[type="radio"]');
        const text = option.querySelector('.p-select__option-text');

        option.addEventListener('click', (e) => {
          e.stopPropagation();

          // Update radio button state
          radio.checked = true;

          // Update displayed text
          const title = select.querySelector('.p-select__title');
          title.textContent = text.textContent;

          // Trigger change event on radio for any listeners
          radio.dispatchEvent(new Event('change', {bubbles: true}));

          // Close the dropdown
          select.classList.remove('active');
        });
      });

      // Prevent clicks inside dropdown from closing it
      options.addEventListener('click', (e) => {
        e.stopPropagation();
      });
    });
  }

  if (document.querySelectorAll('.footer-menu-link')) {
    document.querySelectorAll('.footer-menu-link').forEach((link) => {
      const arrow = link.querySelector('.footer-menu-arrow');

      if (arrow) {
        link.addEventListener('click', function (e) {
          // ПРОВЕРКА: Работаем только если ширина экрана меньше 1024px
          if (window.innerWidth >= 1024) return;

          const menuItem = this.closest('li.menu-item');
          const subMenu = menuItem ? menuItem.querySelector('.sub-menu') : null;

          if (menuItem && subMenu) {
            const isActive = menuItem.classList.contains('active');

            // 1. Закрываем все другие открытые меню
            document
              .querySelectorAll('.menu-item.active')
              .forEach((activeItem) => {
                if (activeItem !== menuItem) {
                  activeItem.classList.remove('active');
                  const activeSub = activeItem.querySelector('.sub-menu');
                  if (activeSub) {
                    activeSub.style.height = '';
                  }
                }
              });

            // 2. Переключаем текущее меню
            if (!isActive) {
              menuItem.classList.add('active');
              subMenu.style.height = subMenu.scrollHeight + 'px';
            } else {
              menuItem.classList.remove('active');
              subMenu.style.height = '';
            }
          }

          if (this.getAttribute('href') === '#!') {
            e.preventDefault();
          }
        });
      }
    });

    // Закрытие при клике вне меню (тоже только для мобильных)
    document.addEventListener('click', function (e) {
      if (window.innerWidth < 1024 && !e.target.closest('.footer-menu-link')) {
        document.querySelectorAll('.menu-item.active').forEach((item) => {
          item.classList.remove('active');
          const sub = item.querySelector('.sub-menu');
          if (sub) {
            sub.style.height = '';
          }
        });
      }
    });

    // ДОПОЛНИТЕЛЬНО: Сброс стилей при изменении размера экрана
    // Если пользователь развернул окно шире 1024px, убираем инлайновые высоты
    window.addEventListener('resize', function () {
      if (window.innerWidth >= 1024) {
        document.querySelectorAll('.menu-item').forEach((item) => {
          item.classList.remove('active');
          const sub = item.querySelector('.sub-menu');
          if (sub) {
            sub.style.height = '';
          }
        });
      }
    });
  }

  class ResponsiveCarousel {
    constructor(containerElement, options = {}) {
      this.container = containerElement;
      this.track =
        options.trackElement || this.container.querySelector('.carousel-track');
      this.slides =
        options.slideElements ||
        this.container.querySelectorAll('.carousel-slide');

      this.prevBtn =
        options.prevBtnElement ||
        this.container.querySelector('.carousel-btn.prev');
      this.nextBtn =
        options.nextBtnElement ||
        this.container.querySelector('.carousel-btn.next');

      this.currentIndex = 0;
      this.isScrolling = false;
      this.resizeTimer = null;
      this.scrollTimer = null; // Timer for scroll throttling

      this.options = {
        activeClass: options.activeClass || 'active',
        disabledClass: options.disabledClass || 'disabled',
        breakpoint: options.breakpoint || 1700,
        scrollBehavior: options.scrollBehavior || 'smooth',
        scrollThrottle: options.scrollThrottle || 100, // Throttle time in ms
        ...options,
      };

      this.init();
    }

    init() {
      this.updateSlideWidths();
      this.bindEvents();
      this.setActiveSlide(this.currentIndex);
      this.updateButtonState();
      // Initialize scroll position tracking
      this.handleScroll();
    }

    bindEvents() {
      this.prevBtn?.addEventListener('click', () => this.prev());
      this.nextBtn?.addEventListener('click', () => this.next());

      // Добавляем обработчик скролла для отслеживания индекса
      this.track.addEventListener('scroll', () => {
        this.handleScroll();
      });

      // Добавляем debounce для ресайза
      window.addEventListener('resize', () => {
        clearTimeout(this.resizeTimer);
        this.resizeTimer = setTimeout(() => {
          this.handleResize();
        }, 150);
      });

      // Следим за окончанием CSS-транзиции
      this.slides.forEach((slide) => {
        slide.addEventListener('transitionend', () => {
          this.adjustScrollAfterTransition();
        });
      });
    }

    handleResize() {
      this.updateSlideWidths();
      this.setActiveSlide(this.currentIndex);
    }

    updateSlideWidths() {
      const width = window.innerWidth;
      this.slides.forEach((slide) =>
        slide.classList.remove(this.options.activeClass),
      );

      if (width >= this.options.breakpoint) {
        this.slides[this.currentIndex]?.classList.add(this.options.activeClass);
      }
    }

    setActiveSlide(index) {
      this.currentIndex = index;
      const width = window.innerWidth;

      // Remove active class from all slides first
      this.slides.forEach((slide) =>
        slide.classList.remove(this.options.activeClass),
      );

      // Add active class only on large screens
      if (width >= this.options.breakpoint) {
        this.slides[index]?.classList.add(this.options.activeClass);
      }

      this.scrollToSlide(index);
      this.updateButtonState();
    }

    updateButtonState() {
      const isFirst = this.currentIndex === 0;
      const isLast = this.currentIndex === this.slides.length - 1;

      if (this.prevBtn) {
        if (isFirst) {
          this.prevBtn.classList.add(this.options.disabledClass);
          this.prevBtn.setAttribute('aria-disabled', 'true');
        } else {
          this.prevBtn.classList.remove(this.options.disabledClass);
          this.prevBtn.removeAttribute('aria-disabled');
        }
      }

      if (this.nextBtn) {
        if (isLast) {
          this.nextBtn.classList.add(this.options.disabledClass);
          this.nextBtn.setAttribute('aria-disabled', 'true');
        } else {
          this.nextBtn.classList.remove(this.options.disabledClass);
          this.nextBtn.removeAttribute('aria-disabled');
        }
      }
    }

    scrollToSlide(index) {
      const slide = this.slides[index];
      if (!slide) return;

      // Рассчитываем корректную позицию для скролла
      const slideOffsetLeft = this.calculateScrollPosition(index);

      this.isScrolling = true;
      this.track.scrollTo({
        left: slideOffsetLeft,
        behavior: this.options.scrollBehavior,
      });

      setTimeout(() => {
        this.isScrolling = false;
      }, 300);
    }

    calculateScrollPosition(index) {
      const slide = this.slides[index];
      if (!slide) return 0;

      const isLargeScreen = window.innerWidth >= this.options.breakpoint;
      // Check if this slide would be active based on current screen size
      const isActiveSlide = isLargeScreen && index === this.currentIndex;

      // Базовая позиция
      let scrollPosition = slide.offsetLeft;

      // Если на большом экране и слайд активный, корректируем позицию
      if (isLargeScreen && isActiveSlide) {
        // Получаем ширину активного слайда
        const activeSlideWidth = slide.getBoundingClientRect().width;
        // Получаем ширину обычного слайда (первого неактивного)
        const normalSlide = Array.from(this.slides).find(
          (s) => !s.classList.contains(this.options.activeClass),
        );
        const normalSlideWidth = normalSlide
          ? normalSlide.getBoundingClientRect().width
          : 280;

        // Корректируем позицию, чтобы слайд был виден полностью
        const correction = (activeSlideWidth - normalSlideWidth) / 2;
        scrollPosition -= correction;

        // Не даем уйти в отрицательные значения
        scrollPosition = Math.max(0, scrollPosition);
      }

      return scrollPosition;
    }

    adjustScrollAfterTransition() {
      // Ждем немного, чтобы браузер успел применить CSS изменения
      setTimeout(() => {
        if (!this.isScrolling) {
          const currentScroll = this.track.scrollLeft;
          const correctedScroll = this.calculateScrollPosition(
            this.currentIndex,
          );

          // Если позиция отличается больше чем на 1px, корректируем
          if (Math.abs(currentScroll - correctedScroll) > 1) {
            this.track.scrollTo({
              left: correctedScroll,
              behavior: 'smooth',
            });
          }
        }
      }, 50);
    }

    handleScroll() {
      // Избегаем срабатывания во время программного скролла
      if (this.isScrolling) return;

      // Throttle scroll events
      clearTimeout(this.scrollTimer);
      this.scrollTimer = setTimeout(() => {
        // Определяем индекс слайда, который находится у левого края видимой области
        const trackScrollLeft = this.track.scrollLeft;
        const trackWidth = this.track.offsetWidth;

        let closestIndex = 0;
        let minDistance = Infinity;

        this.slides.forEach((slide, index) => {
          // Рассчитываем расстояние от левого края слайда до левого края контейнера
          const slideLeft = slide.offsetLeft - trackScrollLeft;

          // Проверяем, что слайд находится в пределах видимой области
          // и ближе всего к левому краю (но не отрицательно)
          if (
            slideLeft >= 0 &&
            slideLeft < trackWidth &&
            slideLeft < minDistance
          ) {
            minDistance = slideLeft;
            closestIndex = index;
          }
        });

        // Обновляем индекс только если он изменился
        if (this.currentIndex !== closestIndex) {
          this.currentIndex = closestIndex;
          this.updateButtonState();

          // Обновляем активный слайд в зависимости от ширины экрана
          const width = window.innerWidth;
          if (width >= this.options.breakpoint) {
            this.slides.forEach((slide) =>
              slide.classList.remove(this.options.activeClass),
            );
            this.slides[closestIndex]?.classList.add(this.options.activeClass);
          }
        }
      }, this.options.scrollThrottle);
    }

    prev() {
      if (this.currentIndex > 0) {
        this.setActiveSlide(this.currentIndex - 1);
      }
    }

    next() {
      if (this.currentIndex < this.slides.length - 1) {
        this.setActiveSlide(this.currentIndex + 1);
      }
    }
  }

  window.ResponsiveCarousel = ResponsiveCarousel;

  // menu scripts
  const modalMenu = document.querySelector('.modal-menu');
  if (modalMenu) {
    // Handle submenu opening
    const menuItems = modalMenu.querySelectorAll('.modal-menu__item');
    const menuSubItems = modalMenu.querySelectorAll(
      '.modal-menu__submenu-item',
    );
    const submenuBackButtons = modalMenu.querySelectorAll(
      '.modal-menu__submenu-back',
    );
    const submenuCloseButtons = modalMenu.querySelectorAll('.modal__close');

    // Function to hide current submenu and show parent
    function hideSubmenu(backButton) {
      const parentSubItem = backButton.closest(
        '.modal-menu__submenu-item.active',
      );
      if (parentSubItem) {
        parentSubItem.classList.remove('active');
      } else {
        const parentItem = backButton.closest('.modal-menu__item.active');
        if (parentItem) {
          parentItem.classList.remove('active');
        }
      }
    }

    // Function to close all submenus and reset everything
    function closeAllSubmenus() {
      setTimeout(() => {
        const activeItems = modalMenu.querySelectorAll(
          '.modal-menu__item.active',
        );
        activeItems.forEach((activeItem) => {
          activeItem.classList.remove('active');
        });
      }, 300);
    }

    handleClick(menuItems);
    handleClick(menuSubItems, '.modal-menu__submenu-link');

    function handleClick(items, classes = '.modal-menu__link') {
      items.forEach((item) => {
        const link = item.querySelector(classes);
        if (link) {
          const submenuToggle = link.querySelector('svg'); // The arrow icon indicates submenu exists

          if (submenuToggle) {
            link.addEventListener('click', function (e) {
              e.preventDefault();
              item.classList.add('active');
            });
          }
        }
      });
    }

    // Add click event listeners to submenu back buttons
    submenuBackButtons.forEach((backButton) => {
      backButton.addEventListener('click', function (e) {
        e.preventDefault();
        hideSubmenu(backButton);
      });
    });

    // Add click event listeners to submenu close buttons
    submenuCloseButtons.forEach((closeButton) => {
      closeButton.addEventListener('click', function (e) {
        e.preventDefault();
        closeAllSubmenus();
      });
    });
  }

  const modalCalculator = document.querySelector('.modal_calculator');
  if (modalCalculator) {
    const item1 = modalCalculator.querySelector('.modal_calculator__item_1');
    const item2 = modalCalculator.querySelector('.modal_calculator__item_2');
    const back = modalCalculator.querySelector('.modal_calculator__back');
    const list = modalCalculator.querySelector('.modal_know-price__items');
    const inputData = modalCalculator.querySelector('input[name="data"]');
    const inputGift = modalCalculator.querySelector('input[name="gift"]');
    const inputPrices = modalCalculator.querySelector('input[name="prices"]');

    initializeCalculator(modalCalculator);

    function initializeCalculator(mainCalculator) {
      const areaInput = mainCalculator.querySelector(
        '.modal_calculator__label--heading_with_text input[type="text"]',
      );
      const calculateButton = mainCalculator.querySelector(
        '.modal_calculator__submit',
      );
      const totalPriceSpans = mainCalculator.querySelectorAll(
        '.modal_know-price__total-value span',
      );
      const giftInputs = mainCalculator.querySelectorAll(
        '.modal_calculator__gift-list input',
      );
      if (giftInputs[0]) {
        giftInputs.forEach((giftInput) => {
          giftInput.addEventListener('change', () => {
            inputGift.value = giftInput.value;
          });
        });
      }

      // Function to calculate total cost
      function calculateTotal() {
        list.innerHTML = '';
        inputData.value = '';
        inputPrices.value = '';
        inputGift.value = '';
        let data = '';

        const activeGiftInput = mainCalculator.querySelector(
          '.modal_calculator__gift-list input:checked',
        );
        if (activeGiftInput) {
          inputGift.value = activeGiftInput.value;
        }

        // Get area value and validate it
        let areaValue = parseFloat(areaInput.value.replace(/,/g, '.')) || 0;

        if (areaValue <= 0) {
          // If area is not set, show 0 as total
          updateTotalDisplay(0);
          return;
        }

        const allRadioButtons = mainCalculator.querySelectorAll(
          '.modal_calculator__label--heading_with_list input:checked',
        );

        let totalCost = 0;

        allRadioButtons.forEach((element) => {
          const label = element.closest('.p-select__option');
          const price = parseInt(label.dataset.value);

          totalCost += price * areaValue;

          const title = element
            .closest('.p-form__input')
            .querySelector('.p-form__label').textContent;
          const value = element.value;

          const html = createModalKnowPriceItemHtml(title, value, false);
          list.appendChild(html);

          data += title + ': ' + value + ' ';
        });

        const areaHtml = createModalKnowPriceItemHtml(
          areaInput.closest('.p-form__input').querySelector('.p-form__label')
            .textContent,
          areaInput.value,
          false,
        );
        list.appendChild(areaHtml);

        inputData.value = data;
        inputPrices.value = totalCost;

        // Update the total display
        updateTotalDisplay(totalCost);
      }

      // Function to update the total display in all locations
      function updateTotalDisplay(amount) {
        totalPriceSpans.forEach((span) => {
          // Format the number with spaces as thousands separators
          span.textContent = formatNumber(Math.round(amount));
        });
      }

      // Helper function to format numbers with spaces as thousand separators
      function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
      }

      // Add event listener to calculate button
      calculateButton.addEventListener('click', function (e) {
        e.preventDefault();
        calculateTotal();
        item1.classList.remove('active');
        item2.classList.add('active');
        back.classList.add('active');
      });

      back.addEventListener('click', () => {
        item1.classList.add('active');
        item2.classList.remove('active');
        back.classList.remove('active');
      });
    }
  }
});

function createModalKnowPriceItemHtml(title, value, isGift = false) {
  const item = document.createElement('div');
  item.className =
    'modal_know-price__item' + (isGift ? ' modal_know-price__item--gift' : '');
  item.innerHTML = `
    <div class="modal_know-price__item-left">${title.trim()}:</div>
    <div class="modal_know-price__item-right">${value}</div>
  `;
  return item;
}

window.createModalKnowPriceItemHtml = createModalKnowPriceItemHtml;
