<div class="newsdetail">
    <h2 class="newstitle"><?php echo $news['news_title']; ?></h2>
    <p class="newstime"><?php echo date('d/m/Y H:i', $news['created_time']) ?></p>
    <h3 class="newssordes">
        <?php echo $news['news_sortdesc']; ?>
    </h3>
    <div class="newsdes">
        <?php
        echo $news['news_desc'];
        ?>
    </div>
</div>