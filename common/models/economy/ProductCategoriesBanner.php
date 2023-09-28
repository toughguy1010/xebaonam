<?php

/**
 * This is the model class for table "product_categories_banner".
 *
 * The followings are the available columns in table 'product_categories_banner':
 * @property string $id
 * @property string $name
 * @property string $image_path
 * @property string $image_name
 * @property string $category_id
 * @property string $link
 * @property integer $status
 * @property string $order
 * @property string $created_time
 * @property string $modified_time
 * @property integer $site_id
 * @property integer $position
 */
class ProductCategoriesBanner extends ActiveRecord {

    const POS_MODULE = 1;
    const POS_MENU = 2;
    const POS_CATEGORY = 3;

    public $avatar = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product_categories_banner';
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
            array('category_id, order, created_time, modified_time', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, image_path, image_name, category_id, link, status, order, created_time, modified_time, site_id, avatar, position', 'safe'),
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
            'category_id' => 'Danh mục',
            'link' => 'Link',
            'status' => 'Trạng thái',
            'order' => 'Sắp xếp',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'avatar' => 'Ảnh',
            'position' => 'Vị trí'
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
        $this->site_id = Yii::app()->controller->site_id;
        
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('category_id', $this->category_id, true);
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
     * @return ProductCategoriesBanner the static model class
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

    public static function getBannerInCat($cat_id, $position) {
        $data = Yii::app()->db->createCommand()->select()
                ->from('product_categories_banner')
                ->where('status=:status AND site_id=:site_id AND category_id=:category_id AND position=:position', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id, ':category_id' => $cat_id, ':position' => $position))
                ->order('order ASC')
                ->queryAll();
        return $data;
    }

    public static function arrPosition() {
        return array(
            '' => 'Chọn vị trí',
            self::POS_MODULE => 'Vị trí trong module',
            self::POS_MENU => 'Vị trí menu',
            self::POS_CATEGORY => 'Vị trí trong trang danh mục'
        );
    }

    public static function getBannerInPosition($position) {
        $data = Yii::app()->db->createCommand()->select()
                ->from('product_categories_banner')
                ->where('status=:status AND site_id=:site_id AND position=:position', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => Yii::app()->controller->site_id, ':position' => $position))
                ->order('order ASC')
                ->queryAll();
        return $data;
    }

}
