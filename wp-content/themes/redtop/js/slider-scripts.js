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
  breakpoints:{
    1024:{
      slidesPerView: 3.3,
    },
    576:{
      slidesPerView: 2.1,
    }
  }
});