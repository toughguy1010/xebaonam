<div class="widget widget-box">
    <div class="widget-header"><h4>Copy Widget</h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'site-copy-widget',
                        'htmlOptions' => array('class' => 'form-horizontal'),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                    ));
                    ?>
                    <div class="control-group form-group">
                        <label class="col-sm-2 control-label no-padding-left">Site ID</label>
                        <div class="controls col-sm-10">
                            <input type="text" name="site_id" id="site_id" class="span12 col-sm-12" />
                        </div>
                    </div>
                    <div class="control-group form-group buttons">
                        <input class="btn btn-info" id="savenews" type="submit" name="yt1" value="Copy">
                    </div>

                    <?php $this->endWidget(); ?>

                </div><!-- form -->
            </div>
        </div>
    </div>
</div>