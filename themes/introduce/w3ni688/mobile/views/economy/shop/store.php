<?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
<?php
if (count($stores)) {
    $array_shop_store = array();
    foreach ($stores as $each_shopstore) {
        $array_shop_store[$each_shopstore['group']][$each_shopstore['province_name']][] = $each_shopstore;
    }
    ?>

    <div class="cont-list-store">
        <div class="lststorewrap">
            <ul class="list_store">
                <?php
                foreach ($array_shop_store[1] as $key => $each_gr_shop_stores) {
                    echo '<div class="province_name">' . $key . '</div>';
                    foreach ($each_gr_shop_stores as $each_gr_shop_store) {
                        ?>
                        <li>
                            <a href="/cua-hang,<?php echo $each_gr_shop_store['id'] ?>"><span>• </span><?php echo $each_gr_shop_store['name'] ?></a>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
    
<?php } ?>
