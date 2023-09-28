<li class="support-item">
    <div class="row">
        <div class="col-xs-3">
            <?php
            echo CHtml::dropDownList('type', 0, array('' => Yii::t('support', 'choice')) + SiteSupport::getSupportTypesArr(), array('class' => 'SupportType'));
            ?>
        </div>
        <div class="col-xs-9">
            <div class="support-form">
                <?php //$this->renderPartial('form/phone'); ?>
            </div>
        </div>
    </div>
    <a href="#" class="support-removeItem"><i class="icon-trash"></i></a>
    <a class="support-drap"><i class="icon-arrows-alt"></i></a>
</li>