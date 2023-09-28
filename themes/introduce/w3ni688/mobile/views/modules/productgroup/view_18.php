<?php if (count($products)) { ?>
    <div class="customer_mobile ptch ptchinhhang">
        <div class="title_list_car">
            <h2>
                <a href="<?= $link; ?>">
                    <span>
                        <?= $group['name']; ?>
                    </span>
                </a>
            </h2>
        </div>
        <div class="list-item-customer customer-img owl-carousel">
            <?php foreach ($products as $product) { ?>
                <div class="item-customer">
                    <div class="img">
                        <div class="cover">
                            <a href="<?= $product['link'] ?>" title="<?= $product['name'] ?>">
                                <img alt="<?= $product['news_title'] ?>" src="<?= ClaHost::getImageHost() . $product['avatar_path'] . 's500_500/' . $product['avatar_name'] ?>" />
                            </a>
                        </div>
                    </div>
                    <div class="text">
                        <a href="<?= $product['link'] ?>" title="<?= $product['name'] ?>">
                            <h2><?= $product['name'] ?></h2>
                        </a>
                        <p class="price_news"><?= $product['price'] > 0 ? $product['price_text'] : 'Liên hệ' ?></p>
                        <!-- <p class="price_old">15.500.000 VNĐ</p> -->
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="clear">
        </div>
    </div>
<?php } ?>