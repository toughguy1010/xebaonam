<?php

/**
 * This is the model class for table "real_estate_project".
 *
 * The followings are the available columns in table 'real_estate_project':
 * @property string $id
 * @property integer $site_id
 * @property string $name
 * @property string $alias
 * @property integer $created_time
 * @property integer $modified_time
 * @property integer $status
 * @property string $image_path
 * @property string $image_name
 */
class RealEstateProject extends ActiveRecord
{

    public $avatar = '';

    const REALESTATE_PROJECT_HOT = 1;
    const REALESTATE_PROJECT_DEFAULT_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('real_estate_project');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
        return array(
            array('name', 'required'),
            array('site_id, created_time, modified_time, status, ishot', 'numerical', 'integerOnly' => true),
            array('name, alias, image_path, price_range, area, investor', 'length', 'max' => 255),
            array('sort_description', 'length', 'max' => 1000),
            array('image_name', 'length', 'max' => 200),
            array('province_id, district_id', 'length', 'max' => 4),
            array('news_category_id, real_estate_cat_id', 'length', 'max' => 11),
            array('province_name, district_name', 'length', 'max' => 100),
            array('time', 'length', 'max' => 500),
            // The following rule is used by search().
// @todo Please remove those attributes that should not be searched.
            array('id, site_id, name, alias, created_time, modified_time, status, image_path, image_name, user_id, avatar, avatar_id, province_id, district_id, address, province_name, district_name, sort_description, price_range, area, news_category_id, real_estate_cat_id, ishot, investor, time', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
// NOTE: you may need to adjust the relation name and the related
// class name for the relations automatically generated below.
        return array(
            'real_estate_project_info' => array(self::HAS_ONE, 'RealEstateProjectInfo', 'project_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'site_id' => 'Site',
            'name' => Yii::t('realestate', 'project'),
            'alias' => 'Alias',
            'created_time' => 'Created Time',
            'modified_time' => 'Modified Time',
            'status' => Yii::t('common', 'status'),
            'image_path' => 'Image Path',
            'image_name' => 'Image Name',
            'address' => Yii::t('realestate', 'address'),
            'province_id' => Yii::t('common', 'province'),
            'district_id' => Yii::t('common', 'district'),
            'sort_description' => Yii::t('common', 'sort_description'),
            'price_range' => Yii::t('realestate', 'price_range'),
            'area' => Yii::t('realestate', 'area'),
            'news_category_id' => Yii::t('realestate', 'news_category_id'),
            'real_estate_cat_id' => Yii::t('realestate', 'real_estate_cat_id'),
            'ishot' => Yii::t('realestate', 'ishot'),
            'investor' => Yii::t('common', 'investor'),
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

        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('real_estate_cat_id', $this->real_estate_cat_id);
        $criteria->compare('name', $this->name);
        $criteria->order = 'ishot DESC,created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function searchMyProject()
    {
// @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $this->site_id = Yii::app()->controller->site_id;
        $criteria->compare('id', $this->id, true);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', Yii::app()->user->id);
        $criteria->order = 'ishot DESC,created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return RealEstateProject the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
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

    public static function REALESTATE_PROJECT_STATUS_OLD()
    {
        return array('0' => 'Chưa Xác Định', '1' => 'Dự án sắp triển khai', '2' => 'Dự án đang triển khai', '3' => 'Dự án đã hoàn thành');
    }

    public static function REALESTATE_PROJECT_STATUS()
    {
        return array('0' => 'Chưa Xác Định', '1' => 'Dự án nhà ở', '2' => 'Dự án nghỉ dưỡng');
    }

    public static function getOptionProject()
    {
        $options = array();
        $options[0] = Yii::t('realestate', 'selectproject');
        $data = Yii::app()->db->createCommand()->select('id, name')
            ->from(ClaTable::getTable('real_estate_project'))
            ->where('site_id=:site_id AND status=:status', array(':site_id' => Yii::app()->controller->site_id, ':status' => ActiveRecord::STATUS_ACTIVED))
            ->queryAll();
        if (count($data)) {
            foreach ($data as $item) {
                $options[$item['id']] = $item['name'];
            }
        }
        return $options;
    }

    public static function getAllRealestateProject($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::REALESTATE_PROJECT_DEFAULT_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        /**/
        $offset = ((int)$options[ClaSite::PAGE_VAR] - 1) * $options ['limit'];
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        if (isset($options['real_estate_cat_id']) && $options['real_estate_cat_id']) {
            $condition .= ' AND real_estate_cat_id=:real_estate_cat_id';
            $params[':real_estate_cat_id'] = $options['real_estate_cat_id'];
        }
        $data = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('real_estate_project'))
            ->where($condition, $params)
            ->order('ishot DESC,created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        /**/
        $status = self::REALESTATE_PROJECT_STATUS();
        $realestateProject = array();
        if ($data) {
            foreach ($data as $n) {
                //Get Link, Type, Full address
                $n['link'] = Yii::app()->createUrl('news/realestateProject/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                $n['type'] = $status[$n['real_estate_cat_id']];
                $n['full_address'] = $n['address'];
                if ($n['full_address'] != '') {
                    $n['full_address'] .= ' - ' . $n['province_name'] . ' - ' . $n['district_name'];
                } else {
                    $n['full_address'] = $n['province_name'] . ' - ' . $n['district_name'];
                }
                //Get Image
                array_push($realestateProject, $n);
            }
        }
        return $realestateProject;
    }

    public static function countAllRealestateProject($options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND `status`=' . ActiveRecord::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);

        if (isset($options['real_estate_cat_id']) && $options['real_estate_cat_id']) {
            $condition .= ' AND real_estate_cat_id=:real_estate_cat_id';
            $params[':real_estate_cat_id'] = $options['real_estate_cat_id'];
        }

        $count = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from(ClaTable::getTable('real_estate_project'))
            ->where($condition, $params)
            ->queryScalar();
        return $count;
    }


    /**
     * @param $type
     * @param null $project_id
     * @return array
     */
    public static function getProjectImagesByType($id, $options = array())
    {

        $condition = ' project_id=:project_id AND site_id=:site_id ';
        $params = array(':project_id' => $id, ':site_id' => Yii::app()->controller->site_id);

        if (isset($options['type'])) {
            $condition .= ' AND type=:type';
            $params[':type'] = 1;
        }
        if (!isset($options['limit'])) {
            $options['limit'] = self::REALESTATE_PROJECT_DEFAULT_LIMIT;
        }

        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('real_estate_images'))
            ->where($condition, $params)
            ->order('order ASC, img_id ASC')
            ->limit($options['limit'])
            ->queryAll();
        return $data;
    }

    public function getImages()
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('real_estate_images'))
            ->where('project_id=:project_id AND site_id=:site_id', array(':project_id' => $this->id, ':site_id' => Yii::app()->controller->site_id))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    public function getImagesByType($type)
    {
        $result = array();
        if ($this->isNewRecord)
            return $result;
        $result = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('real_estate_images'))
            ->where('project_id=:project_id AND site_id=:site_id AND type=:type', array(':project_id' => $this->id, ':site_id' => Yii::app()->controller->site_id, 'type' => $type))
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    public static function getOptionCourse()
    {
        $option = array('' => 'Chọn dự án');
        $site_id = Yii::app()->controller->site_id;
        $array_option = Yii::app()->db->createCommand()
            ->select('id, name')
            ->from(ClaTable::getTable('real_estate_project'))
            ->where('site_id=:site_id AND status=:status', array(':site_id' => $site_id, ':status' => ActiveRecord::STATUS_ACTIVED))
            ->queryAll();
        foreach ($array_option as $item) {
            $option[$item['id']] = $item['name'];
        }
        return $option;
    }

    /**
     * Get course detail
     */
    public static function getProjectDetail($id = 0)
    {
        $id = (int)$id;
        if (!$id) {
            return false;
        }
        $project = self::model()->findByPk($id);
        if ($project) {
            $project->sort_description = nl2br($project->sort_description);
            return $project->attributes;
        }
        return false;
    }

    /**
     * hatv
     * Get hot project
     * @param type $options
     * @return array
     */
    public static function getHotProject($options = array())
    {
        $project_status = self::REALESTATE_PROJECT_STATUS();
        if (!isset($options['limit'])) {
            $options['limit'] = self::REALESTATE_PROJECT_DEFAULT_LIMIT;
        }
//select
        $select = '*';
//        if (isset($options['full']) && $options['full'])
//            $select = '*';
//
        $siteid = Yii::app()->controller->site_id;
        $projects = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('real_estate_project'))
            ->where("site_id=:site_id AND ishot=:ishot AND status=:status", array(':site_id' => $siteid, 'ishot' => self::REALESTATE_PROJECT_HOT, ':status' => self::STATUS_ACTIVED))
            ->order('created_time DESC')
            ->limit($options['limit'])
            ->queryAll();
        $results = array();
        foreach ($projects as $project) {
            $results[$project['id']] = $project;
            $results[$project['id']]['type'] = $project_status[$project['real_estate_cat_id']];
            $results[$project['id']]['sort_description'] = nl2br($results[$project['id']]['sort_description']);
            $results[$project['id']]['link'] = Yii::app()->createUrl('news/realestateProject/detail', array('id' => $project['id'], 'alias' => $project['alias']));
        }
        return $results;
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchVideosRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
//        if ($page = Yii::app()->request->getParam(ClaSite::PAGE_VAR)) {
//            $page = 1;
//        }
        $site_id = Yii::app()->controller->site_id;
        $products = RealEstateVideoRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'project_id' => $this->id,
            )
        );
        return new CArrayDataProvider($products, array(
            'keyField' => 'project_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => EventVideoRelation::countVideoInRel($this->id),
        ));
    }

    public static function getRealestateProjectInCategory($cat_id, $options = array(), $countOnly = false)
    {
        if (!$cat_id) {
            return array();
        }

        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id AND status=' . self::STATUS_ACTIVED;
        $params = array(':site_id' => $siteid);
        /**/
        if (!isset($options['limit'])) {
            $options['limit'] = self::REALESTATE_PROJECT_DEFAULT_LIMIT;
        }
        // Get all level children of category
        $children = array();
        if (!isset($options['children'])) {
            $category = new ClaCategory(array('type' => ClaCategory::CATEGORY_REAL_ESTATE, 'create' => true));
            $children = $category->getChildrens($cat_id);
        } else {
            $children = $options['children'];
        }
        /*==>*/
        if ($children && count($children)) {
            $children[$cat_id] = $cat_id;
            $condition .= ' AND real_estate_cat_id IN ' . '(' . implode(',', $children) . ')';
        } else {
            $condition .= ' AND real_estate_cat_id=:real_estate_cat_id';
            $params[':real_estate_cat_id'] = $cat_id;
        }
        /**/
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        //select
        $select = '*';
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        /*Count Only*/
        if ($countOnly) {
             $count = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('real_estate_project'))
                ->where($condition, $params)
                ->queryScalar();
            return $count;
        }
        /*Get Data*/
        $data = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('real_estate_project'))
            ->where($condition, $params)
            ->order('ishot DESC,created_time DESC')
            ->limit($options['limit'], $offset)
            ->queryAll();
        $realestate_project = array();
        if ($data) {
            foreach ($data as $n) {
                $n['sort_description'] = nl2br($n['sort_description']);
                $n['link'] = Yii::app()->createUrl('news/realestateProject/detail', array('id' => $n['id'], 'alias' => $n['alias']));
                array_push($realestate_project, $n);
            }
        }
        return $realestate_project;
    }
}
