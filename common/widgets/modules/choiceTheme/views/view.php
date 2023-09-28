<?php
if (isset($data) && count($data)) {
    ?>
    <ul class="menu">
        <?php
        if ($level == 0) {
            $c_link = Yii::app()->createUrl('site/build/choicetheme');
            $active = ($c_link == Yii::app()->request->requestUri) ? true : false;
            ?>
            <li class=" <?php echo ($active) ? 'active' : '' ?>">
                <a href="<?php echo $c_link; ?>"
                   title="<?php echo Yii::t('common', 'all'); ?>"><?php echo Yii::t('common', 'all'); ?></a>
            </li>
        <?php } ?>
        <?php
        foreach ($data as $cat_id => $category) {
            $c_link = Yii::app()->createUrl('site/build/choicetheme', array('cid' => $cat_id));
            $active = ($c_link == Yii::app()->request->requestUri) ? true : false;
            ?>
            <li class="<?php echo ($category['children']) ? 'submenu' : ''; ?> <?php echo ($active) ? 'active' : '' ?>">
                <a href="<?php echo $c_link; ?>"
                   title="<?php echo $category['cat_name']; ?>"><?php echo $category['cat_name']; ?></a>
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
<div class="row list-theme">
    <?php
    if (count($themes)) {
        foreach ($themes as $theme) { ?>
            <div class="theme-item">
                <div class="theme-box">
                    <div class="theme-image">
                        <img
                            src="<?php echo ClaHost::getImageHost() . $theme['avatar_path'] . 's500_500/' . $theme['avatar_name']; ?>"
                            alt="<?php echo $theme['theme_name']; ?>"/>
                    </div>
                    <?php if ($theme['status'] == Themes::STATUS_AVAILABLE) { ?>
                        <a class="btn btn-primary theme-action"
                           href="<?php echo Yii::app()->createUrl('/site/build/install', array('theme' => $theme['theme_id'])) ?>">
                            <?php echo Yii::t('theme', 'choicetheme'); ?>
                        </a>
                    <?php } ?>
                    <?php if ($theme['status'] == Themes::STATUS_DEMO) { ?>
                        <a href="<?php echo Yii::app()->createUrl('site/build/order', array('theme' => $theme['theme_id'])); ?>"
                           class="btn btn-info theme-action">
                            <?php echo Yii::t('request', 'request_design'); ?>
                        </a>
                    <?php } ?>
                    <div class="theme-info">
                        <div class="theme-info-box">
                            <h3 class="theme-info-title"><?php echo $theme['theme_name']; ?></h3>
                            <div class="theme-info-view">
                                <?php if ($theme['status'] == Themes::STATUS_AVAILABLE && $theme['previewlink']) { ?>
                                    <a href="<?php echo $theme['previewlink']; ?>" class="btn btn-sm btn-success"
                                       target="_blank">
                                        <?php echo Yii::t('common', 'preview'); ?>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="theme-cover"></div>
                    <i class="theme-icon <?php echo ($theme['status'] == Themes::STATUS_DEMO) ? 'theme-waiting' : ''; ?>"></i>
                </div>
            </div>
        <?php
            // $this->renderPartial('themeItem', array('theme' => $theme));
        }
        ?>
        <div class="col-xs-4 theme-item">
            <div class="theme-box">
                <div class="theme-request">
                    <div class="theme-request-title">
                        <p>Nếu bạn chưa ưng ý với giao diện hiện có, vui lòng gửi yêu cầu thiết kế của bạn cho chúng
                            tôi.</p>
                        <p class="theme-font-red"><i>Nanoweb xin chân thành cảm ơn</i></p>
                    </div>
                    <div class="theme-request-banner">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/img/theme-build.png"/>
                        <a class="theme-send-request"
                           href="<?php echo Yii::app()->createUrl('/site/request/create'); ?>">
                        </a>
                    </div>
                    <div class="theme-request-hotline">
                        Hotline tư vấn thiết kế: <span class="theme-font-red"><a
                                onclick="goog_report_conversion('tel:0948854888')">0948 854 888</a></span>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="w3pager" align="">
    <?php
    $this->widget('common.extensions.LinkPager.LinkPager', array(
        'itemCount' => $totalItems,
        'pageSize' => $pagesize,
        'header' => '',
        'htmlOptions' => array('class' => 'W3NPager',), // Class for ul
        'selectedPageCssClass' => 'active',
    ));
    ?>
</div>
