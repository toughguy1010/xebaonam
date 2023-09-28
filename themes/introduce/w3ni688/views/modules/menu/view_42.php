<div class="hang fshop-lprod-bnbot">
    <?php if (isset($data) && count($data)) { ?>
        <ul class="clearfix">
            <?php
                if (isset($data) && count($data)) foreach ($data as $menu_id => $menu) {
                    $m_link = $menu['menu_link'];
                    $img =  ClaHost::getImageHost(). $menu['icon_path']. $menu['icon_name'];
                    ?>
                    <style type="text/css">
                        .fshop-lprod-<?= $menu_id ?>:before {
                            background-image: url(<?= $img ?>) !important;
                        }
                    </style>
                    <li class="fshop-lprod fshop-lprod-<?= $menu_id ?>">
                        <a <?= $menu['target'] ? "target='_blank'" : ''; ?> href="<?= $m_link; ?>">
                           <?= $menu['menu_title']; ?>
                        </a>
                    </li>

                    <?php
                }
            ?>
        </ul>
    <?php } ?>
</div>
<style type="text/css">
    .fshop-lprod:before {
        width: 40px;
        height: 40px;
        margin-right: 6px;
        float: left;
        content: "";
        background-repeat: no-repeat;
        position: relative;
        top: -2px;
        background-size: cover;
    }
</style>
