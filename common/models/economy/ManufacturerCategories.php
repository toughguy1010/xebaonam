<?php

/**
 * Created by PhpStorm.
 * User: hungtm
 * Date: 9/28/2018
 * Time: 9:55 AM
 */

/**
 * This is the model class for table "manufacturer_categories".
 *
 * The followings are the available columns in table 'manufacturer_categories':
 * @property integer $cat_id
 * @property integer $site_id
 * @property integer $cat_parent
 * @property string $cat_name
 * @property string $alias
 * @property integer $cat_order
 * @property integer $product_id
 * @property string $cat_description
 * @property integer $cat_countchild
 * @property string $image_path
 * @property string $image_name
 * @property integer $status
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $showinhome
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $icon_path
 * @property string $icon_name
 * @property integer $type
 */
class ManufacturerCategories extends ActiveRecord {

    public $avatar = '';

    const CATEGORY_DEFAUTL_LIMIT = 5;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('manufacturer_categories');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cat_name, image_path, meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('layout_action, view_action', 'length', 'max' => 255),
            array('cat_description', 'length', 'max' => 2000),
            array('site_id, cat_parent, cat_order, cat_countchild, status, created_time, modified_time, showinhome, show_in_filter, type', 'numerical', 'integerOnly' => true),
            array('alias', 'length', 'max' => 500),
            array('image_name', 'length', 'max' => 200),
            array('icon_path', 'length', 'max' => 100),
            array('icon_name', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('cat_id, site_id, cat_parent, cat_name, alias, cat_order, cat_description, cat_countchild, image_path, image_name, status, created_time, modified_time, showinhome, meta_keywords, meta_description, meta_title, icon_path, icon_name, avatar,  layout_action, view_action, product_id, type', 'safe'),
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
            'cat_id' => 'Cat',
            'site_id' => 'Site',
            'cat_parent' => Yii::t('manufacturer', 'category_parent'),
            'cat_name' => Yii::t('manufacturer', 'category_name'),
            'alias' => Yii::t('common', 'alias'),
            'cat_order' => Yii::t('category', 'category_order'),
            'cat_description' => Yii::t('manufacturer', 'category_description'),
            'cat_countchild' => 'Cat Countchild',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'status' => Yii::t('common', 'status'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'showinhome' => Yii::t('category', 'showinhome'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'icon_path' => 'Icon Path',
            'icon_name' => 'Icon Name',
            'avatar' => Yii::t('common', 'avatar'),
            'product_id' => Yii::t('manufacturer', 'product_id'),
            'type' => 'Loại'
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
        // @todo Please modify the following code to remove attributes that should not be searched.
        $category = new ClaCategory(array('showAll' => true));
        $category->type = ClaCategory::CATEGORY_MANUFACTURER;
        $category->generateCategory(array('selectFull' => true));
        // Create arraydataprovider
        $data = $category->createArrayDataProvider(ClaCategory::CATEGORY_ROOT);
        //
        $dataprovider = new CArrayDataProvider($data, array(
            'id' => 'ManufacturerCategories',
            'keyField' => 'cat_id',
            'keys' => array('cat_id'),
            'pagination' => array('pageSize' => count($data),
            ),
        ));
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ManufacturerCategories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->modified_time = $this->created_time;
            $this->alias = HtmlFormat::parseToAlias($this->cat_name);
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->cat_name) {
                $this->alias = HtmlFormat::parseToAlias($this->cat_name);
            }
        }
        return parent::beforeSave();
    }

