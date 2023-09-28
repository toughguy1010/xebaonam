<?php

/**
 * This is the model class for table "real_estate_project_info".
 *
 * The followings are the available columns in table 'real_estate_project_info':
 * @property integer $project_id
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $description
 * @property integer $site_id
 * @property string $map
 * @property string $traffic
 */
class RealEstateProjectInfo extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return ClaTable::getTable('real_estate_project_info');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('project_id, site_id', 'numerical', 'integerOnly' => true),
            array('meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            array('description, map, traffic, meta_keywords, meta_description, meta_title, target', 'safe'),
                // The following rule is used by search().
                // @todo Please remove those attributes that should not be searched.
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
            'project_id' => 'Project',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'meta_title' => 'Meta Title',
            'description' => Yii::t('realestate', 'Description'),
            'site_id' => 'Site',
            'map' => Yii::t('realestate', 'Map'),
            'traffic' => Yii::t('realestate', 'Traffic'),
            'target' => Yii::t('realestate', 'Target'),
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

        $criteria->compare('project_id', $this->project_id);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('map', $this->map, true);
        $criteria->compare('traffic', $this->traffic, true);
        $criteria->compare('target', $this->target, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RealEstateProjectInfo the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
