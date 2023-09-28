<div class="newsdetail">
    <h1 class="newstitle"><?php echo $news['news_title']; ?></h1>
    <?php if ($news['publicdate']) { ?>
        <p class="newstime"><?php echo date('d/m/Y H:i', $news['publicdate']); ?></p>
    <?php } ?>
    <div class="newsdes">
        <?php
        echo $news['news_desc'];
        ?>
    </div>
    <?php 
        $this->renderPartial('partial/tags', array(
            'data_tags' => $news['meta_keywords'],
            'search_type' => ClaSite::SITE_TYPE_NEWS
        ));
    ?>
</div>