<?php if (isset($product_rating) && count($product_rating)) {
    $discount5 = ClaProduct::getDiscount($total_votes, $grouprating['number_rating'][5]);
    $discount4 = ClaProduct::getDiscount($total_votes, $grouprating['number_rating'][4]);
    $discount3 = ClaProduct::getDiscount($total_votes, $grouprating['number_rating'][3]);
    $discount2 = ClaProduct::getDiscount($total_votes, $grouprating['number_rating'][2]);
    $discount1 = ClaProduct::getDiscount($total_votes, $grouprating['number_rating'][1]);
    $group = $grouprating['number_rating'];
    ?>
    <div class="side">
        <div>5 Sao</div>
    </div>
    <div class="middle">
        <div class="bar-container">
            <div class="bar-5" style="width: <?php echo $grouprating['rating_percent'][5] ?>"></div>
        </div>
    </div>
    <div class="side right">
        <div><?=($group[5]) ? $group[5] : 0?></div>
    </div>
    <div class="side">
        <div>4 Sao</div>
    </div>
    <div class="middle">
        <div class="bar-container">
            <div class="bar-4" style="width: <?php echo $grouprating['rating_percent'][4] ?>"></div>
        </div>
    </div>
    <div class="side right">
        <div><?=($group[4]) ? $group[4] : 0?></div>
    </div>
    <div class="side">
        <div>3 Sao</div>
    </div>
    <div class="middle">
        <div class="bar-container">
            <div class="bar-3" style="width: <?php echo $grouprating['rating_percent'][3] ?>"></div>
        </div>
    </div>
    <div class="side right">
        <div><?=($group[3]) ? $group[3] : 0?></div>
    </div>
    <div class="side">
        <div>2 Sao</div>
    </div>
    <div class="middle">
        <div class="bar-container">
            <div class="bar-2" style="width: <?php echo $grouprating['rating_percent'][2] ?>"></div>
        </div>
    </div>
    <div class="side right">
        <div><?=($group[2]) ? $group[2] : 0?></div>
    </div>
    <div class="side">
        <div>1 Sao</div>
    </div>
    <div class="middle">
        <div class="bar-container">
            <div class="bar-1" style="width: <?php echo $grouprating['rating_percent'][1] ?>"></div>
        </div>
    </div>
    <div class="side right">
        <div><?=($group[1]) ? $group[1] : 0?></div>
    </div>
<?php } ?>