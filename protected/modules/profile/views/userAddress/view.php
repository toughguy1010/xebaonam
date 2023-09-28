<div id="userdetail">
    <h3 class="username-title"><?php echo Yii::t('common', 'profile'); ?></h3>
    <a href="<?= Yii::app()->createUrl('profile/userAddress/create') ?>"
       class="btn btn-sm btn-default"><?php echo Yii::t('common', 'create_user_address'); ?></a>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'address-grid',
        'dataProvider' => $model->search(),
        'itemsCssClass' => 'table table-bordered table-hover vertical-center',
        'filter' => null,
        'enableSorting' => false,
        'columns' => array(
            'name',
            'phone' => array(
                'name' => 'phone',
                'visible' => (in_array(Yii::app()->user->id, array($model->user_id, ClaUser::getSupperAdmin()))) ? true : false,
            ),
            'address',
            'province_id' => array(
                'name' => 'province_id',
                'value' => function ($model) {
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
                'value' => function ($model) {
                    return '<a class="btn btn-info" href="' . Yii::app()->createUrl('profile/userAddress/update',['id'=>$model->id]) . '">' . Yii::t('common', 'update') . '</a>
<a class="btn btn-danger" href="' . Yii::app()->createUrl('profile/userAddress/delete',['id'=>$model->id]) . '">' . Yii::t('common', 'delete') . '</a>';
                },
                'visible' => ($model->user_id == Yii::app()->user->id) ? true : false,
            )
        ),
    ));
    ?>
</div>