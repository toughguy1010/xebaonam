<?php if (count($products)) { ?>
    <div class="hot-product">
        <div class="title">
             <h2><?php echo $widget_title?></h2>
        </div>
        <div class="cont ">
            <?php foreach ($products as $product) { ?>
                <div class="box-hot-product clearfix">
                    <div class="box-img img-hot-product">
                        <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>"> 
                            <img alt="<?php echo $product['name'] ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's200_200/' . $product['avatar_name'] ?>"> 
                        </a>  
                    </div>
                    <div class="box-info">
                        <h4>
                            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name'] ?>">
                        <?php echo $product['name'] ?></a></h4>
                        <p class="price"><?php echo number_format($product['price'], 0, '', '.'); ?>đ</p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
}
?>