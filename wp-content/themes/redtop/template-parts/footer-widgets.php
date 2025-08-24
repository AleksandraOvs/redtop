<?php
// Массив ID всех футер-виджетов
$footer_sidebars = array(
    'footer-sidebar1',
    'footer-sidebar2',
    'footer-sidebar3',
    'footer-sidebar4',
);

// Проверяем и выводим только те, где есть активные виджеты
foreach ( $footer_sidebars as $sidebar ) {
    if ( is_active_sidebar( $sidebar ) ) {
        echo '<div class="footer-widget">';
            dynamic_sidebar( $sidebar );
        echo '</div>';
    }
}
?>