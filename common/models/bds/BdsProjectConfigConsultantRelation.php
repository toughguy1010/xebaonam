<?php

/**
 * This is the model class for table "product_news_relation".
 *
 * The followings are the available columns in table 'product_news_relation':
 * @property integer $consultant_id
 * @property integer $event_id
 * @property integer $site_id
 * @property integer $created_time
 */
class BdsProjectConfigConsultantRelation extends CActiveRecord
{
    const CONSULTANT_DEFAUTL_LIMIT = 10;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'bds_project_config_consultant_relation';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('consultant_id, bds_project_config_id, site_id, created_time', 'required'),
            array('bds_project_config_id, site_id, created_time', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('bds_project_config_id, site_id, created_time', 'safe', 'on' => 'search'),
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
            'consultant_id' => 'Consultant',
            'bds_project_config_id' => 'Event',
            'site_id' => 'Site',
            'created_time' => 'Created Time',
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

        $criteria->compare('consultant_id', $this->consultant_id);
        $criteria->compare('bds_project_config_id', $this->bds_project_config_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductConsultantRelation the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * return bds_project_config_id list
     * @param int $bds_project_config_id
     */
    static function getConsultantIdInRel($bds_project_config_id)
    {
        $bds_project_config_id = (int)$bds_project_config_id;
        $list_rel = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('bds_project_config_consultant_relation'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND bds_project_config_id=' . $bds_project_config_id)
            ->queryAll();
        foreach ($list_rel as $each_rel) {
            $results[$each_rel['consultant_id']] = $each_rel['consultant_id'];
        }
        //
        return $results;
    }

    /**
     * return bds_project_config_id list
     * @param int $bds_project_config_id
     */
    static function countConsultantsInRel($bds_project_config_id)
    {
        $bds_project_config_id = (int)$bds_project_config_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('bds_project_config_consultant_relation'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND bds_project_config_id=' . $bds_project_config_id)
            ->queryScalar();
        //
        return (int)$count;
    }

    /**
     * get products and its info
     * @param type $bds_project_config_id
     * @param array $options
     */
    static function getConsultantsInRel($bds_project_config_id, $options = array())
    {
        $bds_project_config_id = (int)$bds_project_config_id;
        if (!isset($options['limit']))
            $options['limit'] = self::CONSULTANT_DEFAUTL_LIMIT;
        if ($bds_project_config_id) {
            $data = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('bds_project_config_consultant_relation') . ' pg')
                ->join(ClaTable::getTable('consultants') . ' p', 'pg.consultant_id=p.id')
                ->where('pg.site_id=' . Yii::app()->siteinfo['site_id'] . ' AND bds_project_config_id=' . $bds_project_config_id)
                ->limit($options['limit'])
                ->order('pg.created_time DESC')
                ->queryAll();
            $consultant = array();
            if ($data) {
                foreach ($data as $n) {
                    $n['consultant_sortdesc'] = nl2br($n['consultant_sortdesc']);
                    $n['link'] = Yii::app()->createUrl('media/consultant/detail', array('id' => $n['consultant_id'], 'alias' => $n['alias']));
                    array_push($consultant, $n);
                }
            }
            return $consultant;
        }
        return array();
    }

    /**
     * search all product and return CArrayDataProvider
     */
    public function SearchProducts()
    {

        $pagesize = Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']);
        if ($this->isNewRecord)
            return null;
        $page = Yii::app()->request->getParam(ClaSite::PAGE_VAR);
        if (!$page)
            $page = 1;
        $products = ProductRelation::model()->findAllByAttributes(array('site_id' => Yii::app()->siteinfo['site_id'], 'bds_project_config_id' => $this->bds_project_config_id), array('limit' => $pagesize * $page));
        return new CArrayDataProvider($products, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductRelation::countProductInRel($this->bds_project_config_id),
        ));
    }


}
