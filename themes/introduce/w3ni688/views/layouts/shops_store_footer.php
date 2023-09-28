<?php

    $data_group = ShopStore::listGroup();
    unset($data_group[0]);
    $array_shop_store = array();
    $shopdf = [];
    ?>
    <div class="addres_shop">
        <div class="">
            <div class="list_item">

                <div class="item_address">
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
                        <div class="scrollable">
                            <div class="group_noth_item">
                                <div class="group_noth">
                                    <h2><?= $group ?></h2>
                                </div>
                                <?php if( isset($_GET['fix']) && $_GET['fix'] == true ) { ?>
                                    <div class="group_noth_search">
                                        <input type="text" placeholder="Tìm kiếm">
                                        <a href="javascript:void(0)"><i class="fa fa-search text-danger" aria-hidden="true"></i></a>
                                    </div>
                                <?php } ?>
                                <?php foreach ($array_shop_store as $key => $shops) { ?>
                                    <h3><?= $key ?></h3>
                                    <?php
                                    $i = 1;
                                    foreach ($shops as $shop) { ?>
                                        <a href="<?= Yii::app()->createUrl('economy/shop/storedetail', ['id' => $shop['id']]) ?>"
                                        data-img="<?= ClaHost::getImageHost() . $shop['avatar_path'] . 's400_400/' . $shop['avatar_name']; ?>">
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span><strong style="color: #d52c35"><?= $i++ ?>.</strong>  <?= $shop['name'] ?></span>
                                        </a>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="item_address">
                    <h3>Hà Nội</h3>
                    <div class="img_big_shop">
                        <?php
                        $shopstore1 = ShopStore::getShopByGroup(1, ['limit' => 30]);
                        if (count($shopstore1)) {
                            $array_shop_store1 = array();
                            foreach ($shopstore1 as $shop) {
                                if (!$shopdf) {
                                    $shopdf = $shop;
                                }
                                $array_shop_store1[$shop['province_name']][] = $shop;
                            }
                        }
                        $i = 0;
                        foreach ($array_shop_store1 as $key => $shops) {
                            ?>
                            <?php foreach ($shops as $shop) {
                                $i++;
                                if ($i == 1) { ?>
                                    <div class="tab <?= ($i == 1) ? 'active' : '' ?>">
                                        <?php $shop1 = ShopStore::model()->findByPk($shop['id']);
                                        $img = $shop1->getImages(); ?>
                                        <div class="slider_main">
                                            <section class="big_albums  slider-for">
                                                <?php foreach ($img as $s) { ?>

                                                    <div class="item">
                                                        <img class="img-lazyy"
                                                            data-lazy="<?= ClaHost::getImageHost() . $s['path'] . 's400_400/' . $s['name']; ?>"
                                                            alt="<?= $shop['name'] ?>">
                                                    </div>
                                                <?php } ?>

                                            </section>
                                            <section class="small_albums  slider-nav">
                                                <?php foreach ($img as $s) { ?>
                                                    <div class="item">
                                                        <img class="img-lazyy"
                                                            data-lazy="<?= ClaHost::getImageHost() . $s['path'] . 's400_400/' . $s['name']; ?>"
                                                            alt="<?= $shop['name'] ?>">
                                                    </div>
                                                <?php } ?>
                                            </section>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        <?php } ?>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <style type="text/css">
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
            padding: 15px 0;
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

            <style type="text/css">
                .addres_shop {
                    margin-bottom: 30px;
                }
                .addres_shop .list_item {
                    flex-direction: column-reverse;
                }

                .addres_shop .item_address {
                    width: 100%;
                }

                .group_noth h2 {
                    float: unset;
                }

                .addres_shop .item_address:last-child {
                    display: none;
                }

                .addres_shop .item_address:first-child {
                    overflow-y: unset !important;
                    padding: 0;
                    display: flex;
                    border-top: 1px solid rgba(142, 142, 142, 0.25);
                    margin-bottom: 15px;
                    padding-top: 15px;
                }

                .addres_shop .item_address:first-child .group_noth_item {
                    padding: 0 15px;
                }

                .addres_shop .item_address .group_noth_search {
                    margin-bottom: 1rem;
                    border: 1px solid #999;
                    width: 100%;
                    font-size: 14px;
                    position: relative;
                }

                .addres_shop .item_address .group_noth_search input[type="text"] {
                    width: 100%;
                    font-size: 14px;
                    margin: 0;
                    padding: .5rem;
                    padding-right: 40px;
                    height: 100%;
                    height: 34px;
                    border: unset;
                }

                .addres_shop .item_address .group_noth_search input[type="text"]:hover,
                .addres_shop .item_address .group_noth_search input[type="text"]:active,
                .addres_shop .item_address .group_noth_search input[type="text"]:focus {
                    outline: unset;
                    box-shadow: unset;
                }

                .addres_shop .item_address .group_noth_search a {
                    position: absolute;
                    right: 0;
                    top: 0;
                    width: 3rem;
                    border: unset !important;
                    border-radius: 0 !important;
                    height: 34px;
                    width: 34px;
                    display: inline-flex !important;
                    justify-content: center;
                    align-items: center;
                }

                .addres_shop .item_address .group_noth_search a:hover {
                    text-decoration: none;
                }

                .addres_shop .item_address .group_noth_search a > i{
                    font-size: 14px;
                    margin: 0;
                }

                .addres_shop .scrollable {
                    width: 100%;
                    overflow-y: scroll;
                }

                /* width */
                .addres_shop .scrollable::-webkit-scrollbar {
                    width: 8px;
                }

                /* Track */
                .addres_shop .scrollable::-webkit-scrollbar-track {
                    background: #f1f1f1;
                }

                /* Handle */
                .addres_shop .scrollable::-webkit-scrollbar-thumb {
                    background: #888;
                }

                /* Handle on hover */
                .addres_shop .scrollable::-webkit-scrollbar-thumb:hover {
                    background: #555;
                }
            </style>