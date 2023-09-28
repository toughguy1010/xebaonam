<?php
if (isset($data) && count($data)) {
    ?>
    <div class="box-product">
        <div class="cont-box-product">
            <div class="row">
                <?php foreach ($data as $product) {
                    ?>
                    <div class="col-xs-6 col-sm-4">
                        <a href="<?php echo $product['link'] ?>" title="<?php echo $product['name']; ?>"
                           class="item-product">
                            <?php
                            $status = '';
                            if ($product['ishot']) {
                                $status = 'stt-hot';
                            } else if ($product['isnew']) {
                                $status = 'stt-new';
                            }
                            ?>
                          <!--   <i class="stt <?php echo $status ?>"></i> -->
                            <div class="img-product"><img alt="<?php echo $product['name']; ?>"
                                                          src="<?php echo ClaHost::getImageHost() . $product['avatar_path'] . 's300_300/' . $product['avatar_name'] ?>"
                                                          alt="<?php echo $product['name'] ?>">
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
                <?php } ?>
            </div>
            <div class='box-product-page clearfix'>
                <?php
                $this->widget('common.extensions.LinkPager.LinkPager', array(
                    'itemCount' => $totalitem,
                    'pageSize' => $limit,
                    'header' => '',
                    'selectedPageCssClass' => 'active',
                ));
                ?>
            </div>
        </div>
    </div>
<?php } ?>