<div class="thanhtoan1 pay-mobile">
    <?php if ($show_widget_title) { ?>
        <h2>
            <?= $widget_title; ?>
        </h2>
    <?php } ?>
</div>
<ul class="list-inline fshop-ft-httt content-pay-mobile">
    <?php
    if (isset($data) && count($data)) foreach ($data as $menu_id => $menu) {
        $m_link = $menu['menu_link'];
        $img =  ClaHost::getImageHost(). $menu['icon_path']. $menu['icon_name'];
        ?>
        <li>
            <a class="fshop-ht-martercard" <?= $menu['target'] ? "target='_blank'" : ''; ?> href="<?= $m_link; ?>">
                <img width="100%" height="100%" src="<?= $img ?>" atl="<?= $menu['menu_title'] ?>">
            </a>
        </li>
        <?php
    }
    ?>
</ul>
