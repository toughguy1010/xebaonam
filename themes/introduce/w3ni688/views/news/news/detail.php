<div class="content-news-detail">
    <div class="newsdetail">
        <h1><?php echo $news['news_title']; ?></h1>
        <?php if ($news['publicdate']) { ?>
            <p class="newstime"><?php echo date('d/m/Y H:i', $news['publicdate']); ?></p>
        <?php } ?>
        <div class="newsdes">
            <?php
            echo ClaWeb::replaceWebText($news['news_desc']);
            ?>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $(".newsdes table").attr("border",1);
    });
</script>