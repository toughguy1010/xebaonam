<?php

/**
 * This is the model class for table "se_services".
 *
 * The followings are the available columns in table 'se_services':
 * @property string $id
 * @property string $name
 * @property integer $site_id
 * @property integer $category_id
 * @property string $category_track
 * @property integer $status
 * @property integer $padding_left
 * @property integer $padding_right
 * @property string $price
 * @property string $price_market
 * @property integer $order
 * @property integer $duration
 * @property string $alias
 * @property string $image_path
 * @property string $image_name
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $created_by
 * @property integer $modified_by
 * @property integer $ishot
 * @property string $price_text
 */
class SeServices extends ActiveRecord {

    public $avatar = '';

    const STYLE_COL1 = 1;
    const STYLE_COL2 = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('se_services');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, category_id', 'required'),
            array('site_id, category_id, status, padding_left, padding_right, duration, order, created_time, modified_time, created_by, modified_by', 'numerical', 'integerOnly' => true),
            array('name, image_path, image_name', 'length', 'max' => 250),
            array('category_track', 'length', 'max' => 686),
            array('alias', 'length', 'max' => 500),
            array('price, price_market', 'length', 'max' => 16),
            array('name, price_text', 'filter', 'filter' => 'trim'),
            array('name', 'filter', 'filter' => 'strip_tags'), // or //array('title', 'filter', 'filter'=>function($v){ return strip_tags($v);}),
            array('id, name, site_id, category_id, category_track, status, order, alias, image_path, image_name, created_time, modified_time, created_by, modified_by, avatar, duration, padding_right, padding_left, price, price_market, ishot, price_text', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'service_info' => array(self::HAS_ONE, 'SeServicesInfo', 'service_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'site_id' => 'Site',
            'category_id' => 'Category',
            'category_track' => 'Category Track',
            'status' => 'Status',
            'padding_time' => 'Padding Time',
            'order' => 'Order',
            'alias' => 'Alias',
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'created_by' => 'Created By',
            'modified_by' => 'Modified By',
            'padding_left' => 'Padding Time Before',
            'padding_right' => 'Padding Time After',
            'price' => 'Price',
            'price_market' => 'Price Market',
            'duration' => 'Duration',
            'ishot' => 'Hot',
            'price_text' => 'Price Text',
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
        if (!$this->site_id) {
            $this->site_id = Yii::app()->controller->site_id;
        }
        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('category_track', $this->category_track, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('padding_left', $this->padding_left);
        $criteria->compare('padding_right', $this->padding_right);
        $criteria->compare('price', $this->price);
        $criteria->compare('duration', $this->duration);
        $criteria->compare('order', $this->order);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('image_path', $this->image_path, true);
        $criteria->compare('image_name', $this->image_name, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('modified_by', $this->modified_by);

        //
        $dataprovider = new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
        //
        return $dataprovider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return SeServices the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->alias = HtmlFormat::parseToAlias($this->name);
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->modified_time = time();
            if (!trim($this->alias) && $this->name)
                $this->alias = HtmlFormat::parseToAlias($this->name);
        }
        return parent::beforeSave();
    }

    public function afterDelete() {
        //Delete service infomation
        SeServicesInfo::model()->deleteAllByAttributes(array('service_id' => $this->id, 'site_id' => Yii::app()->controller->site_id));
        //
        SeProviderServices::model()->deleteAllByAttributes(array('service_id' => $this->id, 'site_id' => Yii::app()->controller->site_id));
        //
        parent::afterDelete();
    }

    /**
     * return text of price, price_market
     * @param type $service
     * @param type $type
     */
    static function getPriceText($service = array(), $type = 'price', $options = array()) {
        $price = 0;
        $return = '';
        switch ($type) {
            case 'price_market': {
                    $price = isset($service['price_market']) ? $service['price_market'] : 0;
                }
                break;
            case 'price_save': {
                    $_price_market = isset($service['price_market']) ? $service['price_market'] : 0;
                    $_price = isset($service['price']) ? $service['price'] : 0;
                    $price = abs($_price - $_price_market);
                }
                break;
            default: {
                    $price = isset($service['price']) ? $service['price'] : 0;
                }
                break;
        }
        if ($price > 0) {
            //
            $price = HtmlFormat::money_format($price);
            //
            $currency = self::getCurrencyText($service);
            $return = '<span class="currencytext">' . $currency . '</span><span class="pricetext">' . $price . '</span>';
        } elseif (isset($service['price_text']) && $service['price_text']) {
            $return = $service['price_text'];
        }
        //
        return $return;
    }

    /**
     * Lấy đơn vị tính của sản phẩm
     * @param type $service
     */
    static function getCurrencyText($service = array()) {
        $currency = '';
        $text = '$';
        switch ($currency) {
            case 'USD': {
                    $text = '$';
                }
                break;
        }
        //
        return $text;
    }

    /**
     * Lấy các services
     */
    static function getServices($options = array(), $countOnly = false) {
        $results = array();
        //
        $condition = 't.site_id=:site_id AND t.status=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => Yii::app()->controller->site_id);

        if (isset($options['ishot']) && $options['ishot']) {
            $condition .= ' AND t.ishot=:ishot';
            $params[':ishot'] = $options['ishot'];
        }

        $command = Yii::app()->db->createCommand();
        $select = 't.*, r.description, r.sort_description';
        // get services for category
        if (isset($options[ClaCategory::CATEGORY_KEY]) && $options[ClaCategory::CATEGORY_KEY]) {
            $condition .= " AND MATCH (t.category_track) AGAINST ('" . $options[ClaCategory::CATEGORY_KEY] . "' IN BOOLEAN MODE)";
        }
        // get services by Ods
        if (isset($options['service_id']) && $options['service_id']) {
            if (!is_array($options['service_id'])) {
                $service_id = (string) $options['service_id'];
            } else {
                $service_id = $options['service_id'];
            }

            //Check array
            if (!is_array($service_id)) {
                if (isset($service_id) && $service_id != 0) {
                    $condition .= " AND t.id = :service_id";
                    $params[':service_id'] = $service_id;
                }
            } else {
                if (count($service_id)) {
                    $condition .= " AND t.id in (" . implode(',', $service_id) . ")";
                }
            }
        }
        // count only
        if ($countOnly) {
            $count = $command->select('count(*)')->from(ClaTable::getTable('se_services') . ' t')
                    ->where($condition, $params)
                    ->queryScalar();
            return $count;
        }
        if (isset($options['limit']) && (int) $options['limit']) {
            $command->limit($options['limit']);
            if (!isset($options[ClaSite::PAGE_VAR])) {
                $options[ClaSite::PAGE_VAR] = 1;
            }
            $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
            $command->offset($offset);
        }
        //
        $data = $command->select($select)
                ->from(ClaTable::getTable('se_services') . ' t')
                ->leftJoin(ClaTable::getTable('se_services_info') . ' r', 'r.service_id = t.id')
                ->where($condition, $params)
                ->order('t.order ASC, id DESC')
                ->queryAll();
        if ($data) {
            foreach ($data as $se) {
                $results[$se['id']] = $se;
                $results[$se['id']]['price_text'] = self::getPriceText($se);
            }
        }
        //
        return $results;
    }

    static function buildOptions() {
        $result = array();
        $seoptions = self::getServices();
        $category = new ClaCategory();
        $category->type = ClaCategory::CATEGORY_SERVICE;
        $category->generateCategory();
        foreach ($seoptions as $op) {
            if ($op['category_id'] && $category->getItem($op['category_id'])) {
                $cat = $category->getItem($op['category_id']);
                $result[$cat['cat_name']][$op['id']] = $op['name'];
            } else {
                $result[$op['id']] = $op['name'];
            }
        }
        return $result;
    }

    static function arrayStyle() {
        return array(
            self::STYLE_COL1 => 'col1',
            self::STYLE_COL2 => 'col2'
        );
    }

}
