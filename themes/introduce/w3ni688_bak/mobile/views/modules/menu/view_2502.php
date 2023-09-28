<?php
if (isset($data) && count($data)) {
    foreach ($data as $menu_id => $menu) {
        $m_link = $menu['menu_link'];
        ?>
        <div class="col-xs-3">
            <a  href="<?php echo $m_link; ?>" title="<?php echo $menu['menu_title']; ?>" class="box-action"> 
                <h5><?php echo $menu['menu_title']; ?></h5>
                <span><?php echo $menu['description']; ?></span>
            </a>
        </div>
        <?php
    }
}
?>