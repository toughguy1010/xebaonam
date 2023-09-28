<div class="row">
    <div class="col-xs-12 no-padding">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'site-settings-shipfee-form',
            'htmlOptions' => array('class' => 'form-horizontal'),
            'enableAjaxValidation' => false,
        ));
        ?>
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#configshipfee">
                        <?php echo Yii::t('site', 'shipfee_position'); ?>
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#configshipfeeweight">
                        <?php echo Yii::t('site', 'shipfee_weight'); ?>
                    </a>
                </li>
            </ul>

            <div class="tab-content">
                <div id="configshipfee" class="tab-pane active">
                    <?php
                    $this->renderPartial('partial/shipfee_position', array(
                        'model' => $model,
                        'form' => $form,
                        'listprovince' => $listprovince,
                        'listdistrict' => $listdistrict,
                        'data' => $data
                            )
                    );
                    ?>
                </div>
                <div id="configshipfeeweight" class="tab-pane">
                    <?php
                    $this->renderPartial('partial/shipfee_weight', array(
                        'model' => $model,
                        'form' => $form,
                        'data_weight' => $data_weight
                            )
                    );
                    ?>
                </div>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>