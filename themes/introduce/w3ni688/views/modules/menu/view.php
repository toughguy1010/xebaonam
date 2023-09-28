<?php
if (isset($data) && count($data)) {
    ?>
    <ul class="">
        <?php
        foreach ($data as $menu_id => $menu) {
            $m_link = $menu['menu_link'];
            ?>
            <li class="<?php echo ($menu['items']) ? 'has-sub' : ''; ?> <?php echo $menu['target']; ?>  <?php echo ($menu['active']) ? 'active' : '' ?>">
                <a href="<?php echo $m_link; ?>" title="<?php echo $menu['menu_title']; ?>">
                    <?php if ($menu['icon_path'] && $menu['icon_name']) { ?>
                        <!--<img src="<?php echo ClaHost::getImageHost(), $menu['icon_path'], $menu['icon_name'] ?>" alt="<?php echo $menu['menu_title']; ?>">-->
                    <?php } ?>
                    <!--<br/>-->
                    <?php echo $menu['menu_title']; ?>
                </a>
                <?php
                $this->render($this->view, array(
                    'data' => $menu['items'],
                    'first' => false,
                ));
                ?>
            </li>
            <?php
        }
        ?>
    </ul>
    <?php
}
