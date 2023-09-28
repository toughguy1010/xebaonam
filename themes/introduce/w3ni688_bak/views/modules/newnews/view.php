<?php if (count($news)) { ?>
    <div class="evaluate">
        <?php if ($show_widget_title) { ?>
            <h2><?php echo $widget_title ?></h2>
        <?php } ?>
        <div class="cont">
            <ul type="1">
                <?php foreach ($news as $new) { ?>
                    <li><a href="<?php echo $new['link'] ?>"><?php echo $new['news_title']; ?></a></li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php }
?>
