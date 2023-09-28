<?php

/**
 * This is the model class for table "bds_project_config".
 *
 * The followings are the available columns in table 'bds_project_config':
 * @property string $id
 * @property string $name
 * @property string $alias
 * @property integer $ishot
 * @property string $province_id
 * @property string $district_id
 * @property string $ward_id
 * @property string $address
 * @property string $logo_path
 * @property string $logo_name
 * @property string $avatar_path
 * @property string $avatar_name
 * @property string $config1
 * @property string $config1_content
 * @property string $config1_image_path
 * @property string $config1_image_name
 * @property string $config2
 * @property string $config2_content
 * @property string $config2_image_path
 * @property string $config2_image_name
 * @property string $config3
 * @property string $config3_content
 * @property string $config3_image_path
 * @property string $config3_image_name
 * @property string $config4
 * @property string $config4_content
 * @property string $config4_image_path
 * @property string $config4_image_name
 * @property string $config5
 * @property string $config5_content
 * @property string $config5_image_path
 * @property string $config5_image_name
 * @property string $created_time
 * @property string $modified_time
 * @property integer $status
 * @property string $site_id
 */
class BdsProjectConfig extends ActiveRecord
{

    public $avatar = '';
    public $logo = '';
    public $config1_image = '';
    public $config2_image = '';
    public $config3_image = '';
    public $config4_image = '';
    public $config5_image = '';

