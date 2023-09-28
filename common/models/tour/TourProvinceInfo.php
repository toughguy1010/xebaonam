<?php

/**
 * This is the model class for table "tour_province_info".
 *
 * The followings are the available columns in table 'tour_province_info':
 * @property string $id
 * @property string $province_id
 * @property integer $status
 * @property integer $showinhome
 * @property string $image_path
 * @property string $image_name
 * @property integer $position
 * @property string $description
 * @property integer $site_id
 */
class TourProvinceInfo extends ActiveRecord {
    
    const PROVINCE_DEFAUTL_LIMIT = 10;
    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour_province_info');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status, showinhome, position, site_id', 'numerical', 'integerOnly' => true),
            array('province_id', 'length', 'max' => 5),
            array('image_path', 'length', 'max' => 255),
            array('image_name', 'length', 'max' => 200),
            array('description', 'length', 'max' => 2000),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, province_id, status, showinhome, image_path, image_name, position, description, site_id, avatar', 'safe'),
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
            'province_id' => Yii::t('common', 'province'),
            'status' => Yii::t('common', 'status'),
            'showinhome' => Yii::t('common', 'showinhome'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'position' => 'Position',
            'description' => Yii::t('common', 'description'),
            'site_id' => 'Site',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('showinhome', $this->showinhome);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('position', $this->position);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TourProvinceInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public static function getProvinceInHome($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PROVINCE_DEFAUTL_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $province = Yii::app()->db->createCommand()->select('*')->from('province t')
                ->join('tour_province_info r', 'r.province_id = t.province_id')
                ->where("r.site_id=:site_id AND r.status=:status AND r.showinhome=:showinhome", array(':site_id' => $siteid, ':status' => ActiveRecord::STATUS_ACTIVED, ':showinhome' => 1))
                ->order('r.position ASC, r.id DESC')
                ->limit($options['limit'])
                ->queryAll();
        $result = array();
        
        foreach ($province as $item) {
            $results[$item['id']] = $item;
            $results[$item['id']]['link'] = Yii::app()->createUrl('tour/province/category', array('id' => $item['province_id'], 'alias' => HtmlFormat::parseToAlias($item['name'])));
        }
        return $results;
    }

}
