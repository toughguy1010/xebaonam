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
<?php if (count($array_shop_store)) { ?>
    <div class="container-fluid morefooter">
        <div class="container">
            <div class="row">
                <div id="" class="col-md-12 col-sm-12 col-xs-12 col-lg-12">
                    <div class="nopadding" id="more-footer">
                        <div class="row moreadd">
                            <ul class="col-md-4 col-sm-4 col-xs-4 house">
                                <?php 
                                $i = 1;
                                foreach ($array_shop_store as $key => $shops) { ?>
                                    <div class="rg01">
                                        <a>
                                            <span>
                                                <?= $key ?>
                                            </span>
                                        </a>
                                    </div>
                                    <?php foreach ($shops as $shop) { ?>
                                        <li class="lii<?= $i++ ?>">
                                            <a href="<?= $shop['link'] ?>" data-title="<?= $shop['name'] ?>" data-img="<?= ClaHost::getImageHost() . $shop['avatar_path'] . 's400_400/' . $shop['avatar_name']; ?>" class="thumimg2">
                                                <p style="width:100%;">
                                                    <i class="s fa fa-map-marker">
                                                    </i>
                                                    <?= $shop['name'] ?>
                                                </p>
                                            </a>
                                        </li>
                                    <?php } ?>
                               <?php } ?>
                            </ul>
                            <ul class="col-md-4 col-sm-4 col-xs-4">
                                <?php if($shopdf) { ?>
                                    <div class="rg01">
                                        <a>
                                            <span id="textId" style="color:red;">
                                                <?= $shopdf['name'] ?>
                                            </span>
                                        </a>
                                    </div>
                                    <div class="mainmap imgmap">
                                        <img id="view-img2" src="<?= ClaHost::getImageHost() . $shopdf['avatar_path'] . 's400_400/' . $shopdf['avatar_name']; ?>" alt="<?= $shopdf['name'] ?>">
                                    </div>
                                <?php } ?>
                            </ul>
                            <ul class="col-md-4 col-sm-4 col-xs-4 text-left ht">
                                <div class="mainmap imgmap allicon" style="height:290px;margin-top:40px;">
                                    <?php
                                        $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_DETAIL_BLOCK5));
                                    ?>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>