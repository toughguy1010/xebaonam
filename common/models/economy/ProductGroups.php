<?php

/**
 * This is the model class for table "product_groups".
 *
 * The followings are the available columns in table 'product_groups':
 * @property integer $group_id
 * @property integer $site_id
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property integer $status
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 * @property string $alias
 * @property integer $created_time
 */
class ProductGroups extends ActiveRecord
{

    const PRODUCT_DEFAUTL_LIMIT = 6;
    public $avatar = '';
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('productgroups');
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
            array('site_id, user_id, status, created_time', 'numerical', 'integerOnly' => true),
            array('name, meta_keywords, meta_description, meta_title', 'length', 'max' => 255),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('alias', 'isAlias'),
            array('group_id, site_id, user_id, name, description, status, meta_keywords, meta_description, meta_title, created_time, alias, showinhome, image_path, image_name, avatar', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'products' => array(self::HAS_MANY, 'ProductToGroups', 'group_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'group_id' => 'Group',
            'site_id' => 'Site',
            'user_id' => 'User',
            'name' => Yii::t('product', 'product_group_name'),
            'description' => Yii::t('product', 'product_group_description'),
            'status' => Yii::t('common', 'status'),
            'meta_keywords' => Yii::t('common', 'meta_keywords'),
            'meta_description' => Yii::t('common', 'meta_description'),
            'meta_title' => Yii::t('common', 'meta_title'),
            'created_time' => 'Created Time',
            'alias' => Yii::t('common', 'alias'),
            'showinhome' => Yii::t('common', 'showinhome'),
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

        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('site_id', $this->site_id);
        $criteria->compare('user_id', $this->user_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('created_time', $this->created_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState(Yii::app()->params['pageSizeName'], Yii::app()->params['defaultPageSize']),
                'pageVar' => 'page',
            ),
        ));
    }

    /**
     * delete products in group after delete group
     */
    public function afterDelete()
    {
        //deleete product in group
        ProductToGroups::model()->deleteAllByAttributes(array('group_id' => $this->group_id));
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
        $products = $this->products(array(
            'limit' => $pagesize * $page,
            //'offset' => ($page - 1) * $pagesize,
            'order' => '`order` ASC, id DESC'
        ));
        return new CArrayDataProvider($products, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductGroups::countProductInGroup($this->group_id),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductGroups the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->created_time = time();
            $this->alias = HtmlFormat::parseToAlias($this->name);
            if (!$this->site_id)
                $this->site_id = Yii::app()->controller->site_id;
        } else {
            if (!$this->alias && $this->name)
                $this->alias = HtmlFormat::parseToAlias($this->name);
        }
        return parent::beforeSave();
    }

    /**
     * return all product group of site
     * @return type
     */
    static function getProductGroupArr()
    {
        $results = array();
        $groups = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('productgroups'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();
        foreach ($groups as $group) {
            $results[$group['group_id']] = $group['name'];
        }
        //
        return $results;
    }

    //
    /**
     * return product_id list
     * @param type $group_id
     */
    static function getProductIdInGroup($group_id)
    {
        $group_id = (int)$group_id;
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_to_group'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND group_id=' . $group_id)
            ->queryAll();
        foreach ($products as $product) {
            $results[$product['product_id']] = $product['product_id'];
        }
        //
        return $results;
    }

    /**
     * return product_id list
     * @param type $group_id
     */
    static function countProductInGroup($group_id)
    {
        $group_id = (int)$group_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('product_to_group'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND group_id=' . $group_id)
            ->queryScalar();
        //
        return (int)$count;
    }

    /**
     * get products and its info
     * @param type $group_id
     * @param array $options
     */
    static function getProductInGroup($group_id, $options = array())
    {
        $group_id = (int)$group_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        if ($group_id) {
            $products = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('productgroups') . ' pg')
                ->join(ClaTable::getTable('product_to_group') . ' pTg', 'pTg.group_id=pg.group_id')
                ->join(ClaTable::getTable('product') . ' p', 'pTg.product_id=p.id')
                ->where('pg.group_id=' . $group_id)
                ->limit($options['limit'], $offset)
                ->order('pTg.order ASC, pTg.created_time DESC')
                ->queryAll();


            $product_ids = array_map(function ($product) {
                return $product['id'];
            }, $products);

            $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc, total_rating, total_votes, product_note');

            $results = array();
            foreach ($products as $p) {
                $results[$p['id']] = $p;
                foreach ($product_info_array as $kpi => $product_info) {
                    if ($product_info['product_id'] == $p['id']) {
                        $results[$p['id']]['product_info'] = $product_info;
                        unset($product_info_array[$kpi]);
                    }
                }
                $results[$p['id']]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $p['id'], 'alias' => $p['alias']));
                $results[$p['id']]['price_text'] = Product::getPriceText($p);
                $results[$p['id']]['price_market_text'] = Product::getPriceText($p, 'price_market');
                $results[$p['id']]['price_save_text'] = Product::getPriceText($p, 'price_save');
            }
            return $results;
        }
        return array();
    }

    /**
     * Get promotions that is show in home
     * @editor: HATV
     * Update: Show promotion in home ONLY IN PROMOTION TIME RANGE.
     * @param array
     */
    public static function getProductGroupInHome($options = array())
    {
        $siteid = Yii::app()->controller->site_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        //Set DF condition
        $condition = "site_id = $siteid AND status = " . ActiveRecord::STATUS_ACTIVED ." AND showinhome=" . self::SHOW_IN_HOME;
        //Query
        $params = array();
        $promotions = Yii::app()->db->createCommand()->select('*')->from(ClaTable::getTable('productgroups'))
            ->where($condition, $params)
            ->limit($options['limit'])
            ->queryAll();

        $results = array();
        foreach ($promotions as $pro) {
            $results[$pro['group_id']] = $pro;
            $results[$pro['group_id']]['link'] = Yii::app()->createUrl('economy/product/group', array('id' => $pro['group_id'], 'alias' => $pro['alias']));
        }

        return $results;
    }
}
