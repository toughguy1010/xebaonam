<style type="text/css">
    .widget-header-large {
        height: 260px;
    }

    .invoice-box .col-xs-8 label {
        width: 150px;
    }

    .invoice-box .col-xs-8 select {
        width: 145px;
    }
</style>
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->
        <div class="space-6">
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="widget-box transparent invoice-box">
                    <div class="clearfix">
                        <div class="col-xs-8">
                            <?php
                            $form = $this->beginWidget('CActiveForm', array(
                                'id' => 'orders-form',
                                'enableAjaxValidation' => false,
                                'htmlOptions' => array('class' => 'form-inline'),
                            ));
                            ?>
                            <label><?php echo $model->getAttributeLabel('status'); ?> : </label>
                            <?php if ($model->status == 6 || $model->status == 5) { ?>
                                <?php echo $form->dropDownList($model, 'status', Orders::getStatusArr(), array("disabled" => "disabled")); ?>
                            <?php } else { ?>
                                <?php echo $form->dropDownList($model, 'status', Orders::getStatusArr()); ?>
                            <?php } ?>
                            <?php if ($model->status != 6 && $model->status != 5) { ?>
                                <?php echo CHtml::submitButton(Yii::t('common', 'update'), array('class' => 'btn btn-sm btn-primary', 'style' => 'margin-left:20px;')); ?>
                            <?php } ?>

                            <?php $this->endWidget(); ?>
                        </div>
                        <div class="col-xs-4">
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main padding-24">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-xs-11 label label-lg label-info arrowed-in arrowed-right">
                                            <b><?php echo Yii::t('rma', 'RMA Company Infomation') ?></b>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <ul class="list-unstyled spaced">
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('company_name'); ?></b>
                                                <?php echo $model->company_name ?>
                                            </li>

                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('email'); ?></b>
                                                <?php echo $model->email ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('contact_person'); ?></b>
                                                <?php echo $model->contact_person ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('telephone'); ?></b>
                                                <?php echo $model->telephone ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('purchase_order'); ?></b>
                                                <?php echo $model->purchase_order ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('shipping_issue'); ?></b>
                                                <?php echo $model->shipping_issue ? 'Yes' : 'No' ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('package_damage'); ?></b>
                                                <?php echo ($model->package_damage) ? 'Yes' : 'No' ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('carrier_notified'); ?></b>
                                                <?php echo $model->carrier_notified ? 'Yes' : 'No' ?>
                                            </li>
                                            <li>
                                                <i class="icon-caret-right blue"></i>
                                                <b><?php echo $model->getAttributeLabel('quote'); ?></b>
                                                <?php echo $model->quote ?>
                                            </li>
                                        </ul>
                                    </div>
                                </div><!-- /span -->

                                <div class="col-sm-6">

                                </div><!-- /span -->
                            </div><!-- row -->

                            <div class="space"></div>
                            <div>
                                <?php
                                $products = $model->rma_items;
                                $productModel = new RmaItems();
                                $n = 0;
                                //
                                if (isset($products) && count($products)) {
                                    ?>
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th align="left">STT</th>
                                            <th align="left">
                                                <?php echo $productModel->getAttributeLabel('product_description'); ?>
                                            </th>
                                            <th width="110" align="left">
                                                <?php echo $productModel->getAttributeLabel('serial'); ?>
                                            </th>
                                            <th width="80" align="left">
                                                <?php echo Yii::t('rma', 'part'); ?>
                                            </th>
                                            <th width="110" align="left">
                                                <?php echo $productModel->getAttributeLabel('condition'); ?>
                                            </th>
                                            <th width="110" align="left">
                                                <?php echo Yii::t('rma', 'reasion'); ?>
                                            </th>
                                            <th width="110" align="left">
                                                <?php echo Yii::t('rma', 'rma_type'); ?>
                                            </th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php foreach ($products as $product) { ?>
                                            <tr>
                                                <td><?= $n++ ?></td>
                                                <td>
                                                    <?= $product->product_description ?>
                                                </td>
                                                <td>
                                                    <?= $product->serial ?>
                                                </td>
                                                <td>
                                                    <?= $product->part ?>
                                                </td>
                                                <td>
                                                    <?= $product->condition ?>
                                                </td>
                                                <td>
                                                    <?= $product->reasion ?>
                                                </td>
                                                <td>
                                                    <?= $product->rma_type ?>
                                                </td>
                                            </tr>
                                        <?php }; ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            </div>
                            <div class="hr hr8 hr-double hr-dotted"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT ENDS -->
    </div><!-- /.col -->
</div>