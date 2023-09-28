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
                'value' => function($model) {
            $listsex = ClaUser::getListSexArr();
            return $listsex[$model->sex];
        },
            ),
            'phone' => array(
                'name' => 'phone',
                'visible' => (in_array(Yii::app()->user->id, array($model->user_id, ClaUser::getSupperAdmin()))) ? true : false,
            ),
            'address',
            'province_id' => array(
                'name' => 'province_id',
                'value' => function($model) {
            $province = LibProvinces::getProvinceDetail($model->province_id);
            return $province['name'];
        }
            ),
            'district_id' => array(
                'name' => 'district_id',
                'value' => function ($model) {
            $district = LibDistricts::getDistrictDetailFollowProvince($model->province_id, $model->district_id);
            return $district['name'];
        }
            ),
            'update' => array(
                'type' => 'raw',
                'value' => function($model) {
            return '<a class="btn btn-info" href="' . Yii::app()->createUrl('profile/profile/update') . '">' . Yii::t('common', 'update') . '</a>';
        },
                'visible' => ($model->user_id == Yii::app()->user->id) ? true : false,
            )
        ),
    ));
    ?>
</div>