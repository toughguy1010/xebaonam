<?php if (isset($data) && count($data)) { ?>
    <?php if ($first) { ?>
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>
        <div id="sidebar" class="sidebar">
        <div id="sidebar-shortcuts" class="sidebar-shortcuts">
            &nbsp;
        </div><!-- #sidebar-shortcuts -->
        <ul class="nav nav-list">
    <?php } ?>
    <?php
    foreach ($data as $menu_id => $menu) {
        $m_link = $menu['menu_link'];
        ?>
        <li class="<?php echo (isset($menu['active']) && $menu['active']) ? 'active' : '' ?>">
            <a class="<?php if ($menu['items']) echo 'dropdown-toggle'; ?>" href="<?php echo $m_link; ?>">
                <i class="<?php echo $menu['iconclass']; ?>"></i>
                <span class="menu-text"><?php echo $menu['menu_title']; ?></span>
                <?php if ($menu['items']) { ?>
                    <b class="arrow icon-angle-down"></b>
                <?php } ?>
            </a>
            <?php if ($menu['items']) { ?>
                <ul class="submenu">
                    <?php
                    $this->render($this->view, array(
                        'data' => $menu['items'],
                        'first' => false,
                    ));
                    ?>
                </ul>
            <?php } ?>
        </li>
    <?php } ?>
    <?php if ($first) { ?>
        </ul><!-- /.nav-list -->
        
        <div id="sidebar-collapse" class="sidebar-collapse">
            <i data-icon2="icon-double-angle-right" data-icon1="icon-double-angle-left"
               class="icon-double-angle-left"></i>
        </div>
        <?php //echo $this->render('storage_used');?>
        </div>
    <?php } ?>
<?php } ?>