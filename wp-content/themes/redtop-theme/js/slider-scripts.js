new Swiper('.hero-slider', {
  slidesPerView: 1,
  // loop: true,
  pagination: {
    el: '.slider-pagination',
    clickable: true,
  },
  // navigation: {
  //     nextEl: '.hero-button-next',
  //     prevEl: '.hero-button-prev',
  //     lockClass: 'hide'
  // },
});

new Swiper('.testimonials-slider', {
  // loop: true,
  slidesPerView: 1.2,
  spaceBetween: 20,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  breakpoints: {
    800: {
      slidesPerView: 2.4,
    }

  }
});

const swiper = new Swiper('.accessories-slider', {
  slidesPerView: 1.2,
  spaceBetween: 20,
  //loop: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  breakpoints: {
    1024: {
      slidesPerView: 3.3,
    },
    576: {
      slidesPerView: 2.1,
    }
  }
});

const productSlider = new Swiper('.slider-gallery', {
  slidesPerView: 1,
  spaceBetween: 10,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
});

// Миниатюры
var swiperThumbs = new Swiper('.swiper-thumbs', {
  spaceBetween: 10,
  slidesPerView: 5,
  freeMode: true,
  watchSlidesProgress: true,
});

// Основной слайдер
var swiperMain = new Swiper('.swiper-main', {
  spaceBetween: 10,
  loop: true,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  thumbs: {
    swiper: swiperThumbs,
  },
});

const recipeSlider = new Swiper('.slider-recipes', {
  slidesPerView: 1.2,
  spaceBetween: 20,
  loop: true,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev'
  },
  breakpoints: {
    800: {
      slidesPerView: 2.4
    }
  }
});