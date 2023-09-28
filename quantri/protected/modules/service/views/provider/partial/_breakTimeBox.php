<div class="btn-group breakTime" style="margin-bottom:5px;">
    <button type="button" class="btn btn-primary" style="width: 160px;">
        <?php echo gmdate('g:i a', $model['start_time']).' - '. gmdate('g:i a', $model['end_time']);?>
    </button>
    <button type="button" class="btn btn-danger btnDeleteBreak" href="<?php echo Yii::app()->createUrl('service/provider/deletebreaktime',array('id'=>$model['id'])); ?>">
        <i class="icon-trash"></i>
    </button>
</div>