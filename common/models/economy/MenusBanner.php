<?php

/**
 * This is the model class for table "menus_banner".
 *
 * The followings are the available columns in table 'menus_banner':
 * @property string $id
 * @property string $name
 * @property string $image_path
 * @property string $image_name
 * @property string $menu_id
 * @property string $link
 * @property integer $status
 * @property string $order
 * @property string $created_time
 * @property string $modified_time
 * @property integer $site_id
 */
class MenusBanner extends ActiveRecord {

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'menus_banner';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name, image_path, image_name, link', 'length', 'max' => 255),
            array('menu_id, order, created_time, modified_time', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, image_path, image_name, menu_id, link, status, order, created_time, modified_time, site_id, avatar', 'safe'),
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
            'name' => 'Tên',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'menu_id' => 'Menu',
            'link' => 'Link',
            'status' => 'Trạng thái',
            'order' => 'Sắp xếp',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'avatar' => 'Ảnh',
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('menu_id', $this->menu_id, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('order', $this->order, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('modified_time', $this->modified_time, true);

        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MenusBanner the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->modified_time = $this->created_time = time();
        } else {
            $this->modified_time = time();
        }
        //
        return parent::beforeSave();
    }

    public static function getBannerInCat($cat_id) {
        $data = Yii::app()->db->createCommand()->select()
                ->from('menus_banner')
                ->where('status=:status AND site_id=:site_id AND menu_id=:menu_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id, ':menu_id' => $cat_id))
                ->order('order ASC')
                ->queryAll();
        return $data;
    }

}
