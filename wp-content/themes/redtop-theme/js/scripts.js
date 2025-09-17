document.addEventListener("DOMContentLoaded", () => {

    const body = document.body;
    const menu = document.querySelector('.header-nav');
    const burger = document.querySelector('.menu-toggle');

    // Клик по бургеру
    burger.addEventListener('click', (e) => {
        e.stopPropagation(); // остановить всплытие
        burger.classList.toggle('open');
        menu.classList.toggle('open');
        body.classList.toggle('_fixed');
    });

    // Клик вне меню — закрыть
    document.addEventListener('click', (e) => {
        if (menu.classList.contains('open')) {
            // closest проверяет, что клик не по меню и не по бургеру
            if (!e.target.closest('.header-nav') && !e.target.closest('.menu-toggle')) {
                menu.classList.remove('open');
                burger.classList.remove('open');
                body.classList.remove('_fixed');
            }
        }
    });


    if (window.innerWidth > 1024) {
        const parents = document.querySelectorAll('.menu-item-has-children');

        parents.forEach(parent => {
            const link = parent.querySelector('a');
            const submenu = parent.querySelector('.dropdown-menu');

            if (!link || !submenu) return;

            // Показываем меню при наведении мыши
            parent.addEventListener('mouseenter', () => {
                submenu.style.display = 'grid';
            });

            parent.addEventListener('mouseleave', () => {
                submenu.style.display = 'none';
            });

            // Переход по ссылке по клику
            link.addEventListener('click', (e) => {
                console.log(`переход по ссылке: ${link.textContent.trim()}`);
                // переход по ссылке произойдёт по умолчанию
            });
        });
    }

    // Изменение хедера при скролле

    //if (window.innerWidth < 1024) {
    const headerFront = document.querySelector('.site-header');
    const headerChange = () => {
        const
            mainBlock = document.querySelector('body');


        window.addEventListener('scroll', () => {
            if (-mainBlock.getBoundingClientRect().top > 500) {
                headerFront.classList.add('header-scroll');

            } else {
                headerFront.classList.remove('header-scroll');
            }
        })

    }
    headerChange();
    //}
    //плавный скролл

    function smoothScrollToElement(selector) {
        if (!selector || selector === '#') return; // защита от пустого селектора
        const el = document.querySelector(selector);
        if (el) el.scrollIntoView({ behavior: 'smooth' });


        // Отключаем встроенный smooth scroll на время анимации
        document.documentElement.style.scrollBehavior = "auto";

        const element = document.scrollingElement || document.documentElement;
        const start = element.scrollTop;
        const targetTop = target.getBoundingClientRect().top + start - 160;
        const change = targetTop - start;
        const startTime = performance.now();

        function easeInOutQuad(t) {
            return t < 0.5
                ? 2 * t * t
                : -1 + (4 - 2 * t) * t;
        }

        function animateScroll(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = easeInOutQuad(progress);

            element.scrollTop = start + change * easedProgress;

            if (elapsed < duration) {
                requestAnimationFrame(animateScroll);
            } else {
                // Возвращаем поведение браузера обратно
                document.documentElement.style.scrollBehavior = "";
            }
        }

        requestAnimationFrame(animateScroll);
    }

    //  плавный скролл по клику на ссылку
    document.querySelectorAll('a[href^="#"]').forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault(); // убираем мгновенный прыжок
            smoothScrollToElement(this.getAttribute("href"), 800);
        });
    });

    // кнопка вверх
    const upArrow = document.querySelector('.arrow-up');


    function arrowUp() {

        if (upArrow) {
            upArrow.addEventListener('click', (e) => {
                e.preventDefault();
                smoothScrollToTop(800);
            });
        }

        // const arrow = document.querySelector('.arrow-up');
        if (!upArrow) return; // если кнопка не найдена — выходим

        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                upArrow.classList.add('show');
            } else {
                upArrow.classList.remove('show');
            }
        });
    }

    arrowUp();

    // Универсальный плавный скролл к верху
    function smoothScrollToTop(duration = 700) {
        const element = document.scrollingElement || document.documentElement;
        const start = element.scrollTop;
        const change = -start;
        const startTime = performance.now();

        function easeInOutQuad(t) {
            return t < 0.5
                ? 2 * t * t
                : -1 + (4 - 2 * t) * t;
        }

        function animateScroll(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const easedProgress = easeInOutQuad(progress);

            element.scrollTop = start + change * easedProgress;

            if (elapsed < duration) {
                requestAnimationFrame(animateScroll);
            }
        }

        requestAnimationFrame(animateScroll);
    }
    //анимация при скролле

    function onEntry(entry) {
        entry.forEach(change => {
            if (change.isIntersecting) {
                change.target.classList.add('animate');
            }
        });
    }
    let options = { threshold: [0.5] };
    let observer = new IntersectionObserver(onEntry, options);
    let elements = document.querySelectorAll('.fromTop, .toRight, .toLeft, .fromBottom, .fromOpacity');
    for (let elm of elements) {
        observer.observe(elm);
    };

    // Перехватываем событие добавления в корзину
    document.body.addEventListener('added_to_cart', function (event) {
        // Запоминаем текущую позицию скролла
        var scrollPos = window.scrollY || window.pageYOffset;

        // Обновляем контейнер уведомлений, если WooCommerce вернул фрагменты
        var fragments = event.detail ? event.detail.fragments : null;
        if (fragments && fragments['div.woocommerce-notices-wrapper']) {
            var wrapper = document.querySelector('div.woocommerce-notices-wrapper');
            if (wrapper) {
                wrapper.outerHTML = fragments['div.woocommerce-notices-wrapper'];
            }
        }

        // Восстанавливаем позицию страницы
        window.scrollTo(0, scrollPos);
    });

    // Отключаем встроенную функцию скролла WooCommerce
    if (typeof window.scroll_to_notices === 'function') {
        window.scroll_to_notices = function () { return false; };
    }

    jQuery(function ($) {
        $('form.cart, .woocommerce-cart-form').on('click', 'button.plus, button.minus', function () {
            var qty = $(this).closest('.quantity').find('.qty');
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr('max'));
            var min = parseFloat(qty.attr('min'));
            var step = parseFloat(qty.attr('step'));

            if (isNaN(val)) val = 0;
            if (isNaN(step) || step == 0) step = 1;

            if ($(this).is('.plus')) {
                if (max && (val >= max)) {
                    qty.val(max);
                } else {
                    qty.val(val + step);
                }
            } else {
                if (min && (val <= min)) {
                    qty.val(min);
                } else if (val > 0) {
                    qty.val(val - step);
                }
            }
            qty.trigger('change');
        });
    });

});
