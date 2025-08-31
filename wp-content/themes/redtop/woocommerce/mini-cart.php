<div class="mini-cart">
    <a class="mini-cart-toggle" href="<?php echo wc_get_cart_url(); ?>">
        <svg width="139" height="206" viewBox="0 0 139 206" fill="none" xmlns="http://www.w3.org/2000/svg">
            <rect x="2" y="56" width="135" height="148" stroke="black" stroke-width="7" />
            <path d="M111 74V43C111 20.3563 92.6437 2 70 2V2C47.3563 2 29 20.3563 29 43V74" stroke="black" stroke-width="7" />
        </svg>
        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
    </a>
    <div class="mini-cart-dropdown">
        <?php woocommerce_mini_cart(); ?>
    </div>
</div>