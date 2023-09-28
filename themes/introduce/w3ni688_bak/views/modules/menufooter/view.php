<?php if ($show_widget_title) { ?>
    <h2><?php echo $widget_title ?></h2>
<?php } ?>
<ul class="">
    <?php
    foreach ($data as $menu_id => $menu) {
        $i++;
        if ($i > $cols) {
            break;
        }
        ?>
        <li class="">

            <a href="<?php echo $menu['menu_link']; ?>" <?= $menu['menu_target']?> title="<?php echo $menu['menu_title']; ?>"><?php echo $menu['menu_title']; ?></a>
        </li>
    <?php } ?>                                 
</ul>
