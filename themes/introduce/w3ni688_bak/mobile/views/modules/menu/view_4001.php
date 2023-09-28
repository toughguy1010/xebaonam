<?php
if (isset($data) && count($data)) {
    ?>
    <?php if ($show_widget_title) { ?>
        <h5><?php echo $widget_title ?>:</h5>
    <?php } ?>
    <ul class="clearfix fix-menu-tag">
        <?php
        foreach ($data as $menu_id => $menu) {
            $m_link = $menu['menu_link'];
            ?>
            <li><a href="<?php echo $m_link; ?>" title="<?php echo $menu['menu_title']; ?>"><?php echo $menu['menu_title']; ?> <span>, </span></a></li>
            <?php
        }
        ?>
    </ul>
    <?php
}
