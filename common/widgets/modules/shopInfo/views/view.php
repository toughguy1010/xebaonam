<div class="information-stand">
    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <div class="box-avatar">
                    <?php if ($shop['avatar_path'] && $shop['avatar_name']) { ?>
                        <img src="<?php echo ClaHost::getImageHost(), $shop['avatar_path'], 's150_150/', $shop['avatar_name']; ?>" />
                    <?php } ?>
                </div>
                <div class="information-stand-info">
                    <div class="title-stand clearfix">
                        <h2><a href="javascript:void(0)" title="<?php echo $shop['name']; ?>"><?php echo $shop['name']; ?></a></h2>
                        <?php if ($liked == 0) { ?>
                            <a class="btn-like-shop" href="javascript:void(0)">
                                <img style="width: 33px;margin: -10px 0 0 15px;" src="<?php echo Yii::app()->theme->baseUrl, '/css/img/icon-like1.png' ?>" />
                            </a>
                        <?php } else if (Yii::app()->user->id && $liked) { ?>
                            <a class="btn-like-shop btn-unlike-shop" href="javascript:void(0)">
                                <img style="width: 33px;margin: -10px 0 0 15px;" src="<?php echo Yii::app()->theme->baseUrl, '/css/img/icon-like2.png' ?>" />
                            </a>
                        <?php } ?>
                        <span class="count_like"><?php echo $count_like ?></span>
                    </div>
                    <div class="welcome-stand">
                        <?php echo $shop['description']; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="action">
                    <div class="registered-action mua">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-mua"><span>Thông tin liên hệ</span></button>
                        <div class="modal fade bs-example-modal-sm-mua" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm-mua">
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
                    <div class="registered-action mua tragop">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm-tragop"><span>Chế độ bán hàng</span></button>
                        <div class="modal fade bs-example-modal-sm-tragop" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                            <div class="modal-dialog modal-sm-tragop">
                                <div class="modal-content ">
                                    <div class="header-popup clearfix"> <i class="icon-popup"></i>
                                        <div class="title-popup">Chế độ bán hàng</div>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    </div>
                                    <div class="cont">
                                        <?php echo $shop['policy']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="time-sales">
                    <p class="hours"><?php echo Yii::t('shop', 'time_open') ?>:<span> <?php echo $shop['time_open'] ?>h-<?php echo $shop['time_close'] ?>h</span></p>
                    <p class="day"><?php echo Yii::t('shop', 'day_work') ?><span> <?php echo Shop::getDayText($shop['day_open']) ?>- <?php echo Shop::getDayText($shop['day_close']) ?></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

