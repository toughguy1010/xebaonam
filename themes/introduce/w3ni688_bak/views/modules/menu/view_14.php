<div  class="colfoot col-lg-2 col-md-2 col-sm-2 col-xs-2">
    <h2 class="title-ft">
        <?= $group['menu_group_name'] ?>
    </h2>
    <?php if (isset($data) && count($data)) { ?>
        <ul>
            <?php
                if (isset($data) && count($data)) foreach ($data as $menu_id => $menu) {
                    $m_link = $menu['menu_link'];
                    ?>
                    <li>
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

