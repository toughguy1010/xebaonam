<?php

/**
 * Simple widjet for selecting page size of gridviews
 *
 * @author	Aruna Attanayake <minhcoltech@gmail.com>
 * @version 1.0
 */
class PageSize extends CWidget {

    public $mPageSizeOptions = null;
    public $mPageSize = 10;
    public $mGridId = '';
    public $mDefPageSize = 10;
    public $summaryText = '<span style="padding-right: 20px; display:inline-block; white-space:nowrap;">Hiển thị:</span>';

    public function run() {
        if ($this->mPageSizeOptions === null) {
            $this->mPageSizeOptions = array(
                10 => Yii::t('common', 'record_per_page', array('{number}' => 10)),
                1 => Yii::t('common', 'record_per_page', array('{number}' => 1)),
                3 => Yii::t('common', 'record_per_page', array('{number}' => 3)),
                25 => Yii::t('common', 'record_per_page', array('{number}' => 25)),
                50 => Yii::t('common', 'record_per_page', array('{number}' => 50)),
                100 => Yii::t('common', 'record_per_page', array('{number}' => 100)),
            );
        }
        Yii::app()->user->setState(Yii::app()->params['pageSizeName'], $this->mPageSize);
        $this->mPageSize = null == $this->mPageSize ? $this->mDefPageSize : $this->mPageSize;
        echo $this->summaryText;
        echo CHtml::dropDownList('pageSize', $this->mPageSize, $this->mPageSizeOptions, array(
            'onchange' => "$.fn.yiiGridView.update('$this->mGridId',{ data:{pageSize: $(this).val() }})",
        ));
    }

}
