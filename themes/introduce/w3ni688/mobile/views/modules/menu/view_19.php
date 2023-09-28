<?php if (isset($data) && count($data)) { ?>
    <div class="fixed-footer">
        <ul>
            <?php foreach ($data as $menu_id => $menu) { ?>
                <li>
                    <a href="<?= $menu['menu_link'] ?>"><?= $menu['menu_title']; ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>