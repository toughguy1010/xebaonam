<?= 'Module: tourrelation' ?>
    <br>
<?= 'Variable:___________' ?>
    <br>
<?= 'Variable:$listtour' ?>
    <br>
<?= 'Variable:$widget_title' ?>
    <br>
<?= 'Variable:$show_widget_title' ?>
    <br>
<?php if (count($listtour)) { ?>
    <div class="list-news-relation">
        <?php if ($show_widget_title) { ?>
            <div class="news-relation-title">
                <h3><?php echo $widget_title; ?></h3>
            </div>
        <?php } ?>
        <ul class="list-group">
            <?php foreach ($listtour as $news) { ?>
                <li class="list-group-item">
                    <a href="<?php echo $news['link']; ?>" title="<?php echo $news['news_title']; ?>">
                        <?php echo $news['news_title']; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>