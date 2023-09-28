<?php if (count($products)) { ?>
    <div class="row">
        <ul class="col-md-12 col-xs-12 col-lg-12 col-sm-12 row1 homeproduct homeproduct48" id="hotproduct48">
            <?php foreach ($products as $product) { ?>
                <li class="productmain product pbodermain pboder 0  ">
                    <div class="more-infomain">
                        <div class="mproduct product">
                            <input type="hidden" value="496" name="dataid" class="dataid">
                            <div class="product1 " id="productss">
                                <a href="<?= $product['link'] ?>" title="<?= $product['name'] ?>">
                                    <div class="product-image">
                                        <?php if($product['isnew']) {?>
                                            <span class="product-gift">
                                                <i class="iclass">
                                                    <img src="<?= Yii::app()->homeUrl; ?>themes/introduce/w3ni688/images/moi.png">
                                                </i>
                                            </span>
                                        <?php } ?>
                                        <div class="image" id="imagess">
                                            <img src="<?= ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>" alt="<?= $product['name'] ?>">
                                        </div>
                                    </div>
                                </a>
                                <div class="product-info">
                                    <h6 class="name wrap">
                                        <a class="name" href="<?= $product['link'] ?>">
                                            <?= $product['name'] ?>
                                        </a>
                                    </h6>
                                    <div class="priceInfo conPrice">
                                        <?php if($product['price_market'] > $product['price'] && $product['price'] > 0) { ?>
                                            <span class="pri1 left old-price">
                                                <?= number_format($product['price_market'], 0, '', '.') . 'đ' ?>
                                            </span>
                                            <span class="pri2 phantram right">
                                                <?= round(($product['price_market'] - $product['price'])/$product['price_market']*100) ?> %
                                            </span>
                                            <span class="pri1 left price">
                                                <?= ( $product['price'] != 0) ? (number_format($product['price'], 0, '', '.') . 'đ') : 'Liên hệ 0979662288 '; ?>
                                            </span>
                                        <?php }else{ ?>
                                            <?php 

                                            $site_info = Yii::app()->siteinfo;
                                            $phone = explode(',',  $site_info['phone']);
                                            $phone0 = isset($phone[0]) ? $phone[0] : '';
                                            $phone1 = isset($phone[1]) ? $phone[1] : '';
                                            ?>
                                            <span class="lh_a">Liên hệ : <a href="tel:<?= $phone0 ?>"> 
                                                <?php 
                                                $pos=1;
                                                while($pos){
                                                 $pos = strrpos($phone0, "."); 
                                                 if($pos){
                                                   $phone0=substr_replace($phone0,'',$pos,1);
                                               }
                                           }
                                           echo($phone0);
                                           ?>
                                       </a>
                                       </span>

                                   <?php }?>
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
                                    <div class="product_sortdesc">
                                        <?= $product['product_info']['product_sortdesc'] ?>
                                    </div>
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
            </div>
        </li>
    <?php } ?>
</ul>
</div>
<?php } ?>
<style type="text/css">
    .lh_a,.lh_a a{
            color: #FF0000;
    }
</style>