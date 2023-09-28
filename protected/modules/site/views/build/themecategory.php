<?php
if (isset($data) && count($data)) {
    ?>
    <ul class="menu">
        <?php
        if ($level == 0) {
            $c_link = Yii::app()->createUrl('site/build/choicetheme');
            $active = ($c_link == Yii::app()->request->requestUri) ? true : false;
            ?>
            <li class=" <?php echo ($active) ? 'active' : '' ?>" >
                <a href="<?php echo $c_link; ?>" title="<?php echo Yii::t('common', 'all'); ?>"><?php echo Yii::t('common', 'all'); ?></a>
            </li>
        <?php } ?>
        <?php
        foreach ($data as $cat_id => $category) {
            $c_link = Yii::app()->createUrl('site/build/choicetheme', array('cid' => $cat_id));
            $active = ($c_link == Yii::app()->request->requestUri) ? true : false;
            ?>
            <li class="<?php echo ($category['children']) ? 'submenu' : ''; ?> <?php echo ($active) ? 'active' : '' ?>" >
                <a href="<?php echo $c_link; ?>" title="<?php echo $category['cat_name']; ?>"><?php echo $category['cat_name']; ?></a>
                <?php
                $this->renderPartial('themecategory', array(
                    'data' => $category['children'],
                    'level' => $level + 1,
                ));
                ?>
            </li>
        <?php } ?>
    </ul>        
<?php } ?>