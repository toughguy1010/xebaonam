<h1>View TranslateLanguage #<?php echo $model->id; ?></h1>

<?php //$this->renderPartial('_form', array('model' => $model)); ?>
<?php $this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'lang_id' => array(
            'name' => 'lang_id',
            'value' => function ($data) {
                $lang = TranslateLanguage::model()->findByPk($data->lang_id);
                return ClaLocation::getCountryName($lang['from_lang']) . ' -> ' . ClaLocation::getCountryName($lang['to_lang']);
            }
        ),
        'option_id' => array(
            'name' => 'option_id',
            'value' => function ($data) {
                $lang = TranslateOption::model()->findByPk($data->option_id);
                return $lang->name;
            }
        ),
        'price'=> array(
            'name' => 'price',
            'value' => function ($data) {
                return HtmlFormat::money_format($data->price);
            }
        ),
        'currency',
        'status',
        'created_time'=> array(
            'name' => 'price',
            'value' => function ($data) {
                return date('d-m-Y',HtmlFormat::money_format($data->created_time));
            }
        ),
        'site_id'
    ),
)); ?>
<div style="padding: 10px 0">
    <a href="<?php echo Yii::app()->createUrl('economy/translateLanguageOption/') ?>">
        <button class="btn btn-sm btn-info">Về trang danh mục</button>
    </a>
    <a href="<?php echo Yii::app()->createUrl('economy/translateLanguageOption/update', array('id' => $model->id)) ?>">
        <button class="btn btn-sm btn-info">Sửa</button>
    </a>
</div>
