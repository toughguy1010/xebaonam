<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box transparent invoice-box">
                    <div class="widget-body">
                        <div class="widget-main padding-24">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('shoppingcart', '') ?></b>
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
                                                <b class="blue"><?php echo $model['phone'] ?></b>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Địa chỉ email: </span>
                                                <?php echo $model['email'] ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Ngày đi: </span>
                                                <?php echo $model['date_rent'] ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <span>Nước đi: </span>
                                                <?php
                                                $product = RentProduct::model()->findByPk($model['product_id']);
                                                echo $product['name'];
                                                ?>
                                            </li>
                                            <li class="divider"></li>
                                        </ul>
                                    </div>
                                    <?php
                                    $form = $this->beginWidget('CActiveForm', array(
                                        'id' => 'orders-form',
                                        'enableAjaxValidation' => false,
                                        'htmlOptions' => array('class' => 'form-inline'),
                                    ));
                                    ?>
                                    <label><?php echo $model->getAttributeLabel('status'); ?> : </label>
                                    <?php echo $form->dropDownList($model, 'status', OrderRentSimple::optionsStatus()); ?>
                                    <?php $this->endWidget(); ?>
                                </div><!-- /span -->
                            </div><!-- row -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>