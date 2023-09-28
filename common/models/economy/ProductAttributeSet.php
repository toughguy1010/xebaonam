<?php

/**
 * This is the model class for table "product_attribute_set".
 *
 * The followings are the available columns in table 'product_attribute_set':
 * @property string $id
 * @property string $name
 * @property string $code
 * @property integer $sort_order
 * @property integer $site_id
 */
class ProductAttributeSet extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('product_attribute_set');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('sort_order', 'numerical', 'integerOnly' => true),
            array('name, code', 'length', 'max' => 128),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, code, sort_order, site_id', 'safe', 'on' => 'search'),
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
            'name' => Yii::t('attribute_set', 'attribute_set_name'),
            'code' => Yii::t('attribute_set', 'attribute_set_code'),
            'sort_order' => Yii::t('attribute_set', 'attribute_set_sort_order'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('sort_order', $this->sort_order);
        $criteria->compare('site_id', $this->site_id);

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
        return parent::beforeSave();
    }

    public function getAttributesBySet($attribute_set_id, $conditions = '', $parrams = array(), $order = 'sort_order asc') {
        $results = array();
        $where = 'site_id=' . Yii::app()->siteinfo['site_id'] . ' AND attribute_set_id=:attribute_set_id';
        $conditions = ($conditions) ? $where . ' AND ' . $conditions : $where;
        $parrams = array_merge($parrams, array(':attribute_set_id' => $attribute_set_id));
        $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('product_attribute'))
                ->where($conditions, $parrams)
                ->order($order)
                ->queryAll();
        if (count($data)) {
            foreach ($data as $item) {
                $results[$item['id']] = $item;
            }
        }
        return $results;
    }

    public function getName($id) {
        return Yii::app()->db->createCommand()
                        ->select('name')
                        ->from(ClaTable::getTable('product_attribute_set'))
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND id=' . (int) $id)
                        ->queryScalar();
    }

    static function getAttributeSetOptions() {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select("id,name")
                ->from(ClaTable::getTable('product_attribute_set'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->order('sort_order asc')
                ->queryAll();
        if (count($groups)) {
            foreach ($groups as $group) {
                $results[$group['id']] = $group['name'];
            }
        }
        //
        return $results;
    }

    public function validateDelete($id) {
        if ((int) ProductAttribute::model()->count('attribute_set_id=:attribute_set_id', array(':attribute_set_id' => $id))) {
            return false;
        }
        return true;
    }

    public function getMaxSort() {
        return Yii::app()->db->createCommand()
                        ->select('MAX(sort_order)')
                        ->from(ClaTable::getTable('product_attribute_set'))
                        ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                        ->queryScalar();
    }

    public function getAttributeConfigurable($att_set_id, $att_ids = array()) {
        if (!$att_set_id)
            return;
        $where = (!empty($att_ids)) ? ' AND id IN(' . implode(',', $att_ids) . ')' : '';

        $con = '(attribute_set_id=:attribute_set_id OR is_system=1) AND is_configurable=1 AND  site_id=:site_id' . $where . ' ORDER BY sort_order';
        $params = array(':attribute_set_id' => $att_set_id, ':site_id' => Yii::app()->siteinfo['site_id']);
        return ProductAttribute::model()->findAll($con, $params);
    }

    public function getAttributeChangePrice($att_set_id) {
        return ProductAttribute::model()->findAll('(attribute_set_id=:attribute_set_id OR is_system=1) AND is_change_price=1 AND site_id=:site_id ORDER BY sort_order', array(':attribute_set_id' => $att_set_id, ':site_id' => Yii::app()->siteinfo['site_id']));
    }

}
