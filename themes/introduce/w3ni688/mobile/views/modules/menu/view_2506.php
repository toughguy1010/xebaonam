<?php if (isset($data) && count($data)) { ?>
    <div class="category-product">

        <ul>
            <?php
            foreach ($data as $menu_id => $menu) {
                $m_link = $menu['menu_link'];
                ?>
                <li><a class=" <?php echo ($menu['active']) ? 'active' : '' ?>" title="<?php echo $menu['menu_title']; ?>" href="<?php echo $m_link; ?>"><?php echo $menu['menu_title']; ?></a></li>
                <?php
            }
            ?>
        </ul>
    </div>

<?php } ?>