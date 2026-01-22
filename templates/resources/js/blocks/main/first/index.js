document.addEventListener('DOMContentLoaded', () => {
  const mainFirsts = document.querySelectorAll('.main-first');
  if (mainFirsts[0]) {
    mainFirsts.forEach((mainFirst) => {
      const swiper320 = mainFirst.querySelector('.main-first__320');
      if (swiper320) {
        const swiper = new Swiper(swiper320.querySelector('.swiper'), {
          // Optional parameters
          slidesPerView: 'auto',

          // Navigation arrows
          navigation: {
            nextEl: swiper320.querySelector('.main-first__arrow--right'),
            prevEl: swiper320.querySelector('.main-first__arrow--left'),
          },

          autoplay: {
            delay: 3000,
          },

          spaceBetween: 20,
        });
      }

      const swiper1024 = mainFirst.querySelector('.main-first__1024');
      if (swiper1024) {
        var swiperThumb = new Swiper(
          swiper1024.querySelector('.main-first__1024-thumb .swiper'),
          {
            spaceBetween: 30,
            slidesPerView: 2,
            allowTouchMove: false,
          }
        );

        var swiperMain = new Swiper(
          swiper1024.querySelector('.main-first__1024-main .swiper'),
          {
            spaceBetween: 30,
            navigation: {
              nextEl: swiper1024.querySelector('.main-first__arrow--right'),
              prevEl: swiper1024.querySelector('.main-first__arrow--left'),
            },
            slidesPerView: 1,
            allowTouchMove: false,
            autoplay: {
              delay: 3000,
            },
          }
        );

        swiperMain.on('slideChange', function () {
          const mainIndex = swiperMain.activeIndex;

          // Индекс для thumb = mainIndex - 1
          let thumbIndex = mainIndex;

          // Обеспечиваем, что не выйдем за пределы
          const maxThumbIndex = swiperThumb.slides.length;

          if (thumbIndex > maxThumbIndex) {
            thumbIndex = maxThumbIndex;
          }

          // Прокручиваем thumb к нужному слайду без анимации (или с ней — по желанию)
          swiperThumb.slideTo(thumbIndex, 300);
        });
      }
    });
  }
});
