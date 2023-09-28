<?php

/**
 * This is the model class for table "albums_categories".
 *
 * The followings are the available columns in table 'albums_categories':
 * @property string $cat_parent
 * @property string $site_id
 * @property string $cat_name
 * @property string $alias
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property integer $showinhome
 * @property string $image_path
 * @property string $image_name
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $cat_order
 * @property string $cat_description
 * @property integer $cat_countchild
 */
class Installment extends ActiveRecord {

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('installment_config');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, interes', 'required'),
            array('collection_fee, interes, insurrance', 'numerical', 'min' => 0),
            array('site_id', 'length', 'max' => 11),
            array('name, image_path, image_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, site_id, name, image_path, image_name, avatar', 'safe'),
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
            'name' => Yii::t('installment', 'Tên ngân hàng'),
            'site_id' => 'Site',
            'interes' => Yii::t('installment', 'Lãi suất %'),
            'collection_fee' => 'Phí thu hộ',
            'insurrance' => 'Bảo hiểm khoản vay %',
            'avatar' => Yii::t('common', 'avatar'),
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('site_id', $this->site_id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                //'pageSize' => $pageSize,
                'pageVar' => 'page',
            ),
        ));
    }
    public static function getAll() {
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('installment_config'))
            ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->queryAll();

        return $result;
    }


    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AlbumsCategories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
