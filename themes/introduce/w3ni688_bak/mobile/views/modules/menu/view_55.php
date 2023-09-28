<?php
if (isset($data) && count($data)) {
    ?>
    <div class="box-policies">
        <?php if ($show_widget_title) { ?>
            <div class="title-poli">
                <h2><?php echo $widget_title ?></h2>
            </div>
        <?php } ?>
        <ul class="policies-mobile">
            <?php
            foreach ($data as $menu_id => $menu) {
                $m_link = $menu['menu_link'];
                ?>
                <li>
                    <a href="<?php echo $m_link; ?>" title="<?php echo $menu['menu_title']; ?>">
                        <?php echo $menu['menu_title']; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>

