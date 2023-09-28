<?php if (count($shops)) { ?>
    <div class="favorite-store">
        <div class="cont">
            <div class="row">
                <?php
                foreach ($shops as $shop) {
                    ?>
                    <div class="col-sm-6">
                        <div class="box-favorite-store clearfix">
                            <div class="avt-ch">
                                <a href="<?php echo $shop['link'] ?>" title="<?php echo $shop['description'] ?>">
                                    <img src="<?php echo ClaHost::getImageHost(), $shop['image_path'], 's330_330/', $shop['image_name']; ?>" />
                                </a>
                            </div>
                            <div class="store-info">
                                <div class="name-stand">
                                    <h3><a href="<?php echo $shop['link'] ?>"><?php echo $shop['name']; ?></a></h3>
                                </div>
                                <div class="ttlh">
                                    <div class="registered-action mua">
                                        <a style="cursor: pointer" data-toggle="modal" data-target=".bs-example-modal-sm-mua-<?php echo $shop['id'] ?>">Thông tin liên hệ</a>
                                        <div class="modal fade bs-example-modal-sm-mua-<?php echo $shop['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                            <div class="modal-dialog modal-sm-muaa-<?php echo $shop['id'] ?>">
                                                <div class="modal-content ">
                                                    <div class="header-popup clearfix"> <i class="icon-popup"></i>
                                                        <div class="title-popup">Thông tin liên hệ</div>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                                    </div>
                                                    <div class="cont">
                                                        <?php echo $shop['contact']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="box-product-page clearfix">
            <div class="product-page" style="float:right; max-width: 500px; text-align: right; ">
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