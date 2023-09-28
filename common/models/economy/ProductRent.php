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
class ProductRent extends ActiveRecord
{

    const PRODUCT_LEASE_LIMIT = 6;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return $this->getTableName('product_rent');
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
            // @todo Prent remove those attributes that should not be searched.
            array('alias', 'isAlias'),
            array('rent_id, site_id, user_id, name, description, status, meta_keywords, meta_description, meta_title, created_time, alias, showinhome', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'products' => array(self::HAS_MANY, 'ProductToRent', 'rent_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'rent_id' => 'Group',
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
            'showinhome' => Yii::t('common', 'or'),
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
        // @todo Prent modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('rent_id', $this->rent_id);
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
        ProductToRent::model()->deleteAllByAttributes(array('rent_id' => $this->rent_id));
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
            'order' => '`order` ASC'
        ));
        return new CArrayDataProvider($products, array(
            'pagination' => array(
                'pageSize' => $pagesize,
                'pageVar' => ClaSite::PAGE_VAR,
            ),
            'totalItemCount' => ProductRent::countProductInGroup($this->rent_id),
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Prent note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProductRent the static model class
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
            ->from(ClaTable::getTable('product_rent'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();
        foreach ($groups as $group) {
            $results[$group['rent_id']] = $group['name'];
        }
        //
        return $results;
    }

    /**
     * return all product group of site
     * @return type
     */
    static function getProductGroupAndProduct()
    {
        $groups = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_rent'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'])
            ->queryAll();

        $group_ids = array_map(function ($product) {
            return $product['rent_id'];
        }, $groups);

        if (isset($group_ids) && count($group_ids)) {
            // Get Produst
            $products = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('product_to_rent') . ' pTg')
                ->join(ClaTable::getTable('product') . ' p', 'pTg.product_id=p.id')
                ->where('pTg.rent_id IN (' . join(',', $group_ids) . ')')
                ->order('pTg.order ASC, pTg.created_time DESC')
                ->queryAll();

            $product_ids = array_map(function ($product) {
                return $product['product_id'];
            }, $products);

            $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc, total_rating, total_votes');

            foreach ($products as $pkey => $p) {
                $results[$p['id']] = $p;
                foreach ($product_info_array as $kpi => $product_info) {
                    if ($product_info['product_id'] == $p['id']) {
                        $products[$pkey]['product_info'] = $product_info;
                    }
                }
            }
            // Add pro to group
            foreach ($groups as $key => $g) {
                foreach ($products as $kpi => $product_info) {
                    if ($g['rent_id'] == $product_info['rent_id']) {
                        $groups[$key]['item'][] = $product_info;
                        unset($products[$kpi]);
                    }
                }
            }
            return $groups;
        }
    }


    /**
     * get products and its info
     * @param type $group_id
     * @param array $options
     */
    static function getProductInRent($rent_id, $options = array())
    {
        $group_id = (int)$rent_id;
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

            $product_info_array = Product::model()->findAllByAttributes('');

            $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc');

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


    public static function getProductByGroupids($ids, $select)
    {
        if (count($ids)) {
            $results = Yii::app()->db->createCommand()->select($select)
                ->from(ClaTable::getTable('product_to_rent'))
                ->where('rent_id IN (' . join(',', $ids) . ') AND site_id=:site_id', array(':site_id' => Yii::app()->controller->site_id))
                ->queryAll();
            return $results;
        } else {
            return array();
        }
    }

    static function getProductIdInGroups($rent_id)
    {
        $rent_id = (int)$rent_id;
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_to_rent'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND rent_id=' . $rent_id)
            ->queryAll();
        foreach ($products as $product) {
            $results[$product['product_id']] = $product['product_id'];
        }
        //
        return $results;
    }

    //
    /**
     * return product_id list
     * @param type $rent_id
     */
    static function getProductIdInGroup($rent_id)
    {
        $rent_id = (int)$rent_id;
        $products = Yii::app()->db->createCommand()->select()
            ->from(ClaTable::getTable('product_to_rent'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND rent_id=' . $rent_id)
            ->queryAll();
        foreach ($products as $product) {
            $results[$product['product_id']] = $product['product_id'];
        }
        //
        return $results;
    }

    /**
     * return product_id list
     * @param type $rent_id
     */
    static function countProductInGroup($rent_id)
    {
        $rent_id = (int)$rent_id;
        $count = Yii::app()->db->createCommand()->select('count(*)')
            ->from(ClaTable::getTable('product_to_rent'))
            ->where('site_id=' . Yii::app()->siteinfo['site_id'] . ' AND rent_id=' . $rent_id)
            ->queryScalar();
        //
        return (int)$count;
    }

    /**
     * get products and its info
     * @param type $rent_id
     * @param array $options
     */
    static function getProductInGroup($rent_id, $options = array())
    {
        $rent_id = (int)$rent_id;
        if (!isset($options['limit']))
            $options['limit'] = self::PRODUCT_DEFAUTL_LIMIT;
        if (!isset($options[ClaSite::PAGE_VAR])) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        if (!(int)$options[ClaSite::PAGE_VAR]) {
            $options[ClaSite::PAGE_VAR] = 1;
        }
        $offset = ($options[ClaSite::PAGE_VAR] - 1) * $options['limit'];
        if ($rent_id) {
            $products = Yii::app()->db->createCommand()->select()
                ->from(ClaTable::getTable('productrent') . ' pg')
                ->join(ClaTable::getTable('product_to_rent') . ' pTg', 'pTg.rent_id=pg.rent_id')
                ->join(ClaTable::getTable('product') . ' p', 'pTg.product_id=p.id')
                ->where('pg.rent_id=' . $rent_id)
                ->limit($options['limit'], $offset)
                ->order('pTg.order ASC, pTg.created_time DESC')
                ->queryAll();


            $product_ids = array_map(function ($product) {
                return $product['id'];
            }, $products);

            $product_info_array = ProductInfo::getProductInfoByProductids($product_ids, 'product_id, product_sortdesc');

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
}
