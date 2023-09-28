<?php
if (isset($data) && count($data)) {
    ?>

    <?php if ($first && $show_widget_title) { ?>
        <div class="panel panel-default menu-horizontal">
            <div class="panel-heading">
                <h3><?php echo $widget_title; ?></h3>
            </div>
            <div class="panel-body">
            <?php } ?>
            <ul class="menu <?php if ($first && $directfrom) echo 'menu-align-right'; ?>">
                <?php
                foreach ($data as $menu_id => $menu) {
                    $m_link = $menu['menu_link'];
                    ?>
                    <li class="<?php echo ($menu['items']) ? 'submenu' : ''; ?> <?php echo ($menu['active']) ? 'active' : '' ?>" >
                        <a href="<?php echo $m_link; ?>" <?php echo $menu['target']; ?> title="<?php echo $menu['description']; ?>">
                            <?php if ($menu['icon_path'] && $menu['icon_name']) { ?>
                                <img class="menu-icon" src="<?php echo ClaHost::getImageHost() . $menu['icon_path'] . $menu['icon_name']; ?>" />
                            <?php } ?>
                            <?php echo $menu['menu_title']; ?>
                        </a>
                        <?php
                        $this->render($this->view, array(
                            'data' => $menu['items'],
                            'first' => false,
                        ));
                        ?>
                    </li>
                <?php } ?>
            </ul>        
        <?php } ?>
        <?php if ($first && $show_widget_title) { ?>
        </div>
    </div>
<?php } ?>