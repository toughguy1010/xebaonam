<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property integer $id
 * @property integer $site_id
 * @property string $name
 * @property string $src
 * @property string $link
 * @property integer $order
 * @property integer $created_time
 * @property integer $type
 * @property integer $showall
 * @property string $store_ids
 */
class OfficeImages extends ActiveRecord
{

    const BANNER_TYPE_IMAGE = 1;
    const BANNER_TYPE_FLASH = 2;
    const BANNER_SHOWALL_KEY = 'all';
    const BANNER_HOME_KEY = 'home';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('office_images');
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('type,name, src, to_area, from_area', 'required'),
            array('order, created_time, type', 'numerical', 'integerOnly' => true, 'min' => 0),
            array('name, src, link', 'length', 'max' => 255),
            array('link', 'url'),
            array('to_area', 'compare', 'compareAttribute' => 'from_area', 'operator' => '>='),
            array('id, site_id, name, src, link, order, created_time, type, description, target,showall, actived, from_area, to_area', 'safe'),
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
        return array();
    }

    function beforeSave()
    {
        $this->site_id = Yii::app()->controller->site_id;
        if ($this->isNewRecord) {
            $this->created_time = time();
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
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('src', $this->src, true);
        $criteria->compare('link', $this->link, true);
        $criteria->compare('order', $this->order);
        $criteria->compare('created_time', $this->created_time);
        $criteria->compare('type', $this->type);

        $criteria->order = 'created_time DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return OfficeImages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Cho phép những loại file nào
     * @return array
     */
    static function allowExtensions()
    {
        return array(
            'image/jpeg' => 'image/jpeg',
            'image/gif' => 'image/gif',
            'image/png' => 'image/png',
            'image/bmp' => 'image/bmp',
            'application/x-shockwave-flash' => 'application/x-shockwave-flash',
        );
    }

    //

    /**
     * Lấy loại banner theo extension
     * @param type $extension
     * @return type
     */
    static function getBannerTypeFromEx($extension = '')
    {
        if (!$extension)
            return;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
            case 'jpe':
            case 'gif':
            case 'png':
            case 'bmp':
                return self::BANNER_TYPE_IMAGE;
            case 'swf':
                return self::BANNER_TYPE_FLASH;
        }
    }

    static function getBannerTypes()
    {
        return array(
            self::BANNER_TYPE_IMAGE => Yii::t('banner', 'type_image'),
            self::BANNER_TYPE_FLASH => Yii::t('banner', 'type_flash'),
        );
    }

    /**
     * Lấy loại banner theo url
     * @param type $src
     * @return type
     */
    static function getBannerTypeFromSrc($src = '')
    {
        $pathinfo = pathinfo($src);
        $extension = isset($pathinfo['extension']) ? $pathinfo['extension'] : '';
        return self::getBannerTypeFromEx($extension);
    }

    /**
     * Lấy tất cả banner của site
     * @param type $site_id
     * @return type
     */
    static function getBannerArr($site_id = 0)
    {
        if (!$site_id)
            $site_id = Yii::app()->controller->site_id;
        $data = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('banner'))
            ->where('site_id=:site_id', array(':site_id' => $site_id))
            ->queryAll();
        $result = array();
        if ($data) {
            foreach ($data as $banner) {
                $result[$banner['id']] = $banner['name'];
            }
        }
        return $result;
    }

    //

    /**
     * Lấy tất cả banner trong group
     * @param type $group_id
     * @return array
     */
    static function getOfficeImages($options = array(), $is_flat = false)
    {
        if (!isset($options['limit']) || !$options['limit'])
            $options['limit'] = self::MIN_DEFAUT_LIMIT;

        $condition = 'site_id=:site_id AND actived=:actived';
        $params = array(
            ':site_id' => Yii::app()->siteinfo['site_id'],
            ':actived' => self::STATUS_ACTIVED
        );

        if (isset($options['area']) || $options['area']) {
            $condition .= ' AND from_area <= :area AND to_area >= :area';
            $params[':area'] = $options['area'];
        }
        if ($is_flat) {
            $condition .= ' AND type = 5';
        }else{
            $condition .= ' AND type != 5';
        }

        $bannes = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('office_images'))
            ->where($condition, $params)
            ->limit($options['limit'])
            ->order('order')
            ->queryAll();

        return $bannes;
    }


    /**
     * Kiểm tra target và trả về mã
     * @param type $banner
     */
    static function getTarget($banner = null)
    {
        $target = '';
        if ($banner && isset($banner['target'])) {
            if ($banner['target'] == Menus::TARGET_BLANK)
                $target = 'target="_blank"';
        }
        return $target;
    }

}
