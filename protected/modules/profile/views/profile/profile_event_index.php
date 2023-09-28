<div id="userdetail">
    <h3 class="username-title"><?php echo Yii::t('common', 'profile'); ?></h3>
    <?php
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $model,
        'htmlOptions' => array('class' => 'table table-bordered table-hover'),
        'attributes' => array(
            'name',
            'email' => array(
                'name' => 'email',
                'visible' => (in_array(Yii::app()->user->id, array($model->user_id, ClaUser::getSupperAdmin()))) ? true : false,
            ),
            'birthday' => array(
                'name' => 'birthday',
                'value' => $model->birthday,
            ),
            'sex' => array(
                'name' => 'sex',
                'value' => function ($model) {
                    $listsex = ClaUser::getListSexArr();
                    return $listsex[$model->sex];
                },
            ),
            'phone' => array(
                'name' => 'phone',
                'visible' => (in_array(Yii::app()->user->id, array($model->user_id, ClaUser::getSupperAdmin()))) ? true : false,
            ),

            'update' => array(
                'type' => 'raw',
                'value' => function ($model) {
                    return '<a class="btn btn-info" href="' . Yii::app()->createUrl('profile/profile/userUpdate') . '">' . Yii::t('common', 'update') . '</a>';
                },
                'visible' => ($model->user_id == Yii::app()->user->id) ? true : false,
            )
        ),
    ));
    ?>
</div>