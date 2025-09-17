// document.addEventListener('DOMContentLoaded', function () {

//     function showNotice(message) {
//         const notice = document.createElement('div');
//         notice.className = 'custom-add-to-cart-notice';
//         notice.textContent = message;

//         Object.assign(notice.style, {
//             position: 'fixed',
//             top: '20px',
//             right: '20px',
//             background: '#2ecc71',
//             color: '#fff',
//             padding: '12px 20px',
//             borderRadius: '8px',
//             zIndex: 9999,
//             opacity: 0,
//             transition: 'opacity 0.3s',
//             fontSize: '14px',
//             boxShadow: '0 3px 10px rgba(0,0,0,0.2)'
//         });

//         document.body.appendChild(notice);
//         setTimeout(() => notice.style.opacity = 1, 10);

//         setTimeout(() => {
//             notice.style.opacity = 0;
//             setTimeout(() => notice.remove(), 400);
//         }, 2000);
//     }

//     const nonce = window.wc_add_to_cart_params?.nonce;
//     if (!nonce) {
//         console.error('Nonce не найден! Добавление в корзину невозможно.');
//         return;
//     }

//     document.querySelectorAll('.custom-add-to-cart-button').forEach(button => {
//         button.addEventListener('click', function (e) {
//             e.preventDefault();

//             const productId = parseInt(this.dataset.productId);
//             const quantity = parseInt(this.dataset.quantity) || 1;

//             fetch('/wp-json/wc/store/cart/items', {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-WP-Nonce': nonce
//                 },
//                 credentials: 'same-origin',
//                 body: JSON.stringify({ id: productId, quantity: quantity })
//             })
//                 .then(response => response.json().then(data => {
//                     if (!response.ok) {
//                         console.error('Ответ сервера:', data);
//                         throw new Error('Ошибка при добавлении товара');
//                     }
//                     return data;
//                 }))
//                 .then(data => {
//                     showNotice(`Товар "${data.name}" добавлен в корзину!`);
//                     const event = new Event('wc-cart-update', { bubbles: true });
//                     document.body.dispatchEvent(event);
//                 })
//                 .catch(error => {
//                     console.error(error);
//                     showNotice('Ошибка при добавлении товара в корзину');
//                 });
//         });
//     });

// });

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

    //появление списка добавленных товаров при клике на mini-cart
    const toggleBtn = document.querySelector('.mini-cart-toggle');
    const dropdown = document.querySelector('.mini-cart-dropdown');
    const body = document.body;

    if (!toggleBtn || !dropdown) return;

    toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        const isOpen = dropdown.classList.toggle('show');

        if (isOpen) {
            body.classList.add('_fixed');
        } else {
            body.classList.remove('_fixed');
        }
    });

    // Закрытие при клике вне дропдауна
    document.addEventListener('click', function (e) {
        if (!dropdown.contains(e.target) && !toggleBtn.contains(e.target)) {
            if (dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
                body.classList.remove('_fixed');
            }
        }
    });
});

// jQuery(function ($) {
//   $(document).on('click', '.mini-cart-thumb .remove', function (e) {
//     e.preventDefault();

//     const $link = $(this);
//     const cart_item_key = $link.data('cart_item_key');

//     if (!cart_item_key) return;

//     $.ajax({
//       type: 'POST',
//       url: redtop_cart_params.ajax_url, // ← используем наш объект
//       data: {
//         action: 'woocommerce_remove_cart_item',
//         cart_item_key: cart_item_key,
//       },
//       success: function (response) {
//         if (!response || !response.fragments) return;

//         // WooCommerce возвращает "фрагменты" для обновления корзины
//         $.each(response.fragments, function (key, value) {
//           $(key).replaceWith(value);
//         });

//         console.log('Товар удалён из мини-корзины без перезагрузки');
//       },
//       error: function (xhr) {
//         console.error('Ошибка удаления товара:', xhr.responseText);
//       },
//     });
//   });
// });

document.addEventListener('click', function (e) {
    const removeBtn = e.target.closest('.mini_cart_item .remove');
    if (!removeBtn) return;

    e.preventDefault();
    const key = removeBtn.dataset.cart_item_key;
    if (!key) return;

    if (typeof mini_cart_params === 'undefined') {
        console.error('mini_cart_params не определена!');
        return;
    }

    fetch(mini_cart_params.ajax_url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'rt_remove_from_cart',
            cart_item_key: key,
            _wpnonce: mini_cart_params.nonce ?? ''
        })
    })
        .then(res => res.json())
        .then(data => {
            if (data.fragments) {
                Object.entries(data.fragments).forEach(([selector, html]) => {
                    const el = document.querySelector(selector);
                    if (!el) return;

                    // если это мини-корзина, заменяем только внутреннее содержимое
                    if (selector === '.mini-cart-dropdown') {
                        el.innerHTML = html;
                    } else {
                        el.outerHTML = html;
                    }
                });
            }
        })
        .catch(err => console.error('Ошибка удаления из корзины:', err));
});

// jQuery(function ($) {
//     $('.woocommerce-product-gallery__wrapper')
//         .addClass('swiper-wrapper')
//         .children()
//         .addClass('swiper-slide')
//         .wrapAll('<div class="swiper product-gallery-slider"><div class="swiper-wrapper"></div></div>');
//     $('.swiper').append('<div class="swiper-pagination"></div><div class="swiper-button-prev"></div><div class="swiper-button-next"></div>');
// });


document.addEventListener('DOMContentLoaded', () => {
    const swatches = document.querySelectorAll('.custom-color-swatches .color-swatch');

    swatches.forEach(swatch => {
        const radio = swatch.querySelector('input[type="radio"]');
        if (!radio) return;

        radio.addEventListener('change', () => {
            // Убираем класс .checked у всех элементов
            swatches.forEach(s => s.classList.remove('checked'));
            // Добавляем класс .checked выбранному
            if (radio.checked) {
                swatch.classList.add('checked');
            }
        });

        // Если при загрузке элемент уже выбран
        if (radio.checked) {
            swatch.classList.add('checked');
        }
    });
});