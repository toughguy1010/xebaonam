<div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th><?php echo Yii::t('file', 'file_display_name'); ?></th>
                <th><?php echo Yii::t('file', 'file_size'); ?></th>
                <th><?php echo Yii::t('file', 'file_extension'); ?></th>
                <th><?php echo Yii::t('common', 'created_time'); ?></th>
                <th><?php echo Yii::t('common', 'download'); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo $file->display_name; ?></td>
                <td><?php echo Files::GetStringSizeFormat($file->size); ?></td>
                <td><?php echo $file->extension; ?></td>
                <td><?php echo date('m-d-Y', $file->created_time); ?></td>
                <td><a href="<?php echo Yii::app()->createUrl('media/media/downloadfile', array('id' => $file->id)); ?>"><?php echo Yii::t('common', 'download') ?></a></td>
            </tr>
        </tbody>
    </table>
    <div class="description">
        <?php echo $file->description; ?>
    </div>
</div>