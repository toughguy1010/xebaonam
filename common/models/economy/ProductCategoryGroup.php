<?php

/**
 * This is the model class for table "product_category_group".
 *
 * The followings are the available columns in table 'product_category_group':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property string $ids_group
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $site_id
 */
class ProductCategoryGroup extends ActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('product_category_group');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, ids_group', 'required'),
            array('created_time, modified_time, site_id', 'numerical', 'integerOnly' => true),
            array('name, alias, ids_group', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, ids_group, created_time, modified_time, site_id', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'name' => 'Tên nhóm',
            'alias' => 'Alias',
            'ids_group' => 'Id các danh mục',
            'created_time' => 'Thời gian tạo',
            'modified_time' => 'Thời gian cập nhật',
            'site_id' => 'Site Id',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('ids_group', $this->ids_group, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductCategoryGroup the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->alias = HtmlFormat::parseToAlias($this->name);
            $this->created_time = time();
            $this->modified_time = $this->created_time;
        } else {
            $this->alias = HtmlFormat::parseToAlias($this->name);
            $this->modified_time = time();
        }
        return parent::beforeSave();
    }

    /**
     * get location of this object
     */
    function getGroup() {
        $results = array();
        if ($this->ids_group) {
            $categories = explode(',', $this->ids_group);
            foreach ($categories as $cat)
                $results[$cat] = $cat;
        }
        return $results;
    }

    /**
     * return trade array
     */
    static function getCategoryArr($parent = 0)
    {
        $site_id = Yii::app()->controller->site_id;
        $condition = 'status=:status AND site_id=:site_id and cat_parent=:cat_parent';
        $params = [
            ':status' => ActiveRecord::STATUS_ACTIVED,
            ':site_id' => $site_id,
            ':cat_parent' => $parent
        ];
        $categories = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('productcategory'))
            ->where($condition, $params)
            ->queryAll();
        $returns = array();
        foreach ($categories as $category) {
            $returns[$category['cat_id']] = $category['cat_name'];
        }
        //
        return $returns;
    }

    static function getCategoryGroupArr()
    {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_category_group'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();
        foreach ($groups as $group) {
            $results[$group['id']] = $group['name'];
        }
        //
        return $results;
    }
}
