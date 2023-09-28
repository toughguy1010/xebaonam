<?php

/**
 * This is the model class for table "gift_card".
 *
 * The followings are the available columns in table 'gift_card':
 * @property integer $id
 * @property string $name
 * @property string $src
 * @property integer $width
 * @property integer $height
 * @property string $description
 * @property integer $created_time
 * @property integer $order
 * @property integer $status
 * @property integer $site_id
 * @property integer $campaign_id
 */
class GiftCard extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('gift_card');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('name, order, campaign_id', 'required'),
            array('width, height, order, created_time, status', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('name, src', 'length', 'max' => 255),
            array('description', 'length', 'max' => 1000),
            array('id, name, src, width, height, description, created_time, order, status, site_id, campaign_id', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'src' => 'Src',
            'width' => 'Width',
            'height' => 'Height',
            'description' => 'Description',
            'created_time' => 'Created Time',
            'order' => 'Order',
            'status' => 'Status',
            'site_id' => 'Site Id',
            'campaign_id' => 'Campaign'
        );
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
        }
        return parent::beforeSave();
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('src', $this->src, true);
        $criteria->compare('width', $this->width);
        $criteria->compare('height', $this->height);
        $criteria->compare('order', $this->order);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('site_id', $this->site_id);

        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return GiftCard the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Cho phép những loại file nào
     * @return type
     */
    static function allowExtensions() {
        return array(
            'image/jpeg' => 'image/jpeg',
            'image/gif' => 'image/gif',
            'image/png' => 'image/png',
            'image/bmp' => 'image/bmp',
            'application/x-shockwave-flash' => 'application/x-shockwave-flash',
        );
    }

    public static function getGiftCards() {
        $data = Yii::app()->db->createCommand()
                ->select('*')
                ->from(ClaTable::getTable('gift_card'))
                ->where('site_id=:site_id AND status=:status', array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED))
                ->queryAll();
        return $data;
    }

}
