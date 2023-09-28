<div id="sidebar" class="sidebar">
    <div id="sidebar-shortcuts" class="sidebar-shortcuts">
        &nbsp;
    </div><!-- #sidebar-shortcuts -->

    <ul class="nav nav-list">
        <li class=" <?php if (isset(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'news' || (in_array(Yii::app()->controller->id, array('categorypage')))) echo 'active'; ?>">
            <a class="dropdown-toggle" href="#">
                <i class="icon-file-text-alt"></i>
                <span class="menu-text"><?php echo Yii::t('menu', 'left_module_content'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li class="<?php if (Yii::app()->controller->id == 'news' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/news/news/') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('news', 'news_manager') ?>
                    </a>
                </li>

                <li class="<?php if (Yii::app()->controller->id == 'newscategory') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/news/newscategory/') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('news', 'news_category') ?>
                    </a>
                </li>
                <li class="<?php if (Yii::app()->controller->id == 'categorypage') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/interface/categorypage') ?>" title="Tạo trang có nội dung tùy ý chính sửa">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('categorypage', 'categorypage_manager'); ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class=" <?php if (isset(Yii::app()->controller->module) && Yii::app()->controller->module->id == 'economy') echo 'active'; ?>">
            <a class="dropdown-toggle" href="#">
                <i class="icon-file"></i>
                <span class="menu-text"><?php echo Yii::t('menu', 'left_module_product'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>

            <ul class="submenu">
                <li class="<?php if (Yii::app()->controller->id == 'product' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/economy/product/') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('product', 'product_manager') ?>
                    </a>
                </li>

                <li class="<?php if (Yii::app()->controller->id == 'productcategory') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/economy/productcategory/') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('product', 'product_category') ?>
                    </a>
                </li>
                <li class="<?php if (Yii::app()->controller->id == 'product' && in_array(Yii::app()->controller->action->id, array('create', 'update'))) echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/economy/product/create') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('product', 'product_create') ?>
                    </a>
                </li>
            </ul>
        </li>

        <li class=" <?php if (in_array(Yii::app()->controller->id, array('banner', 'bannergroup'))) echo 'active'; ?>">
            <a class="dropdown-toggle" href="#">
                <i class="icon-building"></i>
                <span class="menu-text"><?php echo Yii::t('banner', 'banner'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li class="<?php if (Yii::app()->controller->id == 'banner') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/interface/banner') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('banner', 'banner_manager'); ?>
                    </a>
                </li>
                <li class="<?php if (Yii::app()->controller->id == 'bannergroup') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/interface/bannergroup') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('banner', 'banner_group_manager'); ?>
                    </a>
                </li>
            </ul>
        </li>

            <li class="<?php if (Yii::app()->controller->module && Yii::app()->controller->module->id == 'media' && Yii::app()->controller->id == 'album') echo 'active'; ?>">
                <a class="dropdown-toggle" href="#">
                    <i class="icon-picture"></i>
                    <span class="menu-text"> <?php echo Yii::t('menu', 'left_module_albums'); ?> </span>
                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li class="<?php if (Yii::app()->controller->id == 'album' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
                        <a href="<?php echo Yii::app()->createUrl('/media/album/') ?>">
                            <i class="icon-double-angle-right"></i>
                            <?php echo Yii::t('album', 'album_manager') ?>
                        </a>
                    </li>

                    <li class="<?php if (Yii::app()->controller->id == 'album' && Yii::app()->controller->action->id == 'create') echo 'active'; ?>">
                        <a href="<?php echo Yii::app()->createUrl('/media/album/create') ?>">
                            <i class="icon-double-angle-right"></i>
                            <?php echo Yii::t('album', 'album_create') ?>
                        </a>
                    </li>
                </ul>
            </li>
            <?php if ($this->site_id == 1) { ?>
            <li class="<?php if (Yii::app()->controller->module && Yii::app()->controller->module->id == 'media' && Yii::app()->controller->id == 'video') echo 'active'; ?>">
                <a class="dropdown-toggle" href="#">
                    <i class="icon-facetime-video"></i>
                    <span class="menu-text"> <?php echo Yii::t('menu', 'left_module_videos'); ?> </span>
                    <b class="arrow icon-angle-down"></b>
                </a>

                <ul class="submenu">
                    <li class="<?php if (Yii::app()->controller->id == 'video' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
                        <a href="<?php echo Yii::app()->createUrl('/media/video/') ?>">
                            <i class="icon-double-angle-right"></i>
                            <?php echo Yii::t('video', 'video_manager') ?>
                        </a>
                    </li>

                    <li class="<?php if (Yii::app()->controller->id == 'video' && Yii::app()->controller->action->id == 'create') echo 'active'; ?>">
                        <a href="<?php echo Yii::app()->createUrl('/media/video/create') ?>">
                            <i class="icon-double-angle-right"></i>
                            <?php echo Yii::t('video', 'video_create') ?>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="<?php if (Yii::app()->controller->module && Yii::app()->controller->module->id == 'widget') echo 'active'; ?>">
                <a class="dropdown-toggle" href="#">
                    <i class="icon-move"></i>
                    <span class="menu-text"> <?php echo Yii::t('widget', 'left_module_widgets'); ?> </span>
                    <b class="arrow icon-angle-down"></b>
                </a>
                <ul class="submenu">
                    <li class="<?php if (Yii::app()->controller->id == 'widget' && Yii::app()->controller->action->id == 'index') echo 'active'; ?>">
                        <a href="<?php echo Yii::app()->createUrl('/widget/widget/') ?>">
                            <i class="icon-double-angle-right"></i>
                            <?php echo Yii::t('widget', 'widget_manager') ?>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>
        <li class="<?php if (Yii::app()->controller->module && (Yii::app()->controller->module->id == 'interface' || Yii::app()->controller->module->id == 'menu') && !in_array(Yii::app()->controller->id, array('banner', 'bannergroup', 'categorypage', 'customform')) || in_array(Yii::app()->controller->action->id, array('footersetting','contact'))) echo 'active'; ?>">
            <a class="dropdown-toggle" href="#">
                <i class="icon-desktop"></i>
                <span class="menu-text"><?php echo Yii::t('common', 'interface'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li class="<?php if (Yii::app()->controller->id == 'group') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/menu/group') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('menu', 'menu_manager') ?>
                    </a>
                </li>
                <li class="<?php if (Yii::app()->controller->id == 'sitesettings' && Yii::app()->controller->action->id == 'contact') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/setting/sitesettings/contact') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('common', 'setting_contact'); ?>
                    </a>
                </li>
                <li class="<?php if (Yii::app()->controller->id == 'sitesettings' && Yii::app()->controller->action->id == 'footersetting') echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/setting/sitesettings/footersetting') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('common', 'setting_footer'); ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="<?php if (Yii::app()->controller->module && Yii::app()->controller->module->id == 'setting' && !in_array(Yii::app()->controller->action->id, array('footersetting','contact'))) echo 'active'; ?>">
            <a class="dropdown-toggle" href="#">
                <i class="icon-cogs"></i>
                <span class="menu-text"><?php echo Yii::t('common', 'setting'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li class="<?php if (Yii::app()->controller->id == 'sitesettings' && in_array(Yii::app()->controller->action->id, array('index', ''))) echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/setting/sitesettings/') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('common', 'setting_site'); ?>
                    </a>
                </li>
                <?php if ($this->site_id == 1) { ?>
                    <li class="<?php if (Yii::app()->controller->id == 'mailsettings') echo 'active'; ?>">
                        <a href="<?php echo Yii::app()->createUrl('/setting/mailsettings/') ?>">
                            <i class="icon-double-angle-right"></i>
                            <?php echo Yii::t('common', 'setting_mail'); ?>
                        </a>
                    </li>
                <?php } ?>
                <li class="<?php if (Yii::app()->controller->id == 'sitesettings' && in_array(Yii::app()->controller->action->id, array('domainsetting'))) echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/setting/sitesettings/domainsetting') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('domain', 'domain_manager'); ?>
                    </a>
                </li>
            </ul>
        </li>
        <li class="<?php if (Yii::app()->controller->module && Yii::app()->controller->module->id == 'interface' && Yii::app()->controller->id == 'customform') echo 'active'; ?>">
            <a class="dropdown-toggle" href="#">
                <i class="icon-group"></i>
                <span class="menu-text"><?php echo Yii::t('common', 'customer'); ?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu">
                <li class="<?php if (Yii::app()->controller->id == 'customform' && in_array(Yii::app()->controller->action->id, array('statistic', 'index', ''))) echo 'active'; ?>">
                    <a href="<?php echo Yii::app()->createUrl('/interface/customform/statistic') ?>">
                        <i class="icon-double-angle-right"></i>
                        <?php echo Yii::t('common', 'contact'); ?>
                    </a>
                </li>
            </ul>
        </li>

    </ul><!-- /.nav-list -->

    <div id="sidebar-collapse" class="sidebar-collapse">
        <i data-icon2="icon-double-angle-right" data-icon1="icon-double-angle-left" class="icon-double-angle-left"></i>
    </div>
</div>
