<?php if (count($fielddata)) { ?>
    <table class="table table-bordered table-hover vertical-center">
        <?php foreach ($fielddata as $data) { ?>
            <tr>
                <td width="20%">
                    <?php echo $data['field_label']; ?>
                </td>
                <td>
                    <?php echo Forms::getDataValue($fielddata, $data); ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <a href="<?php echo Yii::app()->createUrl('custom/customform/statistic', array('id' => $form->form_id)); ?>" class="btn btn-sm btn-light">
        <i class="icon-reply "></i>
        <?php echo $form->form_name; ?>
    </a>
<?php } ?>
