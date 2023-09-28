
<div class="item">
    <h3> <?= $group['menu_group_name'] ?></h3>
    <div class="list_car list_carv">
        <?php
        if (isset($data) && count($data)) foreach ($data as $menu_id => $menu) {
            $m_link = $menu['menu_link'];
            
            ?>
            <a href="<?= $m_link; ?>"><?= $menu['menu_title'] ?></a>
            <?php
        }
        ?>
    </div>
    <div class="ms">
       <?php $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_FOOTER_BLOCK4)); ?>
    </div>
</div>