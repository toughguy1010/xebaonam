<?php if ($show_widget_title) { ?>
    <div class="panel panel-default supportbox">
        <div class="panel-heading">
            <h3><?php echo $widget_title; ?></h3>
        </div>
        <div class="panel-body">
        <?php } ?>
        <?php
        if ($data && count($data)) {
            ?>
            <ul class="menu menu-list support-list">
                <?php
                $i = 0;
                foreach ($data as $support) {
                    $i++;
                    if ($i > $limit)
                        break;
                    $this->render('type_' . $support['type'], array('data' => $support));
                }
                ?>
                </u>
            <?php } ?>
            <?php if ($show_widget_title) { ?>
        </div>
    </div>
<?php } ?>