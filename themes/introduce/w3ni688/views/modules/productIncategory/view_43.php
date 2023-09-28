
<?php if (count($products)) {
    foreach ($products as $key => $value) {
        $product_top_id = $key;
        break;
    }
    $product_top = $products[$product_top_id];
    unset($products[$product_top_id]);
?>
<pre>
<?php echo "sadsadsad" ;print_r($product_top); ?>
</pre>
<ul class="row1 homeproduct">
    <li class="productmain product pbodermain pboder" style="width:100%;">
        <span class="product-gif">
            <span>
                <img src="https://xedien.com.vn/style/img/gif.gif">
            </span>
        </span>
        <input type="hidden" value="493" name="dataid" class="dataid">
        <a href="<?= $product_top['link'] ?>">
            <img src="<?= ClaHost::getImageHost() . $product_top['avatar_path'] . 's500_500/' . $product_top['avatar_name'] ?>" alt="<?= $product_top['name'] ?>">
        </a>
        <div class="num_view2">
            <label>
                Hơn <?= $product_top['viewed'] ?> lượt xem tuần qua
            </label>
        </div>
        <!-- <div class="sspro2 text-right">
            <button id="sspro" href="#" rel="nofollow" class="append text-right">
                Chọn so sánh 
            </button>
        </div>
        <div class="moreinfokt">
            <a href="/xe-dien-vespas-dibao-2018.html">
                <span>
                    <i class="fa fa-check" aria-hidden="true">
                    </i>
                    5 acquy 20A
                </span>
                <span>
                    <i class="fa fa-check" aria-hidden="true">
                    </i>
                    Xuất xứ: <span>
                        Xe điện Dibao
                    </span>
                </span>
                <span>
                    <i class="fa fa-check" aria-hidden="true">
                    </i>
                    Công xuất: <span>
                        1000W(max 1500W)
                    </span>
                </span>
                <span>
                    <i class="fa fa-check" aria-hidden="true">
                    </i>
                    Quãng đường đi được: <span>
                        80-100km/ 1 lần sạc
                    </span>
                </span>
            </a>
        </div> -->
    </li>
    <?php if($products) foreach ($products as $product) { ?>
        <li class="productmain product pbodermain pboder " style="width:50%;">
            <div class="more-infomain">
                <div class="mproduct product">
                    <input type="hidden" value="496" name="dataid" class="dataid">
                    <div class="product1 " id="productss">
                        <a href="<?= $product['link'] ?>" title="<?= $product['name'] ?>">
                            <div class="product-image">
                                <span class="product-gif">
                                    <span>
                                        <img src="https://xedien.com.vn/style/img/gif.gif">
                                    </span>
                                </span>
                                <span class="product-gift">
                                    <i class="iclass">
                                        <img src="https://xedien.com.vn/style/img/moi.png">
                                    </i>
                                </span>
                                <div class="image" id="imagess">
                                    <img src="<?= ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
                                </div>
                            </div>
                        </a>
                        <div class="product-info">
                            <h6 class="name wrap">
                                <a class="name" href="/xe-dien-m133-sport-2017.html" title="<?= $product['link'] ?>">
                                    <?= $product['name'] ?>
                                </a>
                            </h6>
                            <div class="priceInfo conPrice">
                                <?php if($product['price_market'] > $product['price'] && $product['price'] > 0) { ?>
                                    <span class="pri1 left old-price">
                                        <?= number_format($product['price_market'], 0, '', '.') . 'đ' ?>
                                    </span>
                                    <span class="pri2 phantram right">
                                        <?= round(($product['price_market'] - $product['price'])/$product['price']*100) ?>
                                    </span>
                                <?php } ?>
                                <span class="pri1 left price">
                                    <?= number_format($product['price'], 0, '', '.') . 'đ' ?>
                                </span>
                            </div>


                            <div class="priceInfo">
                                <span style="padding-top:0px;padding-left:10px;padding-bottom:0px;float:left;">
                                    <span style="color:#2DCC70;">
                                        Còn hàng
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="texthome text-left gif">
                    <table class="">
                        <tbody>
                            <tr>
                            </tr>
                            <tr>
                                <td>
                                    <i class="fa fa-gift">
                                    </i>
                                </td>
                                <td>
                                    <?= $product['ìn'] ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="num_view">
                    <label>
                        Hơn <?= $product['viewed'] ?> lượt xem tuần qua
                    </label>
                </div>
              <!--   <div class="sspro1 text-right">
                    <button id="sspro" href="#" rel="nofollow" class="append text-right">
                        Chọn so sánh 
                    </button>
                </div> -->
                <!-- <div class="moreinfokt">
                    <a href="/xe-dien-m133-sport-2017.html">
                        <span>
                            <i class="fa fa-check" aria-hidden="true">
                            </i>
                            4 acquy 12A
                        </span>
                        <span>
                            <i class="fa fa-check" aria-hidden="true">
                            </i>
                            Xuất xứ: <span>
                                Liên doanh Việt Nam lắp ráp
                            </span>
                        </span>
                        <span>
                            <i class="fa fa-check" aria-hidden="true">
                            </i>
                            Công xuất: <span>
                                250W
                            </span>
                        </span>
                    </a>
                </div> -->
            </div>
        </li>
    <?php } ?>
</ul>
<?php } ?>

