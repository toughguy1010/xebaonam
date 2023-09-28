<?php if (isset($images) && $images) { ?>
    <div class="gallery-index">
        <div class="container">
            <?php if ($show_widget_title) { ?>
                <div class="title-standard">
                    <h2><?php echo $widget_title ?></h2>
                </div>
            <?php } ?>
            <?php
            $first = array_shift($images);
            ?>
            <div class="ctn-gallery-index">
                <div class="row flex">
                    <div class="col-lg-8 col-md-8 col-sm-7 col-xs-12">
                        <div class="gallery-img-big">
                            <a class="eff-v3" href="<?php echo $first['link']; ?>">
                                <img src="<?php echo ClaHost::getImageHost(), $first['path'], $first['name']; ?>">
                            </a>
                        </div>
                    </div>
                    <?php if (isset($images) && $images) { ?>
                        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12">
                            <div class="gallery-img-small">
                                <?php foreach ($images as $image) { ?>
                                    <a class="eff-v3" href="<?php echo $image['link'] ?>">
                                        <img src="<?php echo ClaHost::getImageHost(), $image['path'], 's400_400/', $image['name']; ?>" />
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php
        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK8));
        ?>
    </div>
<?php } ?>