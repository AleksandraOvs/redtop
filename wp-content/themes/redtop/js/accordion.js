window.addEventListener('DOMContentLoaded', function() {
    jQuery(document).ready(function($){
      $('#faq .faq-item').accordion({
          active: 0,
          animate: {
              duration: 300,
              easing: '',
          },
          heightStyle: 'content',
          collapsible: true,
          icons: false,
          active: false,
      });
  });
  
  })
  