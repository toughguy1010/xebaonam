<?php

/**
 * This is the model class for table "menu_groups".
 *
 * The followings are the available columns in table 'menu_groups':
 * @property integer $menu_group_id
 * @property string $menu_group_name
 * @property string $menu_group_description
 * @property integer $site_id
 * @property integer $user_id
 * @property string $config
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $modified_by
 */
class MenuGroups extends ActiveRecord {

    const MENU_GROUP_TYPE_CUSTOM = 0;
    const MENU_GROUP_TYPE_SYSTEM = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('menu_groups');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('menu_group_name, menu_group_description', 'required'),
            array('user_id, created_time, modified_time, modified_by', 'numerical', 'integerOnly' => true),
            array('menu_group_name', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('menu_group_id, menu_group_name, menu_group_description, site_id, user_id, config, created_time, modified_time, modified_by,menu_group_type', 'safe'),
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
            'menu_group_id' => 'ID',
            'menu_group_name' => Yii::t('menu', 'menu_group_name'),
            'menu_group_description' => Yii::t('menu', 'menu_group_description'),
            'site_id' => 'Site',
            'user_id' => 'User',
            'config' => 'Config',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'modified_by' => 'Modified By',
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

        $criteria->compare('menu_group_id', $this->menu_group_id);
        $criteria->compare('menu_group_name', $this->menu_group_name, true);
        $criteria->compare('menu_group_description', $this->menu_group_description, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('config', $this->config, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->compare('modified_by', $this->modified_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 30,
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MenuGroups the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    function beforeSave() {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->user_id = $this->modified_by = Yii::app()->user->id;
            $this->created_time = $this->modified_time = time();
        } else {
            $this->modified_time = time();
            $this->modified_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

    /**
     * get all menu group in site
     * @return type
     */
    static function getAllMenuGroup() {
        $results = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('menu_group'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->queryAll();
        //
        return $results;
    }

    // Xoa menu group thi xoa het các menu thuoc group nay
    function afterDelete() {
        $menus = self::model()->findAllByAttributes(array(
            'menu_group' => $this->menu_group_id,
        ));
        if ($menus) {
            foreach ($menus as $menu) {
                $menu->delete();
            }
        }
        // Clear cache
        $claMenu = new ClaMenu(array('group_id' => $this->menu_group_id));
        $claMenu->deleteCache();
    }

}
