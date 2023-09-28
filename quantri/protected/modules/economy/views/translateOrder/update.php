<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box transparent invoice-box">
                    <div class="widget-header widget-header-large clearfix">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="widget-toolbar hidden-480">
                                    <a target="_blank"
                                       href="<?php echo Yii::app()->createUrl('/economy/translateOrder/printbill', array('id' => $model['id'])) ?>">
                                        <i class="icon-print"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-24">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('shoppingcart', 'Thông tin khách hàng') ?></b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <ul class="list-unstyled spaced">
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Tên khách hàng: </span>
                                                <?php echo $model['name'] ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Số điện thoại: </span>
                                                <b class="blue"><?php echo $model['tell'] ?></b>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Địa chỉ email: </span>
                                                <?php echo $model['email'] ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Số tiền thanh toán : </span>
                                                <?php echo ($model->total_price != '0.00') ? $model->total_price . ' ' . $model->currency : 'Liên hệ' ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Phương thức thanh toán : </span>
                                                <?php echo TranslateOrder::getPaymentMethod()[$model->payment_method]; ?>
                                            </li>
                                            <hr>
                                            <?php
                                            if ($model->status != Orders::ORDER_COMPLETE && $model->status != Orders::ORDER_DESTROY) {

                                                $form = $this->beginWidget('CActiveForm', array(
                                                    'method' => 'post',
                                                    'htmlOptions' => array(),
                                                ));
                                                ?>
                                                <li style="margin-top: 10px">
                                                    <i class="icon-caret-right blue"></i>
                                                    <span>Trạng thái dơn hàng : </span>
                                                    <?php echo $form->dropDownList($model, 'status', Orders::getStatusArr()); ?>
                                                </li>
                                                <li style="margin-top: 10px">
                                                    <i class="icon-caret-right blue"></i>
                                                    <span>Tình trạng thanh toán : </span>
                                                    <?php echo $form->dropDownList($model, 'payment_status', TranslateOrder::getPaymentStatus()); ?>
                                                </li>
                                                <li style="margin-top: 10px">
                                                    <i class="icon-caret-right blue"></i>
                                                    <span>Cập nhập lại giá trị đơn hàng : </span>
                                                    <?php echo $form->textField($model, 'total_price', TranslateOrder::getPaymentStatus()) . ' ' . $model->currency; ?>
                                                </li>
                                                <?php
                                                echo CHtml::submitButton(Yii::t('common', 'update'), array('class' => 'btn btn-sm'));
                                                $this->endWidget();
                                            } else {
                                                ?>
                                                <li style="margin-top: 10px;margin-bottom: 10px">
                                                    <i class="icon-caret-right blue"></i>
                                                    <span>Trạng thái dơn hàng : </span>
                                                    <?php echo Orders::getStatusArr()[$model->status]; ?>
                                                </li>
                                                <li>
                                                    <i class="icon-caret-right blue"></i>
                                                    <span>Tình trạng thanh toán : </span>
                                                    <?php echo TranslateOrder::getPaymentStatus()[$model->payment_status]; ?>
                                                </li>

                                                <?php
                                            }
                                            ?>
                                            <?php ?>

                                        </ul>
                                    </div>
                                </div><!-- /span -->
                                <?php if ($model['affiliate_user']){ ?>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('shoppingcart', 'Thông tin affiliate') ?></b>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <ul class="list-unstyled spaced">
                                            <?php if ($model['affiliate_id']) {
                                                $user = AffiliateLink::getUserByAffId($model['affiliate_id']);
                                                ?>
                                                <li>
                                                    <i class="icon-caret-right blue"></i>
                                                    <span>Người giới thiệu: </span>
                                                    <?php echo '<a target="_blank" href="' . Yii::app()->createUrl('affiliate/expertransAffiliate/viewUser', array('id' => $user['user_id'])) . '">' . $user['name'] . '</a>' ?>
                                                </li>
                                                <li>
                                                    <i class="icon-caret-right blue"></i>
                                                    <span>Hoa hồng (%): </span>
                                                    <?php echo $model['aff_percent'] .' %'; ?>
                                                </li>

                                            <?php } ?>
                                            <hr>
                                            <?php } ?>

                                        </ul>
                                    </div>
                                </div><!-- /span -->
                            </div><!-- row -->

                            <div class="space"></div>
                            <div>
                                <?php $this->renderPartial('_products_bill_admin', array('items' => $items)); ?>
                            </div>

                            <div class="hr hr8 hr-double hr-dotted"></div>


                            <div class="space-6"></div>
                            <?php if ($model['note']) { ?>
                                <div class="well">
                                    <?php echo $model['note'] ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p style="color: blue"> Lưu ý đơn hàng trạng thái hoàn thành sẽ không thể sửa lại</p>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>
