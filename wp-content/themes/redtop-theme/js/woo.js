document.addEventListener('DOMContentLoaded', function () {

    console.log('woo.js loaded');
    console.log('mini_cart_params:', window.mini_cart_params);

    const noticesWrapper = document.querySelector('.woocommerce-notices-wrapper');
    if (!noticesWrapper) return;

    // Функция плавного удаления уведомления
    function removeNotice(notice) {
        notice.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        notice.style.opacity = '0';
        notice.style.transform = 'translateY(-20px)';
        setTimeout(() => notice.remove(), 300);
    }

    // Автоматическое скрытие через 15 секунд
    setTimeout(() => {
        noticesWrapper.querySelectorAll('.woocommerce-message').forEach(notice => {
            removeNotice(notice);
        });
    }, 15000);

    // Скрытие при клике вне блока уведомлений
    document.addEventListener('click', function (e) {
        if (!noticesWrapper.contains(e.target)) {
            noticesWrapper.querySelectorAll('.woocommerce-message').forEach(notice => {
                removeNotice(notice);
            });
        }
    });

});