    const PROJECT_DEFAUTL_LIMIT = 8;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('bds_project_config');
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
            array('status,custom_number_1,custom_number_2,custom_number_3', 'numerical', 'integerOnly' => true),
            array('name, alias, address, logo_path, logo_name, avatar_path, avatar_name, config1, config1_image_path, config1_image_name, config2, config2_image_path, config2_image_name, config3, config3_image_path, config3_image_name, config4, config4_image_path, config4_image_name, config5, config5_image_path, config5_image_name', 'length', 'max' => 255),
            array('province_id, district_id, ward_id,custom_number_1,custom_number_2,custom_number_3,custom_number_4', 'length', 'max' => 5),
            array('created_time, site_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, name, alias, ishot, province_id, district_id, ward_id, address, logo_path, logo_name, avatar_path, avatar_name, config1, config1_content, config1_image_path, config1_image_name, config2, config2_content, config2_image_path, config2_image_name, config3, config3_content, config3_image_path, config3_image_name, config4, config4_content, config4_image_path, config4_image_name, config5, config5_content, config5_image_path, config5_image_name, created_time, modified_time, status, site_id, avatar, logo, config1_image, config2_image, config3_image, config4_image, config5_image,custom_number_1,custom_number_2,custom_number_3,custom_number_4,layout_action,view_action,meta_title,meta_keywords,meta_description,news_category_id,hotline,youtube,facebook,email, category_id, category_track, short_description, order', 'safe'),
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
            'name' => 'Tên dự án',
            'ishot' => 'Dự án nổi bật',
            'province_id' => 'Tỉnh/thành phố',
            'district_id' => 'Quận/huyện',
            'ward_id' => 'Phường/xã',
            'address' => 'Địa chỉ',
            'logo_path' => 'Logo Path',
            'logo_name' => 'Logo Name',
            'avatar_path' => 'Avatar Path',
            'avatar_name' => 'Avatar Name',
            'config1' => 'Tiêu đề tùy chỉnh 1',
            'config1_content' => 'Nội dung tùy chỉnh 1',
            'config1_image_path' => 'Config1 Image Path',
            'config1_image_name' => 'Config1 Image Name',
            'config2' => 'Tiêu đề tùy chỉnh 2',
            'config2_content' => 'Nội dung tùy chỉnh 2',
            'config2_image_path' => 'Config2 Image Path',
            'config2_image_name' => 'Config2 Image Name',
            'config3' => 'Tiêu đề tùy chỉnh 3',
            'config3_content' => 'Nội dung tùy chỉnh 3',
            'config3_image_path' => 'Config3 Image Path',
            'config3_image_name' => 'Config3 Image Name',
            'config4' => 'Tiêu đề tùy chỉnh 4',
            'config4_content' => 'Nội dung tùy chỉnh 4',
            'config4_image_path' => 'Config4 Image Path',
            'config4_image_name' => 'Config4 Image Name',
            'config5' => 'Tiêu đề tùy chỉnh 5',
            'config5_content' => 'Nội dung tùy chỉnh 5',
            'config5_image_path' => 'Config5 Image Path',
            'config5_image_name' => 'Config5 Image Name',
            'created_time' => 'Created Time',
            'status' => 'Trạng thái',
            'site_id' => 'Site',
            'config1_image' => 'Ảnh tùy chọn 1',
            'config2_image' => 'Ảnh tùy chọn 2',
            'config3_image' => 'Ảnh tùy chọn 3',
            'config4_image' => 'Ảnh tùy chọn 4',
            'config5_image' => 'Ảnh tùy chọn 5',
            'custom_number_1' => 'Số Loại 1',
            'custom_number_2' => 'Số Loại 2',
            'custom_number_3' => 'Số Loại 3',
            'custom_number_4' => 'Số Loại 4',
            'view_action' => 'View',
            'layout_action' => 'Layout',
            'short_description' => 'Mô tả ngắn',
            'order' => 'Số thứ tự',
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
        $criteria->compare('province_id', $this->province_id, true);
        $criteria->compare('district_id', $this->district_id, true);
        $criteria->compare('ward_id', $this->ward_id, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('logo_path', $this->logo_path, true);
        $criteria->compare('logo_name', $this->logo_name, true);
        $criteria->compare('avatar_path', $this->avatar_path, true);
        $criteria->compare('avatar_name', $this->avatar_name, true);
        $criteria->compare('config1', $this->config1, true);
        $criteria->compare('config1_content', $this->config1_content, true);
        $criteria->compare('config1_image_path', $this->config1_image_path, true);
        $criteria->compare('config1_image_name', $this->config1_image_name, true);
        $criteria->compare('config2', $this->config2, true);
        $criteria->compare('config2_content', $this->config2_content, true);
        $criteria->compare('config2_image_path', $this->config2_image_path, true);
        $criteria->compare('config2_image_name', $this->config2_image_name, true);
        $criteria->compare('config3', $this->config3, true);
        $criteria->compare('config3_content', $this->config3_content, true);
        $criteria->compare('config3_image_path', $this->config3_image_path, true);
        $criteria->compare('config3_image_name', $this->config3_image_name, true);
        $criteria->compare('config4', $this->config4, true);
        $criteria->compare('config4_content', $this->config4_content, true);
        $criteria->compare('config4_image_path', $this->config4_image_path, true);
        $criteria->compare('config4_image_name', $this->config4_image_name, true);
        $criteria->compare('config5', $this->config5, true);
        $criteria->compare('config5_content', $this->config5_content, true);
        $criteria->compare('config5_image_path', $this->config5_image_path, true);
        $criteria->compare('config5_image_name', $this->config5_image_name, true);
        $criteria->compare('created_time', $this->created_time, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('site_id', $this->site_id, true);
        $criteria->compare('order', $this->order, true);

        $criteria->order = '`order` , created_time DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BdsProjectConfig the static model class
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

    public function getImages($option = array())
    {
        $result = array();
        $condition = 'project_config_id=:project_config_id AND site_id=:site_id';
        $params = array(':project_config_id' => $this->id, ':site_id' => Yii::app()->controller->site_id);
        if ($this->isNewRecord) {
            return $result;
        }
        $result = Yii::app()->db->createCommand()->select()
            ->from('bds_project_config_images')
            ->where($condition, $params)
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    /**
     * Lấy ảnh đầu của anh dự án
     * @param array $option
     * @return array
     */
    public function getFirstImagesByIds($option = array())
    {
        $result = array();
        $condition = 'project_config_id=:project_config_id AND site_id=:site_id';
        $params = array(':project_config_id' => $this->id, ':site_id' => Yii::app()->controller->site_id);
        if ($this->isNewRecord) {
            return $result;
        }
        $result = Yii::app()->db->createCommand()->select()
            ->from('bds_project_config_images')
            ->where($condition, $params)
            ->order('order ASC, img_id ASC')
            ->queryAll();

        return $result;
    }

    /**
     * Lấy những hotel của site
     * @param type $options
     * @return array
     */
    public static function getAllprojects($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PROJECT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'order, id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=' . $siteid . ' AND status =' . ActiveRecord::STATUS_ACTIVED;

        $project = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('bds_project_config'))
            ->where($condition)
            ->order($order)
            ->limit($options['limit'], $offset)
            ->queryAll();
        $results = array();
        foreach ($project as $t) {
            $results[$t['id']] = $t;
            $results[$t['id']]['link'] = Yii::app()->createUrl('bds/bdsProjectConfig/detail', array('id' => $t['id'], 'alias' => $t['alias']));
        }
        return $results;
    }

    /**
     * Lấy những hotel của site
     * @param type $options
     * @return array
     */
    public static function getProjects($options = array(), $countOnly = false)
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PROJECT_DEFAUTL_LIMIT;
        }
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        //order
        $order = 'order, id DESC';
        if (isset($options['order']) && $options['order']) {
            $order = $options['order'];
        }
        //
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=:site_id' . ' AND status =:status';
        $params = [
            'status' => ActiveRecord::STATUS_ACTIVED,
            'site_id' => $siteid
        ];
        //
        if (isset($options['category_id']) && $options['category_id']) {
            $condition .= " AND MATCH (category_track) AGAINST ('" . $options['category_id'] . "' IN BOOLEAN MODE)";
        }
        // Query
        if (!$countOnly) {
            $project = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('bds_project_config'))
                ->where($condition)
                ->order($order)
                ->limit($options['limit'], $offset)
                ->queryAll();
        } else {
            return Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('bds_project_config'))
                ->where($condition, $params)
                ->order($order)
                ->queryScalar();
        }
        $results = array();
        if (count($project)) {
            foreach ($project as $t) {
                $results[$t['id']] = $t;
                $results[$t['id']]['link'] = Yii::app()->createUrl('bds/bdsProjectConfig/detail', array('id' => $t['id'], 'alias' => $t['alias']));
            }
        }
        return $results;
    }


    public static function getAllProjectMenus($select)
    {
        $siteid = Yii::app()->controller->site_id;

        $items = Yii::app()->db->createCommand()->select($select)->from(ClaTable::getTable('bds_project_config'))
            ->where('status=:status AND site_id=:site_id', array(':status' => ActiveRecord::STATUS_ACTIVED, ':site_id' => $siteid))
            ->order('id DESC')
            ->queryAll();

        $results = array();

        foreach ($items as $c) {
            $results[$c['id']] = $c;
            $results[$c['id']]['link'] = Yii::app()->createUrl('bds/bdsProjectConfig/detail', array('id' => $c['id'], 'alias' => $c['alias']));
        }

        return $results;
    }

    static function countAll()
    {
        $siteid = Yii::app()->controller->site_id;
        $condition = 'site_id=' . $siteid . ' AND status=' . ActiveRecord::STATUS_ACTIVED;
        $project = Yii::app()->db->createCommand()->select('count(*)')->from(ClaTable::getTable('bds_project_config'))
            ->where($condition);
        $count = $project->queryScalar();
        return $count;
    }

    /**
     * Get hot project
     * @param type $options
     * @return array
     */
    public static function getHotProjects($options = array())
    {
        if (!isset($options['limit'])) {
            $options['limit'] = self::PROJECT_DEFAUTL_LIMIT;
        }
        $siteid = Yii::app()->controller->site_id;
        $projects = Yii::app()->db->createCommand()->select('*')
            ->from(ClaTable::getTable('bds_project_config'))
            ->where("site_id=$siteid AND `status`=" . ActiveRecord::STATUS_ACTIVED . " AND ishot=" . ActiveRecord::STATUS_ACTIVED)
            ->order('created_time DESC')
            ->limit($options['limit'])
            ->queryAll();
        foreach ($projects as $p) {
//   echo ClaHost::getImageHost() . $product['avatar_path'] . 's200_200/' . ['avatar_name']
            $results[$p['id']]['banner'] = '';
            $results[$p['id']] = $p;
            $results[$p['id']]['banner'] = BdsProjectConfigImages::model()
                ->find(array('condition' => "project_config_id = " . $p['id'], 'order' => '`order` ASC'))->attributes;
            $results[$p['id']]['link'] = Yii::app()->createUrl('bds/bdsProjectConfig/detail', array('id' => $p['id'], 'alias' => $p['alias']));
        }
        return $results;
    }

    /**
     * search all consultant and return CArrayDataProvider
     * @param
     */
    public function SearchConsultantRel()
    {
        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
//        if (!$page) {
//            $page = 1;
//        }
        $site_id = Yii::app()->controller->site_id;
        $products = BdsProjectConfigConsultantRelation::model()->findAllByAttributes(array(
                'site_id' => $site_id,
                'bds_project_config_id' => $this->id,
            )
        );
        return new CArrayDataProvider($products, array(
            'keyField' => 'consultant_id',
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => BdsProjectConfigConsultantRelation::countConsultantsInRel($this->id),
        ));
    }

    /**
     * get events and its info
     * @param type $bds_project_config_id
     * @param array $options
     */
    static function getConsultantInRel($bds_project_config_id, $options = array())
    {
        $bds_project_config_id = (int)$bds_project_config_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PROJECT_DEFAUTL_LIMIT;
        if ($bds_project_config_id) {
            $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('bds_project_config_consultant_relation') . ' pg')
                ->join(ClaTable::getTable('real_estate_consultant') . ' p', 'pg.consultant_id=p.id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND bds_project_config_id=' . $bds_project_config_id)
                ->limit($options['limit'])
                ->order('pg.created_time DESC')
                ->queryAll();
            $consultants = array();
            if ($data) {
                foreach ($data as $n) {
//                    $n['news_sortdesc'] = nl2br($n['news_sortdesc']);
                    $n['link'] = Yii::app()->createUrl('economy/consultant/detail', array('id' => $n['consultant_id'], 'alias' => $n['alias']));
                    array_push($consultants, $n);
                }
            }
            return $consultants;
        }
        return array();
    }


}