    public static function getCategoryInHome($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::CATEGORY_DEFAUTL_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $categories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('manufacturer_categories'))
                ->where("site_id=$siteid AND showinhome=" . self::SHOW_IN_HOME)
                ->order('cat_order')
                ->limit($options['limit'])
                ->queryAll();
        $results = array();
        $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_MANUFACTURER), false);
        $category->application = 'public';
        foreach ($categories as $cat) {
            $results[$cat['cat_id']] = $cat;
            $results[$cat['cat_id']]['link'] = Yii::app()->createUrl($category->getRoute(), array('id' => $cat['cat_id'], 'alias' => $cat['alias']));
        }
        return $results;
    }

    public static function getCategoryShowInFilter($options = array()) {
        if (!isset($options['limit'])) {
            $options['limit'] = self::CATEGORY_DEFAUTL_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $categories = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('manufacturer_categories'))
                ->where("site_id=$siteid AND show_in_filter =" . self::SHOW_IN_HOME)
                ->order('cat_order')
                ->limit($options['limit'])
                ->queryAll();
        $results = array();
        foreach ($categories as $cat) {
            $results[$cat['cat_id']] = $cat['cat_name'];
        }
        return $results;
    }

    public static function getCategoryByParent($parent_id) {
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('manufacturer_categories'))
                ->where('site_id=:site_id AND cat_parent=:parent_id', [':site_id' => $siteid, ':parent_id' => $parent_id])
            ->order('cat_order ASC')
                ->queryAll();

        return $data;
    }
    public static function getManufacturerAll() {
        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('manufacturer_categories'))
                ->where('site_id=:site_id', [':site_id' => $siteid])
            ->order('cat_order ASC')
                ->queryAll();

        return $data;
    }

    public static function getCategoryByParentChild($parent_child_id, $options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $data1 = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('manufacturer_categories'))
                ->where('site_id=:site_id AND cat_id=:parent_child_id', [':site_id' => $siteid, ':parent_child_id' => $parent_child_id])
                ->order('cat_name ASC')
                ->queryAll();
        foreach ($data1 as $catchild1) {
            $data2[$catchild1['cat_id']] = $catchild1;
            $data2[$catchild1['cat_id']]['cat_child_lv2'] = Yii::app()->db->createCommand()->select('*')
                    ->from(ClaTable::getTable('manufacturer_categories'))
                    ->where('site_id=:site_id AND cat_parent=' . $catchild1['cat_id'], [':site_id' => $siteid])
                    ->order('cat_name ASC')
                    ->queryAll();
        }
        foreach ($data2 as $catchild2) {
            if (isset($catchild2['cat_child_lv2']) && $catchild2['cat_child_lv2']) {
                foreach ($catchild2['cat_child_lv2'] as $catchild3) {
                    $data[$catchild3['cat_id']] = $catchild3;
                    $data[$catchild3['cat_id']]['cat_child_lv3'] = Yii::app()->db->createCommand()->select('*')
                            ->from(ClaTable::getTable('manufacturer_categories'))
                            ->where('site_id=:site_id AND cat_parent=:cat_parent AND cat_name like :code', [':site_id' => $siteid, ':cat_parent' => $catchild3['cat_id'], ':code' => '%'.$options['code'].'%'])
                            ->order('cat_name ASC')
                            ->queryAll();
                }
            }
        }
        return $data;
    }

    public static function getCategoryByParent2($options = array(), $parent_id = false) {

        $limit = ActiveRecord::DEFAUT_LIMIT;
        if (isset($options['limit']) && $options['limit']) {
            $limit = $options['limit'];
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int) $options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        ;

        $siteid = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select('*')
                ->from(ClaTable::getTable('manufacturer_categories'))
                ->where('site_id=:site_id AND cat_parent=:parent_id', [':site_id' => $siteid, ':parent_id' => $parent_id])
                ->limit($limit, $offset)
                ->queryAll();
        foreach ($data as $cat) {
            $results[$cat['cat_id']] = $cat;
            $results[$cat['cat_id']]['link'] = Yii::app()->createUrl('/economy/manufacturer/category', array('id' => $cat['cat_id'], 'alias' => $cat['alias']));
        }
        return $results;
    }

    public static function getCategoryByTrack($track) {
        $siteid = Yii::app()->controller->site_id;
        $data = [];
        $track = trim($track);
        if (isset($track) && $track) {
            $trackCondition = explode(' ', $track);
            $trackCondition = array_filter($trackCondition, function($value) {
                return $value !== '';
            });
            $data = Yii::app()->db->createCommand()->select('*')
                    ->from(ClaTable::getTable('manufacturer_categories'))
                    ->where('site_id=:site_id AND cat_id IN (' . join(',', $trackCondition) . ')', [':site_id' => $siteid])
                    ->queryAll();
        }
        return $data;
    }

    public static function optionsType() {
        return [
            1 => 'Hãng sản xuất',
            2 => 'Model',
            3 => 'Model Type'
        ];
    }

    public static function getCategoryByParentIds($ids) {
        $siteid = Yii::app()->controller->site_id;
        $data = [];
        if (isset($ids) && $ids) {
            $data = Yii::app()->db->createCommand()->select('*')
                    ->from(ClaTable::getTable('manufacturer_categories'))
                    ->where('site_id=:site_id AND cat_parent IN (' . $ids . ')', [
                        ':site_id' => $siteid
                    ])
                    ->queryAll();
        }
        return $data;
    }

}
