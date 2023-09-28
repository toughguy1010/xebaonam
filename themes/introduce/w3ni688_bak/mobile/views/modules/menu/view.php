<?php
        $themUrl = Yii::app()->theme->baseUrl;
    ?>
<div class="menu-bar-mobile" tabindex="-1">
    <div class="logo-menu">
        <a href=""><img class="transition" src="<?= $themUrl?>/css/mobile/images/logo_mobile.png"></a>
    </div>


<?php foreach ($data as $menu_id => $menu) { ?>
    <div class="menu-bar-lv-1">
        <a class="a-lv-1" href="<?php echo $menu['menu_link']; ?>"><?php echo $menu['menu_title']; ?></a>
        <?php if ($menu['items'] && count($menu['items'])){ ?>
            <?php foreach ($menu['items'] as $key => $menu2){ ?>
                <div class="menu-bar-lv-2">
                    <a class="a-lv-2" href="<?php echo $menu2['menu_link']; ?>"><i class="fa fa-angle-right"></i><?php echo $menu2['menu_title']; ?></a>
                    <?php if ($menu2['items'] && count($menu2['items'])){ ?>
                        <?php foreach ($menu2['items'] as $key => $menu3){ ?>
                            <div class="menu-bar-lv-3">
                                <a class="a-lv-3" href="<?php echo $menu3['menu_link']; ?>"><i class="fa fa-angle-right"></i><i class="fa fa-angle-right"></i><?php echo $menu3['menu_title']; ?></a>
                            </div>
                        <?php } ?>
                        <span class="span-lv-2 fa fa-angle-down"></span>
                    <?php } ?>
                </div>
            <?php } ?>
            <span class="span-lv-1 fa fa-angle-down"></span>
        <?php } ?>
    </div>
<?php } ?>


</div>