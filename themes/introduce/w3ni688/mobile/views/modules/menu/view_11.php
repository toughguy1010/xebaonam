<?php if (isset($data) && count($data)) { ?>
    <ul class="menu-repairs clearfix">
        <?php
        foreach ($data as $menu_id => $menu) {
            $m_link = $menu['menu_link'];
            ?>
            <li class=" <?php echo ($menu['active']) ? 'active' : '' ?>"><a  title="<?php echo $menu['menu_title']; ?>" href="<?php echo $m_link; ?>"><?php echo $menu['menu_title']; ?></a></li>
            <?php
        }
        ?>
    </ul>
<?php
}