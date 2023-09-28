<div class="menu-bar-mobile" tabindex="-1">
    <div class="logo-menu">
        <a href="<?php echo Yii::app()->homeUrl; ?>" title="<?php echo Yii::app()->siteinfo['site_title']; ?>">
            <img alt="<?php echo Yii::app()->siteinfo['site_title']; ?>"
                 src="<?php echo Yii::app()->siteinfo['site_logo']; ?>">
        </a>
    </div>
  
   
    <?php foreach ($data as $key => $menu) { ?>
        <div class="menu-bar-lv-1">
            <a class="a-lv-1" href="<?= $menu['menu_link'] ?>" <?= $menu['target'] ?>><?= $menu['menu_title'] ?></a>
            <?php if ($menu['items'] && count($menu['items'])) { ?>
              
                <?php foreach ($menu['items'] as $key => $menu2) { ?>
                    <div class="menu-bar-lv-2">
                        <a class="a-lv-2" href="<?= $menu2['menu_link'] ?>" <?= $menu2['target'] ?>>
                            <i class="fa fa-angle-right"></i><?= $menu2['menu_title'] ?>  </a>
                        <?php if ($menu2['items'] && count($menu2['items'])) { ?>
                            <div class="menu-bar-lv-3">
                                <?php foreach ($menu2['items'] as $key => $menu3) { ?>
                                    <a class="a-lv-3" href="<?= $menu3['menu_link'] ?>" <?= $menu3['target'] ?>><i
                                                class="fa fa-angle-right"></i><i
                                                class="fa fa-angle-right"></i><?= $menu3['menu_title'] ?></a>
                                <?php } ?>
                            </div>
                            <?php echo ($menu2['items']) ? '<span class="span-lv-2 fa fa-angle-down"></span>' : ''; ?>
                        <?php } ?>
                    </div>
                <?php } ?>
                <span class="span-lv-1 fa fa-angle-down"></span>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<div class="shadow-open-menu"></div>
<div class="menu-btn-show">
    <span class="border-style"></span>
    <span class="border-style"></span>
    <span class="border-style"></span>
</div>


