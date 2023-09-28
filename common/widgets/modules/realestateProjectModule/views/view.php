<?php if (isset($projects) && count($projects)) { ?>
    <div class="wrap_menu_list_project">
        <?php foreach ($projects as $project) {
            ?>
            <div class="item clearfix">
                <h3>
                    <a href="<?php echo $project['link'] ?>"><?php echo $project['name'] ?></a>
                </h3>
                <?php if ($project['realestates'] && count($project['realestates'])) { ?>
                    <ul class="sub-realestates">
                        <?php foreach ($project['realestates'] as $realestate) { ?>
                            <li>
                                <a class="<?php echo $realestate['type'] == ActiveRecord::TYPE_INTERNAL ? 'internal' : 'normal' ?>" href="<?php echo $realestate['link'] ?>" title="<?php echo $realestate['type'] == ActiveRecord::TYPE_INTERNAL ? Yii::t('realestate', 'realestate_internal') : Yii::t('realestate', 'realestate_normal'); ?>"><?php echo $realestate['type'] == ActiveRecord::TYPE_INTERNAL ? '[NB]' : '' ?> <?php echo $realestate['name'] ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>