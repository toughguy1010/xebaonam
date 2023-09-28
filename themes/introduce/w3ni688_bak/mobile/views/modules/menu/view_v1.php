<?php
if (isset($data) && count($data)) {
    ?>
    <?php
    foreach ($data as $menu_id => $menu) {
        $m_link = $menu['menu_link'];
        ?>
        <li class="item-nav">
            <a href="<?php echo $m_link; ?>" title="<?php echo $menu['menu_title']; ?>">
                <div class="icon-nav">
                    <?php if ($menu['background_path'] && $menu['background_name']) { ?>
                        <img src="<?php echo ClaHost::getImageHost(), $menu['background_path'], $menu['background_name'] ?>" alt="<?php echo $menu['menu_title']; ?>">
                    <?php } else { ?>
                        <img src="<?php echo ClaHost::getImageHost(), $menu['icon_path'], $menu['icon_name'] ?>" alt="<?php echo $menu['menu_title']; ?>">
                    <?php } ?>
                </div>  <?php echo $menu['menu_title']; ?></a>
        </li>

        <?php
    }
    ?>
    <?php
}
