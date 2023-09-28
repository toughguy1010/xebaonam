<?php if (count($products)) { ?>
    <?php
    $n = 0;
    foreach ($products as $product) {
        ?>
        <div class="<?php echo (($n % 5) == 0) ? 'col-xs-12' : 'col-xs-6' ?> col-sm-4" style="padding: 0">
            <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>" class="item-product">
                <?php
                $status = '';
                if ($product['ishot']) {
                    $status = 'stt-hot';
                } else if ($product['isnew']) {
                    $status = 'stt-new';
                } else if ($product['state']) {
                    $status = 'stt-het';
                }
                ?>
                <i class="stt <?php echo $status ?>"></i>
                <div class="img-product"> 
                    <img alt="<?php echo $product['name']; ?>" src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>" alt="<?php echo $product['name'] ?>">
                </div>
                <h3 class="title-sp"><?php echo $product['name']; ?></h3>
                <div class="clearfix">
                    <p class="price"><?php echo ($product['price'] > 0) ? number_format($product['price'], 0, '', '.') . '₫' : 'Liên hệ'; ?></p>
                    <button class="btn btn-default buy-product" type="button">Mua</button>
                </div>
                <div class="description">
                    <?php
                    $product_infos = array();
                    if (isset($product['product_info']['product_sortdesc']) && $product['product_info']['product_sortdesc']) {
                        $ps = array();
                        $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $product['product_info']['product_sortdesc'], $matches);
                        for ($i = 0; $i < $count; ++$i) {
                            $ps[] = preg_replace('/<a[^>]*>(.*?)<\/a>/is', '', $matches[0][$i]);
                        }
                    }
                    ?>
                    <?php echo ($ps[0]) ? ('<p class="item-info">' . strip_tags($ps[0]) . '</p>') : '' ?>
                    <?php echo ($ps[1]) ? ('<p class="item-info">' . strip_tags($ps[1]) . '</p>') : '' ?>
                    <?php echo ($ps[2]) ? ('<p class="item-info">' . strip_tags($ps[2]) . '</p>') : '' ?>
                </div>
            </a>
        </div>
        <?php
        $n++;
    }
}    