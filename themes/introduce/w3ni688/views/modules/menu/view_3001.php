<?php if (isset($data) && count($data)) {?>
<div class="menu_pc">
    <ul>
        <?php foreach ($data as $menu_id => $menu) {?>
            <li>
                <a href="<?= $menu['menu_link'] ?>" ><?= $menu['menu_title']; ?> </a>
                 <?php if ($menu['items']) { ?>
                <ul>
                    <?php foreach ($menu['items'] as $menu_child) {?>
                    <li>
                        <a href="<?= $menu_child['menu_link'] ?>"><?= $menu_child['menu_title'];?></a>
                    </li>
                    <?php }?>
                </ul>
                <?php }?>
            </li>
        <?php }?>
    </ul>
</div>
<?php }?>