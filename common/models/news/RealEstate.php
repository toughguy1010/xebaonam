<?php

/**
 * This is the model class for table "real_estate".
 *
 * The followings are the available columns in table 'real_estate':
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
 * @property string $province_id
 * @property string $district_id
 * @property string $price
 * @property string $area
 */
class RealEstate extends ActiveRecord {

    const REALESTATE_DEFAULT_LIMIT = 20;

    public $avatar = '';
    public $unit_area = '';
    public $unit_percent = '';

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('real_estate');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('site_id, status, created_time, modified_time, user_id', 'numerical', 'integerOnly' => true),
            array('name, alias, area, contact_name, contact_email', 'length', 'max' => 255),
            array('sort_description', 'length', 'max' => 500),
            array('contact_phone', 'length', 'max' => 50),
            array('province_id, district_id', 'length', 'max' => 4),
            array('province_name, district_name', 'length', 'max' => 100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, site_id, status, created_time, modified_time, user_id, sort_description, description, province_id, district_id, price, area, image_path, image_name, address, avatar, project_id, province_name, district_name, percent, type, unit_price, contact_name, contact_phone, contact_email', 'safe'),
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
            'district_id' => Yii::t('common', 'district'),
            'price' => Yii::t('product', 'price'),
            'area' => Yii::t('realestate', 'area'),
            'avatar' => Yii::t('common', 'avatar'),
            'project_id' => Yii::t('realestate', 'project'),
            'percent' => Yii::t('realestate', 'percent'),
            'type' => Yii::t('realestate', 'type'),
            'contact_name' => Yii::t('realestate', 'contact_name'),
            'contact_phone' => Yii::t('realestate', 'contact_phone'),
            'contact_email' => Yii::t('realestate', 'contact_email'),
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
        $criteria->order = 'created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchMyRealestate() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', Yii::app()->user->id);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RealEstate the static model class
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

    /**
     * 
     * @param type $project_id
     * @param type $options
     * @return string
     */
    public static function getRealestateInProject($project_id = 0, $options = array()) {
        $project_id = (int) $project_id;
        if (!$project_id) {
            return array();
        }
        $site_id = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $site_id);
        if (!isset($options['limit'])) {
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        }

        $user = Users::getCurrentUser();

        $condition.=' AND project_id=:project_id';
        $params[':project_id'] = $project_id;

        if ($user->type == ActiveRecord::TYPE_NORMAL_USER) {
            $condition.=' AND type=:type';
            $params[':type'] = ActiveRecord::TYPE_COMMERCIAL;
        }

        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //order
        $order = 'created_time DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }

        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        $realestates = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate'))
                ->where($condition, $params)
                ->order($order)
                ->queryAll();
        $results = array();
        foreach ($realestates as $p) {
            $results[$p['id']] = $p;
            $results[$p['id']]['link'] = Yii::app()->createUrl('news/realestate/detail', array('id' => $p['id'], 'alias' => $p['alias']));
            $results[$p['id']]['full_address'] = $p['address'];
            if ($results[$p['id']]['full_address'] != '') {
                $results[$p['id']]['full_address'] .=' - ' . $p['province_name'] . ' - ' . $p['district_name'];
            } else {
                $results[$p['id']]['full_address'] = $p['province_name'] . ' - ' . $p['district_name'];
            }
        }
        return $results;
    }

    /**
     * get count real estate in project
     * @param type $project_id
     * @param $options (children)
     */
    public static function countRealestateInProject($project_id = 0) {
        if (!$project_id) {
            return 0;
        }
        $site_id = Yii::app()->controller->site_id;
        //
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $site_id);

        $condition.=' AND project_id=:project_id';
        $params[':project_id'] = $project_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('real_estate'))
                        ->where($condition, $params)->queryScalar();
        return $count;
    }

    function processPrice() {
        if ($this->price) {
            $this->price = floatval(str_replace('.', '', $this->price));
        }
    }

    public static function unitPrice() {
        return array(
            1 => 'Triệu/m2',
            2 => 'Tỷ',
            3 => 'Tỷ/căn',
            4 => 'Triệu',
            5 => 'Triệu/căn',
            6 => 'Ngìn',
            7 => 'Ngìn/m2',
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

    public static function getAllRealestate($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::REALESTATE_DEFAULT_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $user = Users::getCurrentUser();

        $offset = ((int) $options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        $siteid = Yii::app()->controller->site_id;

        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);

        if ($user->type == ActiveRecord::TYPE_NORMAL_USER) {
            $condition.=' AND type=:type';
            $params[':type'] = ActiveRecord::TYPE_COMMERCIAL;
        }

        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate'))
                ->where($condition, $params)
                ->order('created_time DESC')
                ->limit($options['limit'], $offset)
                ->queryAll();
        $realestate = array();
        if ($data) {
            foreach ($data as $n) {
                $n['link'] = Yii::app()->createUrl('news/realestate/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                $n['full_address'] = $n['address'];
                if ($n['full_address'] != '') {
                    $n['full_address'] .=' - ' . $n['province_name'] . ' - ' . $n['district_name'];
                } else {
                    $n['full_address'] = $n['province_name'] . ' - ' . $n['district_name'];
                }
                array_push($realestate, $n);
            }
        }
        return $realestate;
    }
    
    public static function countAllRealestate() {
        $user = Users::getCurrentUser();
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);

        if ($user->type == ActiveRecord::TYPE_NORMAL_USER) {
            $condition.=' AND type=:type';
            $params[':type'] = ActiveRecord::TYPE_COMMERCIAL;
        }
        $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('real_estate'))
                ->where($condition, $params)
                ->queryScalar();
        return $count;
    }

}
