<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="moreproduct">
            <?php if (isset($data) && count($data)) 
                foreach ($data as $menu_id => $menu) {
                $m_link = $menu['menu_link'];
                $img =  ClaHost::getImageHost(). $menu['icon_path']. $menu['icon_name'];
                ?>
                <a href="<?= $m_link; ?>" <?= $menu['target'] ? "target='_blank'" : ''; ?>>
                    <span>
                        <?= $menu['description'] ?>
                    </span>
                    <?= $menu['menu_title'] ?>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
