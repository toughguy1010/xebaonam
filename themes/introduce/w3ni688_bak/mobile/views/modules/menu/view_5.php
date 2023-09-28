<?php if (count($data)) { ?>
    <div class="category-news-bike">
        <ul class="clearfix">
            <?php
            foreach ($data as $menu_id => $menu) {
                $m_link = $menu['menu_link'];
                ?>
                <li class="<?php echo ($menu['items']) ? 'has-sub' : ''; ?> <?php echo ($menu['active']) ? 'active' : '' ?>">
                    <a href="<?php echo $m_link; ?>" title="<?php echo $menu['menu_title']; ?>">
                        <?php echo $menu['menu_title']; ?>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
    </div>
<?php } ?>
