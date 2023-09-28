<?php if ($show_widget_title) { ?>
    <div class="title-cont-detail">
        <h3><span><?php echo $widget_title ?></span></h3>
    </div>
<?php } ?>
<div class="style-detail">
    <ul>
        <?php foreach ($data as $menu_id => $menu) { ?>
            <li class=""> <span><?php echo $menu['menu_title'] ?></span> </li>
        <?php } ?>
    </ul>
</div>