<?php if ($show_widget_title) { ?>
    <h2 class="title-project wow fadeInUp">
        <a href="javascript:void(0)"><?php echo $widget_title ?></a>
    </h2>
<?php } ?>
<?php if (isset($projects) && $projects) { ?>
    <div class="box-hot-project">
        <?php foreach ($projects as $project) { ?>
            <div class="hot-project col-lg-4 col-md-4 col-sm-4 col-xs-12 wow fadeInUp">
                <div class="hot-project-img">
                    <a target="_blank" href="<?php echo $project['link'] ?>">
                        <?php if ($project['avatar_path'] && $project['avatar_name']) { ?>
                            <img src="<?php echo ClaHost::getImageHost(), $project['avatar_path'], 's380_380/', $project['avatar_name'] ?>"
                                 alt="<?php echo $project['name'] ?>"/>
                        <?php } ?>
                    </a>
                </div>
                <h2><a target="_blank" href="<?php echo $project['link'] ?>"><?php echo $project['name'] ?></a></h2>
                <p class="local-project">
                    <?php
                    $province = LibProvinces::model()->findByPk($project['province_id']);
                    echo (isset($province->name) && $province->name) ? $province->name : '';
                    ?>
                </p>
            </div>
        <?php } ?>
    </div>
<?php } ?>
<div class="wpager">
    <?php
    $this->widget('common.extensions.LinkPager.LinkPager', array(
        'itemCount' => $totalitem,
        'pageSize' => $limit,
        'header' => '',
        'selectedPageCssClass' => 'active',
    ));
    ?>
</div>
