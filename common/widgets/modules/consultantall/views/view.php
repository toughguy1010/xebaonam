<?php if (count($lecturers)) { ?>
    <div class="row">
        <div class="wrap_all_lecturer">
            <?php foreach ($lecturers as $lecturer) { ?>
                <div class="item-lecturer col-xs-4">
                    <div class="avatar-lecturer">
                        <a href="<?php echo $lecturer['link'] ?>">
                            <img src="<?php echo ClaHost::getImageHost() . $lecturer['avatar_path'] . 's200_200/' . $lecturer['avatar_name']; ?>" />
                        </a>
                    </div>
                    <div class="box-body">
                        <p class="chucdanh"><?php echo $lecturer['job_title'] ?></p>
                        <p class="name"><?php echo $lecturer['name'] ?></p>
                        <p class="company"><?php echo $lecturer['company'] ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class='product-page'>
            <?php
            $this->widget('common.extensions.LinkPager.LinkPager', array(
                'itemCount' => $totalitem,
                'pageSize' => $limit,
                'header' => '',
                'htmlOptions' => array('class' => 'W3NPager',), // Class for ul
                'selectedPageCssClass' => 'active',
            ));
            ?>
        </div>
    </div>
<?php } ?>
