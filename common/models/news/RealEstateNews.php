<?php

/**
 * This is the model class for table "real_estate_news".
 *
 * The followings are the available columns in table 'real_estate_news':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property integer $site_id
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $user_id
 * @property string $sort_description
 * @property string $description
 * @property string $address
 * @property string $province_id
 * @property string $province_name
 * @property string $district_id
 * @property string $district_name
 * @property string $price
 * @property integer $area
 * @property string $image_path
 * @property string $image_name
 * @property integer $cat_id
 * @property integer $type
 */
class RealEstateNews extends ActiveRecord {

    public $avatar = '';
    const REALESTATE_DEFAUTL_LIMIT = 12;
    public $unit_area = '';
    public $unit_percent = '';


    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('real_estate_news');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('site_id, status, created_time, modified_time, user_id, area, cat_id, type', 'numerical', 'integerOnly' => true),
            array('name, alias, address, image_path', 'length', 'max' => 255),
            array('sort_description', 'length', 'max' => 500),
            array('province_id, district_id', 'length', 'max' => 4),
            array('province_name, district_name', 'length', 'max' => 100),
            array('price', 'length', 'max' => 16),
            array('image_name', 'length', 'max' => 200),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, site_id, status, created_time, modified_time, user_id, sort_description, description, address, province_id, province_name, district_id, district_name, price, area, image_path, image_name, cat_id, type, avatar, unit_price', 'safe'),
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
            'name' => Yii::t('realestate', 'title'),
            'alias' => 'Alias',
            'site_id' => 'Site',
            'status' => Yii::t('common', 'status'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'user_id' => 'User',
            'sort_description' => Yii::t('common', 'sort_description'),
            'description' => Yii::t('common', 'description'),
            'address' => Yii::t('common', 'address'),
            'province_id' => Yii::t('common', 'province'),
            'province_name' => 'Province Name',
            'district_id' => Yii::t('common', 'district'),
            'district_name' => 'District Name',
            'price' => Yii::t('product', 'price'),
            'area' => Yii::t('realestate', 'area'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'cat_id' => Yii::t('common', 'category'),
            'type' => 'Type',
            'avatar' => Yii::t('common', 'avatar')
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
        
        $this->site_id = Yii::app()->controller->site_id;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    public function searchMyRealestateNews() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        
        $this->site_id = Yii::app()->controller->site_id;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', Yii::app()->user->id);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RealEstateNews the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name) {
                $this->alias = HtmlFormat::parseToAlias($this->name);
            }
        }
        return parent::beforeSave();
    }
    
    function processPrice() {
        if ($this->price) {
            $this->price = floatval(str_replace('.', '', $this->price));
        }
    }
    
    public static function getRealestateNewsInCategory($cat_id, $options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (!isset($options['limit'])) {
            $options['limit'] = self::REALESTATE_DEFAUTL_LIMIT;
        }
        $cat_id = (int) $cat_id;
        if (!$cat_id) {
            return array();
        }
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_REAL_ESTATE, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition.=' AND cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition.=' AND cat_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //select
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('real_estate_news'))
                ->where($condition, $params)
                ->order('created_time DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        $realestate_news = array();
        if ($data) {
            foreach ($data as $n) {
                $n['sort_description'] = nl2br($n['sort_description']);
                $n['link'] = Yii::app()->createUrl('news/realestateNews/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($realestate_news, $n);
            }
        }
        return $realestate_news;
    }
    
    /**
     * get count course in category
     * @param type $cat_id
     * @param $options (children)
     */
    public static function countRealestateNewsInCate($cat_id = 0, $options = array()) {
        if (!$cat_id) {
            return 0;
        }
        $siteid = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        //
        // get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_REAL_ESTATE, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        //
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition.=' AND cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition.=' AND cat_id=:cat_id';
            $params[':cat_id'] = $cat_id;
        }
        //
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('real_estate_news'))
                        ->where($condition, $params)->queryScalar();
        return $count;
    }
    
    public static function unitPrice() {
        return array(
            2 => 'Triệu/tháng',
            1 => 'Triệu/m2',
            3 => 'Tỷ',
            4 => 'Tỷ/căn',
            5 => 'Triệu',
            6 => 'Triệu/căn',
            7 => 'Ngìn',
            8 => 'Ngìn/m2',
        );
    }
    
    public static function unitArea() {
        return array(
            1 => 'm2',
        );
    }
    
    public static function unitPercent() {
        return array(
            1 => '%',
        );
    }

}
