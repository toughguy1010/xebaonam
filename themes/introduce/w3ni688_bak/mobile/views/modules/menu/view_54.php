<?php
if (isset($data) && count($data)) {
    ?>
    <ul class="commitment-mobile">
        <?php
        foreach ($data as $menu_id => $menu) {
            $m_link = $menu['menu_link'];
            ?>
            <li class="item-nav">
                <a href="<?php echo $m_link; ?>" title="<?php echo $menu['menu_title']; ?>">
                    <div class="bg-icon-commitment">
                        <img src="<?php echo ClaHost::getImageHost(), $menu['background_path'], $menu['background_name'] ?>"
                             alt="<?php echo $menu['menu_title']; ?>">
                    </div>
                    <div class="text-t">
                        <?php echo $menu['menu_title']; ?>
                    </div>
                </a>

            </li>
        <?php } ?>
    </ul>
<?php } ?>
