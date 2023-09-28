<div class="cart">
    <div class="cart-box">
        <div class="cart-info">
            <a href="<?php echo $link; ?>" class="cart-link">
                <span class="countProduct cart-quantity">
                    <?php
                    if ($show_widget_title) {
                        echo $widget_title . " (";
                    }
                    ?>
                    <?php echo $quantity; ?>
                    <?php if ($show_widget_title) echo ')'; ?>
                </span>
            </a>
        </div>
    </div>
</div>