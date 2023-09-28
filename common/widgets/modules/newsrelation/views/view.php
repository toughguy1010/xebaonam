<?php if (count($listnews)) { ?>
    <div class="list-news-relation">
        <?php if ($show_widget_title) { ?>
            <div class="news-relation-title">
                <h3><?php echo $widget_title; ?></h3>
            </div>
        <?php } ?>
        <ul class="list-group">
            <?php foreach ($listnews as $news) { ?>
                <li class="list-group-item">
                    <a href="<?php echo $news['link']; ?>" title="<?php echo $news['news_title']; ?>">
                        <?php echo $news['news_title']; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>