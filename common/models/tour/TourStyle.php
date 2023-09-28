<?php

/**
 * This is the model class for table "tour_info".
 *
 * The followings are the available columns in table 'tour_info':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $alias
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property integer $site_id
 */
class TourStyle extends ActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('tour_style');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('site_id', 'numerical', 'integerOnly' => true),
            array('id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 255),
            array('alias', 'length', 'max' => 500),
            array('alias', 'isAlias'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('name, description, alias', 'safe'),
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
            'name' => Yii::t('tour', 'style_name'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('site_id', $this->site_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->alias = HtmlFormat::parseToAlias($this->name);
        } else {
            if (!trim($this->alias) && $this->name)
                $this->alias = HtmlFormat::parseToAlias($this->name);
        }
        return parent::beforeSave();
    }

    public static function getOptionsStyles()
    {
        $data = Yii::app()->db->createCommand()->select('id, name')
            ->from(ClaTable::getTable('tour_style'))
            ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('id ASC')
            ->queryAll();
        $return[''] = '--- '.Yii::t("tour","select_tour_style").' ---';
        $return = $return + array_column($data, 'name', 'id');
        return $return;
    }
    public static function getStyles()
    {
        $data = Yii::app()->db->createCommand()->select('id, name')
            ->from(ClaTable::getTable('tour_style'))
            ->where('site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
            ->order('id ASC')
            ->queryAll();
        return $data;
    }
    static function getAllstyle()
    {
        $results = array();
        $styles = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('tour_style'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();
        foreach ($styles as $style) {
            $results[$style['id']] = $style['name'];
        }
        //
        return $results;
    }
    static function getAll()
    {
        $results = array();
        $styles = Yii::app()->db->createCommand()->select('id, name, alias, description')
            ->from(ClaTable::getTable('tour_style'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();
        foreach ($styles as $style) {
            $results[$style['id']] = $style;
            $results[$style['id']]['link'] = Yii::app()->createUrl('tour/tour/tourstyle', ['id' => $style['id'], 'alias' => $style['alias']]);
        }
        //
        return $results;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TourInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


    public static function getTourStyleByIds($ids, $select) {
        if (count($ids)) {
            $results = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('tour_style'))
                ->where('id IN (' . join(',', $ids) . ') AND site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
            return $results;
        } else {
            return array();
        }
    }

}
