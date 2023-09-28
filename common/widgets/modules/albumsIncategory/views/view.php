<?php if (count($albums)) { ?>
    <?php if ($show_widget_title) { ?>
        <div class="title clearfix">
            <div class="title_box">
                <h2><?php echo $widget_title ?></h2>
            </div>
        </div>
    <?php } ?>
    <div class="wrapper-list-news">
        <?php
        $first = ClaArray::getFirst($albums);
        $albums = ClaArray::removeFirstElement($albums);
        ?>
        <?php if ($first) { ?>
            <div class="col-sm-6 first-news-large">
                <a href="<?php echo $first['link'] ?>" title="<?php echo $first['album_name'] ?>">
                    <img src="<?php echo ClaHost::getImageHost() . $first['avatar_path'] . $first['avatar_name'] ?>" alt="<?php echo $first['album_name'] ?>">
                </a>
                <div class="description-news">
                    <p><a href="<?php echo $first['link'] ?>"><?php echo $first['album_name'] ?></a></p>
                </div>
            </div>
        <?php } ?>
        <?php if ($albums && count($albums)) { ?>
            <div class="col-sm-6">
                <div class="row">
                    <?php foreach ($albums as $al) { ?>
                        <div class="col-xs-6 item-news">
                            <a href="<?php echo $al['link'] ?>" title="<?php echo $al['album_name'] ?>">
                                <img src="<?php echo ClaHost::getImageHost() . $al['avatar_path'] . 's280_280/' . $al['avatar_name'] ?>" alt="<?php echo $al['album_name'] ?>">
                            </a>
                            <div class="description-news">
                                <p><?php echo $al['album_name'] ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.wrapper-list-news .item-news').hover(function() {
            $(this).find('.description-news').show();
        }, function() {
            $(this).find('.description-news').hide();
        });
        $('.wrapper-list-news .first-news-large').hover(function() {
            $(this).find('.description-news').show();
        }, function() {
            $(this).find('.description-news').hide();
        });
        
    });
</script>

