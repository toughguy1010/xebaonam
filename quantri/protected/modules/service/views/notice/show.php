<div class="widget widget-box">
    <div class="widget-header"><h4><?php echo Yii::t('notice', 'notice'); ?></h4></div>
    <div class="widget-body no-padding">
        <div class="widget-main">
            <div class="row">
                <div class="col-xs-12 no-padding">
                    <div class="tabbable">
                        <div class="control-group form-group">
                            <div class="col-sm-2">Tiêu đề</div>
                            <div class="controls col-sm-10">
                                <?= $model->title ?>
                            </div>
                        </div>
                        <div class="control-group form-group">
                            <div class="col-sm-2">Tình trạng</div>
                            <div class="controls col-sm-10">
                                <label>
                                    <?= ($model->showall) ? 'Gửi tất cả thành viên' : 'Gửi cho các thành viên' ?>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <div class="control-group form-group">
                            <div class="col-sm-2">Nội dung</div>
                            <div class="controls col-sm-10">
                                <?= $model->content ?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group form-group">
                        <div class="controls col-sm-12">
                            <a href="" class="btn btn-sm"> Back</a>
                            <!--                            --><?php //echo CHtml::label('Trang hiển thị', '', array('class' => 'col-sm-2 control-label no-padding-left')); ?>
                            <!--                            <div class="controls col-sm-10">-->
                            <!--                                --><?php //echo $form->dropDownList($model, 'user_ids', $users, array('multiple' => 'multiple', 'class' => 'form-control chosen-select', 'style' => 'width: 100%;')); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>