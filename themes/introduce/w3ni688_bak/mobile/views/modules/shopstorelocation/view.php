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
    body ul.list_store li>a {
        color: #000;
    }
</style>
<?php
$array_shop_store = array();
$shopdf = [];
if (count($shopstore)) {
    $array_shop_store = array();
    foreach ($shopstore as $shop) {
        if(!$shopdf) {
            $shopdf = $shop;
        }
        $array_shop_store[$shop['province_name']][] = $shop;
    }
}
?>
<div class="showroom-ft" style="clear: both;">
    <div class="cont">
        <?php if (count($array_shop_store)) { ?>
            <div class="cont-list-store">
                <div class="lststorewrap">
                    <ul class="list_store">
                        
                        <?php foreach ($array_shop_store as $key => $shops) { ?>
                        <div class="province_name"><?= $widget_title ?> <?= $key ?> </div>
                        
                        <?php $i=1; foreach ($shops as $shop) { ?>
                            <li>
                                <span class="icon-address"><?= $i ?></span>
                                <a href="/cua-hang,<?= $shop['id'] ?>">
                                    <span>Showroom <?= $i++ ?>: </span>
                                    <?= $shop['name'] ?>
                                </a>
                                <p class="box-view-shop">
                                    <span>Tư vấn:</span> <a href="tel:<?= $shop['hotline'] ?>"><?= $shop['hotline'] ?></a>
                                    <a href="/cua-hang,<?= $shop['id'] ?>#cua-hang"
                                   class="view-shop"> Xem bản đồ <i class="fa fa-external-link"></i></a>
                                </p>
                               
                            </li>
                        <?php } ?>
                        <?php } ?>
                    </ul>
                    <div class="img_showroom">
                        <?php foreach ($shopstore as $shop) { ?>
                            <?php if($shop['avatar_path']){ ?>
                                <img src="<?= ClaHost::getImageHost() . $shop['avatar_path'] . 's400_400/' . $shop['avatar_name']; ?>">
                            <?php break;} ?>
                        <?php }?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
