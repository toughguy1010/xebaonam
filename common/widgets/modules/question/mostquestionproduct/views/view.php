<?php if (count($data)) {
    ?>
    <?php if ($show_widget_title) { ?>
        <h2><?php echo $widget_title; ?></h2>
    <?php } ?>
    <div class="ask_sp">
        <?php
        foreach ($data as $product) { ?>
            <a class="linkimg" href="<?php echo $product['link'] ?>">
                <img src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's220_220/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                <h3><?= $product['name'] ?></h3>
                <label><?= $product['VoteCount'] ?> câu hỏi</label>
            </a>
        <?php } ?>
    </div>
<?php } ?>