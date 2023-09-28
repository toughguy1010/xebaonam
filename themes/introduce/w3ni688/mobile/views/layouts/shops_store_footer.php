<?php
$data_group = ShopStore::listGroup();
unset($data_group[0]);
$array_shop_store = array();
$shopdf = [];
?>
<div class="showroom-ft" style="clear: both;">
    <div class="cont">
        <div class="cont-list-store">
            <div class="lststorewrap">
                <ul class="list_store">

                    <?php foreach ($data_group as $key => $group) {
                        $shopstore = ShopStore::getShopByGroup($key, ['limit' => 30]);
                        if (count($shopstore)) {
                            $array_shop_store = array();
                            foreach ($shopstore as $shop) {
                                if (!$shopdf) {
                                    $shopdf = $shop;
                                }
                                $array_shop_store[$shop['province_name']][] = $shop;
                            }
                        }
                        ?>
                        <div class="group_noth_item">
                            <div class="group_noth">
                                <h2><?= $widget_title ?> <?= $group ?></h2>
                            </div>
                            <?php foreach ($array_shop_store as $key => $shops) { ?>
                                <div class="province_name"> <?= $key ?> </div>
                                <?php $i = 1;
                                foreach ($shops as $shop) { ?>
                                    <li>
                                        <span class="icon-address"><?= $i ?></span>
                                        <a href="/cua-hang,<?= $shop['id'] ?>">
                                            <span>Showroom <?= $i++ ?>: </span>
                                            <?= $shop['name'] ?>
                                        </a>
                                        <p class="box-view-shop">
                                            <span>ĐT:</span> <a
                                                    href="tel:<?= $shop['hotline'] ?>"><?= $shop['hotline'] ?></a>
                                            <a href="/cua-hang,<?= $shop['id'] ?>#cua-hang"
                                               class="view-shop"> Xem bản đồ <i class="fa fa-external-link"></i></a>
                                        </p>

                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </ul>
<!--                <div class="img_showroom">-->
<!--                    --><?php //foreach ($shopstore as $shop) { ?>
<!--                        --><?php //if ($shop['avatar_path']) { ?>
<!--                            <img src="--><?//= ClaHost::getImageHost() . $shop['avatar_path'] . 's400_400/' . $shop['avatar_name']; ?><!--">-->
<!--                            --><?php //break;
//                        } ?>
<!--                    --><?php //} ?>
<!--                </div>-->
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    ul.list_store .icon-address {
        width: 30px;
        height: 30px;
        display: block;
        float: left;
        background: #199bcc;
        color: #fff;
        border-radius: 50%;
        padding: 5px 11px;
        margin-top: 6px;
    }

    body ul.list_store li span {
        font-size: 14px;
        font-weight: bold;
    }

    body ul.list_store li a {
        font-weight: bold;
        line-height: 1.4;
    }

    body ul.list_store li > a {
        color: #000;
    }

    .tab {
        display: none;
    }

    .tab.active {
        display: block;
    }

    .group_noth h2 {
        float: left;
        width: 100%;
        margin-bottom: 10px;
        padding: 8px 0;
        background: #d52c35;
        color: #fff;
        text-align: center;
        text-transform: uppercase;
    }

    .group_noth_item {
        float: left;
        width: 100%;
        margin-bottom: 15px;
    }
</style>