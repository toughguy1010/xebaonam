<div class="menu_top">
    <a onclick="$('.ul_js_to').toggle()" class="a_menu_mobile cur"><i class="fa fa-bars"></i> Menu</a>
    <ul class="ul_js_to">
        <?php foreach ($data as $key => $menu) { ?>
        <li>
            <a href="<?= $menu['menu_link'] ?>" <?= $menu['target'] ?>>
                <?php if ($menu['icon_path'] && $menu['icon_name']) { ?>
                <img src="<?= ClaHost::getImageHost() . $menu['icon_path'] . $menu['icon_name'] ?>"
                        alt="<?= $menu['menu_title'] ?>">
                <?php } ?>
                <?= $menu['menu_title'] ?>
            </a>
        </li>
        <?php } ?>
        <div class="clr"></div>
    </ul>
</div>