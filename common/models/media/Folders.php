<?php

/**
 * This is the model class for table "folders".
 *
 * The followings are the available columns in table 'folders':
 * @property integer $folder_id
 * @property integer $site_id
 * @property integer $user_id
 * @property string $folder_name
 * @property string $folder_description
 * @property integer $created_time
 * @property integer $modified_time
 */
class Folders extends ActiveRecord {

    const max_select_folder = 200;
    const DEFAULT_LIMIT = 50;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return $this->getTableName('folder');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('folder_name, folder_description', 'required'),
            array('site_id, user_id, created_time, modified_time', 'numerical', 'integerOnly' => true),
            array('folder_name, folder_description', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('folder_id, site_id, user_id, folder_name, folder_description, created_time, modified_time, alias', 'safe', 'on' => 'search'),
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
            'folder_id' => 'Folder',
            'site_id' => 'Site',
            'user_id' => 'User',
            'folder_name' => Yii::t('file', 'folder_name'),
            'folder_description' => Yii::t('file', 'folder_description'),
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'alias' => 'Alias',
        );
    }

    function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_time = $this->modified_time = time();
        } else {
            $this->modified_time = time();
        }
        return parent::beforeSave();
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
        $criteria->compare('folder_id', $this->folder_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('folder_name', $this->folder_name, true);
        $criteria->compare('folder_description', $this->folder_description, true);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('modified_time', $this->modified_time);
        $criteria->order = 'created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => ClaSite::PAGE_VAR,
            ),
        ));
    }

    function afterDelete() {
        $files = Files::model()->findAllByAttributes(array('site_id' => $this->site_id, 'folder_id' => $this->folder_id));
        foreach ($files as $file)
            $file->delete();
        parent::afterDelete();
    }

    /**
     * Lấy tất cả các nhóm banner do người dùng tạo ra
     * @return type
     */
    static function getFolderOptionsArr() {
        $results = array();
        $folders = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('folder'))
                ->where('site_id=' . Yii::app()->siteinfo['site_id'])
                ->limit(self::max_select_folder)
                ->queryAll();
        foreach ($folders as $folder) {
            $results[$folder['folder_id']] = $folder['folder_name'];
        }
        //
        $results = array('' => Yii::t('file', 'folder_select')) + $results;
        //        
        return $results;
    }

    /**
     * get fall 
     * @param type $options
     * @return type
     */
    static function getAllFolders($options = array()) {
        $limit = isset($options['limt']) ? $options['limt'] : self::DEFAULT_LIMIT;
        $siteid = Yii::app()->controller->site_id;
        $folders = Yii::app()->db->createCommand()->select()->from(ClaTable::getTable('folder'))
                        ->where("site_id=$siteid")->limit($limit)->queryAll();
        $results = array();
        foreach ($folders as $folder) {
            $results[$folder['folder_id']] = $folder;
            $results[$folder['folder_id']]['link'] = Yii::app()->createUrl('media/media/file', array('fid' => $folder['folder_id'], 'alias' => $folder['alias']));
        }
        //
        return $results;
    }

    /**
     * get total count of folder for site
     * @param type $options
     * @return int
     */
    static function TotalFolderCount($options = array()) {
        $siteid = Yii::app()->controller->site_id;
        $folders = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('folder'))
                ->where("site_id=$siteid");
        $count = $folders->queryScalar();
        return (int) $count;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Folders the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
