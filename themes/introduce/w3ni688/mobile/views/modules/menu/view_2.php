<?php if (isset($data) && count($data)) { ?>
    <div class="box-right">
        <?php if ($show_widget_title) { ?>
            <div class="title">
                <h2><?php echo $widget_title ?></h2>
            </div>
        <?php } ?>
        <div class="cont">
            <ul>
                <?php foreach ($data as $menu_id => $menu) { ?>
                    <li><img src="<?php echo ClaHost::getImageHost() . $menu['icon_path'] . $menu['icon_name'] ?>" /><h4><?php echo $menu['menu_title']; ?></h4></li>
                <?php } ?>
            </ul>
        </div>
    </div>
    <?php }
?>