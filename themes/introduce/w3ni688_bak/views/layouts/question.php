<?php $this->beginContent('//layouts/main'); ?>
<div class=" container">
    <?php $this->widget('common.widgets.modules.breadcrumb.breadcrumb'); ?>
    <div class="cont-main">
        <div class="page-answer">	
            <div class="row">
                <div class="col-xs-9">
                    <div class="search-cauhoi">
                        <form class="clearfix">
                            <div class="item-submit"><button type="submit" class="btn btn-default">Tìm kiếm</button></div>
                            <div class="item-input"><input type="" class="form-control" placeholder="Tìm câu hỏi, hướng dẫn, mẹo vặt"></div>
                        </form>
                    </div>
                    <div class="filter-product clearfix">
                        <div class="search-much">
                            <h5>Tìm kiếm nhiều:</h5>
                            <ul class="clearfix">
                                <li><a href="#" title="#">Xe điện honda</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4">
                            <?php
                            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_LEFT_OUT));
                            ?>
                            <!--                            <div class="too-much">
                                                            <h3 class="title-too-much">SẢN PHẨM ĐƯỢC HỎI NHIỀU</h3>
                                                            <div class="cont">
                                                                <div class="item-too-much clearfix">
                                                                    <div class="img-too-much">
                                                                        <a href="#" title="#"><img src="css/img/sp1.jpg" alt="#"></a>
                                                                    </div>
                                                                    <div class="box-info">
                                                                        <h4 class="title-sp"><a href="#" title="#">Microsoft Lumia 540</a></h4>
                                                                        <div><a href="#" title="#" class="link-answer">30 Câu hỏi</a> <a href="#" title="#" class="link-answer">30 Hướng dẫn</a></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>-->
                        </div>
                        <div class="col-xs-8">
                            <?php echo $content; ?>
                            <?php
                            $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_RIGHT_OUT));
                            ?>
                        </div>
                    </div>

                </div>
                <div class="col-xs-3">
                    <?php
                    $this->widget('common.widgets.wglobal.wglobal', array('position' => Widgets::POS_WIGET_BLOCK6));
                    ?>
                </div>
            </div>


        </div>
    </div>
</div>
<?php $this->endContent(); ?>