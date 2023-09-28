<p class="thanhtoan1">
    <?= $group['menu_group_name'] ?>
</p>
<ul class="list-inline fshop-ft-httt">
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
