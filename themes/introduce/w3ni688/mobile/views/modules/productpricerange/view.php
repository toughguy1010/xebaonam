<div class="dv-mobi767">
    <div class="dv-timkiem-gia-mn dv-timkiem-gia-mn-1">
        <?php foreach ($range as $ra) { ?>
            <li><a class="<?= ($ra['active']) ? 'actii' : '' ?>"
                   href="<?php echo $ra['link']; ?>"><?php echo $ra['priceText']; ?></a></li>
        <?php } ?>
    </div>
</div>
