<?php if (count($products)) { ?>
    <div class="row">
        <ul class="col-md-12 col-xs-12 col-lg-12 col-sm-12 row1 homeproduct" id="mainItem">
            <?php foreach ($products as $product) { ?>
                <li class="productmain product pbodermain pboder 0  ">
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
                                                <img src="<?= Yii::app()->homeUrl; ?>themes/introduce/w3ni688/images/moi.png">
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
                                            <span>
                                                -Tặng mũ bảo hiểm trị giá 220.000 đ.<span>
                                                    <span style="">
                                                        - Trả góp lãi xuất thấp<span>
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
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
                        <div class="sspro1 text-right">
                            <button id="sspro" href="#" rel="nofollow" class="append text-right">
                                Chọn so sánh 
                            </button>
                        </div>
                        <div class="moreinfokt">
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
                        </div>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>