<?php

/**
 * This is the model class for table "product_attribute_set".
 *
 * The followings are the available columns in table 'product_attribute_set':
 * @property string $id
 * @property string $total
 * @property string $total_shares
 * @property integer $percentage
 * @property integer $title
 * @property integer $title_en
 * @property integer $alias
 * @property integer $site_id
 */
class Shareholderrelations extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('shareholder_relations');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('total, total_shares, title, title_en', 'required'),
            array('total, total_shares', 'numerical', 'integerOnly' => true),
            array('percentage', 'numerical', 'min' => 0),
            array('total, total_shares', 'length', 'max' => 11),
            array('alias', 'length', 'max' => 100),
            array('title, title_en', 'length', 'max' => 400),
            array('alias', 'isAlias'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, total, total_shares, percentage, title, title_en, , alias', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'total' => Yii::t('shareholder_relations', 'total'),
            'total_shares' => Yii::t('shareholder_relations', 'total_shares'),
            'percentage' => Yii::t('shareholder_relations', 'percentage'),
            'alias' => Yii::t('common', 'alias'),
            'title' =>  Yii::t('shareholder_relations', 'title'),
            'title_en' =>  Yii::t('shareholder_relations', 'title_en'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('total', $this->total, true);
        $criteria->compare('total_shares', $this->total_shares, true);
        $criteria->compare('percentage', $this->percentage);
        $criteria->compare('title', $this->title);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductAttributeSet the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     *
     * @return type
     */
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        $this->alias = HtmlFormat::parseToAlias($this->title);
        return parent::beforeSave();
    }

}
