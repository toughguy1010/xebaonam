<?php

class ClaShoppingCart extends BaseHelper
{

    const PRODUCT_QUANTITY_KEY = 'qty';
    const PRODUCT_ID_KEY = 'pid';
    const PRODUCT_RENT_KEY = 'rpid';
    const PRODUCT_ATTRIBUTE_CONFIGURABLE_KEY = 'attrConfig';
    const PRODUCT_ATTRIBUTE_CHANGEPRICE_KEY = 'attrChangeprice';
    const MORE_INFO = 'more';
    const LIMIT_SET = 5; //Giới hạn số lượng set.

//    public $coint_per_bonus = 1000;
//

    private $_products = array();
    private $ProductInfo = array();
    private $coupon_code = '';
    private $use_bonus_points = false;
    private $point_used = '';
    private $discountPercent = 0;
    protected $priceRanges = array();
    protected $sumProducts = array(); // tong product theo product_id
    protected $productCurrency = '';

    /**
     * Add product to shopping cart
     * @param type $productId
     * @param type $options
     */
    public function add($key, $options = array())
    {
        $product_id = isset($options['product_id']) ? $options['product_id'] : 0;
        $update = isset($options['update']) ? $options['update'] : 0;
        $quantity = isset($options['qty']) ? $options['qty'] : 0;
        $price = isset($options['price']) ? $options['price'] : 0;
        $is_configurable = isset($options['is_configurable']) ? $options['is_configurable'] : 0;
        $moreInfo = isset($options[self::MORE_INFO]) ? $options[self::MORE_INFO] : array();
        if (!$product_id || !$quantity || !$price)
            return false;
        /*
         * If Dont use set - Default
         * */
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            if (!isset($this->_products[$key])) {
                $this->_products[$key]['qty'] = $quantity;
            } else {
                if ($update == 1) {
                    $this->_products[$key]['qty'] = $quantity;
                } else {
                    $this->_products[$key]['qty'] += $quantity;
                }
            }
            $this->_products[$key]['is_configurable'] = $is_configurable;
            $this->_products[$key]['price'] = $price;
            $this->_products[$key]['product_id'] = $product_id;
            $this->_products[$key][self::MORE_INFO] = $moreInfo;
            return true;
        } else {
            /*
             *  Use set - Hatv
             * */
            $set = isset($options['set']) ? (int)$options['set'] : null;
            if (isset($set)) {
                if (!isset($this->_products[$set][$key]))
                    $this->_products[$set][$key]['qty'] = $quantity;
                else {
                    if ($update == 1) {
                        $this->_products[$key]['qty'] = $quantity;
                    } else {
                        $this->_products[$key]['qty'] += $quantity;
                    }
                }
                $this->_products[$set][$key]['is_configurable'] = $is_configurable;
                $this->_products[$set][$key]['price'] = $price;
                $this->_products[$set][$key]['product_id'] = $product_id;
                $this->_products[$set][$key][self::MORE_INFO] = $moreInfo;
            } else if ($options['make_set']) {
                $temp = array();
                $temp[$key]['qty'] = $quantity;
                $temp[$key]['is_configurable'] = $is_configurable;
                $temp[$key]['price'] = $price;
                $temp[$key]['product_id'] = $product_id;
                $temp[$key][self::MORE_INFO] = $moreInfo;
                $this->_products[][$key] = $temp[$key];
            }
        }
    }

    /**
     * Change qty of product on shopping cart
     * @param int $key
     * @param array $options
     * @param int $set
     * @Hatv
     */
    public function changeQty($key, $options = array(), $set = null)
    {
        $product_id = isset($options['product_id']) ? $options['product_id'] : 0;
        $quantity = isset($options['qty']) ? $options['qty'] : 0;
        $price = isset($options['price']) ? $options['price'] : 0;
        $moreInfo = isset($options[self::MORE_INFO]) ? $options[self::MORE_INFO] : array();
        if (!$product_id || !$quantity || !$price) {
            return false;
        }
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            if (isset($this->_products[$key])) {
                $this->_products[$key]['qty'] = $quantity;
            }
            $this->_products[$key]['price'] = $price;
            $this->_products[$key]['product_id'] = $product_id;
            $this->_products[$key][self::MORE_INFO] = $moreInfo;
            return true;
        } else if (!is_null($set) && Yii::app()->siteinfo['use_shoppingcart_set']) { // add hatv
            if (isset($this->_products[$set][$key])) {
                $this->_products[$set][$key]['qty'] = $quantity;
            }
            $this->_products[$set][$key]['price'] = $price;
            $this->_products[$set][$key]['product_id'] = $product_id;
            $this->_products[$set][$key][self::MORE_INFO] = $moreInfo;
            return true;
        }
    }

    /**
     * Add coupon code
     * @param type $code
     * @return boolean
     * @hungtm
     */
    public function addCouponCode($code)
    {
        if (isset($code) && $code) {
            $this->coupon_code = $code;
            return true;
        }
        return false;
    }

    /**
     * RemoveCouponCode
     * @param  $code
     * @return boolean
     * @hatv
     */
    public function removeCouponCode()
    {
        $this->coupon_code = '';
        return true;
    }

    /**
     * Get current couponCode is apply
     * @hungtm
     * @edit Hatv : check date realise, time used.
     * @return string
     */
    public function getCouponCode()
    {
        return $this->coupon_code;
    }

    /**
     * Get discount
     * @param type $product_id
     * @param type $quantity
     */
    function getDiscount($product_id = 0, $quantity = 0)
    {
        $discount = 0;
        $product_id = (int)$product_id;
        $quantity = (int)$quantity;

        if ($product_id && $quantity) {
            $priceRanges = $this->getPriceRanges($product_id);
            if ($priceRanges) {
                foreach ($priceRanges as $key => $range) {
                    if ($range['quantity_from'] <= $quantity && $quantity <= $range['quantity_to']) {
                        $discount = $range['price'];
                        break;
                    } elseif ($range['quantity_from'] <= $quantity && $range['quantity_to'] == 0) {
                        $discount = $range['price'];
                        break;
                    }
                }
            }
        }
        return $discount;
    }

    function getPriceRanges($product_id = 0)
    {
        $ranges = array();
        if ($product_id) {
            $ranges = isset($this->priceRanges[$product_id]) ? $this->priceRanges[$product_id] : ProductWholesalePrice::getWholesalePriceByProductid($product_id);
            $this->priceRanges[$product_id] = $ranges;
        }
        return $ranges;
    }

    /**
     * Get coupon discount's value via attribute.
     * @return int
     * @author: hatv
     * */
    public function getDiscountCoupon($formatted = false)
    {
        $discount = 0;
        /* Check Coupon */
        if (isset($this->coupon_code) && $this->coupon_code != '') {
            $couponCode = CouponCode::model()->findByAttributes(array(
                'code' => $this->coupon_code,
                'site_id' => Yii::app()->controller->site_id,
            ));
        }
        if ($couponCode !== NULL) {
            /* Get coupon campain */
            $couponCampaign = CouponCampaign::model()->findByPk($couponCode->campaign_id);
            $cpType = $couponCampaign->coupon_type;
            $cpApply = $couponCampaign->applies_to_resource;
            $totalPrice = $this->getTotalPrice(false);

            if ($cpType == CouponCampaign::TYPE_SHIPPING) { /* TYPE_SHIPPING */
                return CouponCampaign::TYPE_SHIPPING;
            } else if ($cpApply == CouponCampaign::APPLY_MINIMUM && $totalPrice >= $couponCampaign->minimum_order_amount) { /* APPLY_MINIMUM */
                if ($couponCampaign->coupon_type == CouponCampaign::TYPE_FIXED_AMOUNT) { /* TYPE_FIXED_AMOUNT */
                    $discount = (($totalPrice - $couponCampaign->coupon_value) > 0) ? $couponCampaign->coupon_value : $totalPrice;
                } else if ($couponCampaign->coupon_type == CouponCampaign::TYPE_PERCENTAGE) { /* TYPE_PERCENTAGE */
                    $discount = ($totalPrice * $couponCampaign->coupon_value) / 100;
                }
            } else if ($cpApply == CouponCampaign::APPLY_ALL) { /* APPLY_ALL */
                if ($couponCampaign->coupon_type == CouponCampaign::TYPE_FIXED_AMOUNT) { /* TYPE_FIXED_AMOUNT */
                    $discount = (($totalPrice - $couponCampaign->coupon_value) > 0) ? $couponCampaign->coupon_value : $totalPrice;
                } else if ($couponCampaign->coupon_type == CouponCampaign::TYPE_PERCENTAGE) { /* TYPE_PERCENTAGE */
                    $discount = ($totalPrice * $couponCampaign->coupon_value) / 100;
                }
            } else if ($cpApply == CouponCampaign::APPLY_CATEGORY) { /* APPLY_CATEGORY */
                $products = $this->findAllProducts();
                if ($products) {
                    foreach ($products as $key => $product) {
                        if (!in_array($couponCampaign->category_id, explode(' ', $product['category_track']))) {
                            unset($products[$key]);
                            continue;
                        };
                    }
                }
                /* applies_one */
                if ($couponCampaign->applies_one && count($products) > 0) {
                    /* find max price product */
                    $max_price = 0;
                    $product = null; //will hold item with max val;
                    foreach ($products as $key => $value) {
                        if ($value['price'] > $max_price) {
                            $max_price = $value['price'];
                            $product = $value;
                        }
                    }
                    if (isset($product)) {
                        if ($couponCampaign->coupon_type == CouponCampaign::TYPE_FIXED_AMOUNT) { /* TYPE_FIXED_AMOUNT */
                            $discount = (($couponCampaign->coupon_value - $product['price']) > 0) ? $product['price'] : $couponCampaign->coupon_value;
                        } else if ($couponCampaign->coupon_type == CouponCampaign::TYPE_PERCENTAGE) { /* TYPE_PERCENTAGE */
                            $discount = ($couponCampaign->coupon_value * $product['price']) / 100;
                        }
                    }
                } else if (!$couponCampaign->applies_one && count($products) > 0) {
                    $products_ary = $this->_products;
                    foreach ($products as $key => $product) {
                        if ($couponCampaign->coupon_type == CouponCampaign::TYPE_FIXED_AMOUNT) {
                            $discount += (($couponCampaign->coupon_value - $product['price']) > 0) ? ($product['price'] * $products_ary[$key]['qty']) : ($couponCampaign->coupon_value * $products_ary[$key]['qty']);
                        } else if ($couponCampaign->coupon_type == CouponCampaign::TYPE_PERCENTAGE) {
                            $discount += ($couponCampaign->coupon_value * $product['price']) / 100;
                        }
                    }
                }
            } else if ($cpApply == CouponCampaign::APPLY_PRODUCT) {
                $discount = $couponCampaign->coupon_value;
            }
        }
        if ($formatted) {
            return Product::getPriceText(array('price' => $discount, 'currency' => $this->getProductCurrency()));
        }
        return $discount;
    }

    /**
     * Giá sau khi đã trừ giảm coupon and bonus
     * @return mixed
     * @author: Hatv
     */
    public function getTotalPriceDiscount($formatted = false)
    {
        $total = 0;
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            $total_price = $this->getTotalPrice(false);
            $discount = $this->getDiscountCouponAndBonus();
            $total = $total_price - $discount;
            if ($total < 0) {
                $total = 0;
            }
        }
        if ($formatted) {
            return Product::getPriceText(array('price' => $total, 'currency' => $this->getProductCurrency()));
        }
        return $total;
    }

    /**
     * @hungtm
     * @return type
     */
    public function getTotalPriceShop($products)
    {
        $_products = $this->_products;
        $total_price = 0;
        foreach ($products as $product) {
            $total_price += $this->getTotalPriceForProduct($product['id'], false);
        }
        return $total_price;
    }

    /**
     * Kiểm tra thêm xem có sử dụng điểm cộng không và giảm giá vào giá chính.
     * @return int
     * @author: hatv
     */
    public function getDiscountCouponAndBonus()
    {
        $discount = $this->getDiscountCoupon();
        $bonus = 0;
        /* Check Coupon */
        if ($this->checkPointUsed()) {
            $bonus = $this->point_used;
        }
        if ($bonus) {
            $discount += ($bonus * $this->getBonusConfig()->price_per_point);
        }
        return $discount;
    }

    /**
     * Update product in shopping cart
     * @param int $key
     * @param array $options
     */
    public function update($key, $options = array())
    {
        $quantity = isset($options['qty']) ? (int)$options['qty'] : 0;
        $price = isset($options['price']) ? $options['price'] : 0;
        $product_id = isset($options['product_id']) ? $options['product_id'] : 0;
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            if (!$quantity || !$price || !isset($this->_products[$key]))
                return false;
            if ($quantity) {
                if (!$this->_products[$key])
                    $this->_products[$key]['price'] = $price;
                $this->_products[$key]['qty'] = $quantity;
            } else
                $this->remove($key);
        } else {

            $set = isset($options['set']) ? $options['set'] : 0;
            if (!$quantity || !$price || !isset($this->_products[$set][$key]))
                return false;
            if ($quantity) {
                if (!$this->_products[$set][$key])
                    $this->_products[$set][$key]['price'] = $price;
                $this->_products[$set][$key]['qty'] = $quantity;
            } else
                $this->remove($key, $set);
        }
    }

    /**
     * Remove product in shopping cart
     * @param int $key
     * @param int $set
     */
    public function remove($key, $set = null)
    {
        if (is_null($set)) {
            if (isset($this->_products[$key]))
                unset($this->_products[$key]);
        } else {
            if (isset($this->_products[$set][$key]))
                unset($this->_products[$set][$key]);
        }
    }

    public function removeProductAttribute($id)
    {
        foreach ($this->_products as $key_pr => $pr) {
            if ($id == $pr['product_id']) {
                unset($this->_products[$key_pr]);
            }
        }
    }

    public function removeAll()
    {
        unset($this->_products);
    }

    /**
     * Remove set in shopping cart ( Eg: quananngon.com.vn)
     * @param int $key
     * @param int $set
     */
    public function removeSet($set)
    {
        if (isset($this->_products[$set])) {
            unset($this->_products[$set]);
            unset($this->ProductInfo[$set]);
        }
    }

    /**
     * Get all products in shop cart
     * @param int $key
     * @param int $set
     */
    public function getProducts()
    {
        return $this->_products;
    }

    /*
     * Get set product
     * @author :Hatv
     * */
    public function getSetProducts($key)
    {
        return $this->_products[$key];
    }

    /*
     * Get product info in shoppingcart by key
     * @editor: Hatv
     * */
    public function getInfoByKey($key, $set = null)
    {
        if (is_null($set)) {
            $info = isset($this->_products[$key]) ? $this->_products[$key] : null;
        } else {
            $info = isset($this->_products[$set][$key]) ? $this->_products[$set][$key] : null;
        }
        return $info;
    }

    public function getQuantity($key, $set = null)
    {
        if (is_null($set)) {
            if (isset($this->_products[$key]['qty']))
                return $this->_products[$key]['qty'];
            else
                return null;
        } else {
            if (isset($this->_products[$set][$key]['qty']))
                return $this->_products[$set][$key]['qty'];
            else
                return null;
        }
    }

    /**
     * Trả về (SL x Gia) của mỗi sản phẩm trong giỏ hàng
     * @param int $key
     * @param boolean $formatted
     * @param boolean $is_configurable
     * @param int $set
     * @return int
     */
    public function getTotalPriceForProduct($key, $formatted = true, $is_configurable = false, $set = null)
    {
        if (is_null($set)) {
            if (!is_null($this->getQuantity($key))) {
                if ($is_configurable) {
                    $product = $this->findProductConfigurable($key);
                } else {
                    $product = $this->findProduct($key);
                }
                if ($product) {
                    $total = $product['price'] * $this->getQuantity($key);
                    $this->setProductCurrency($product['currency']);
                    if ($formatted) {
                        // TODO: format price according to store settings
                        $temp = [];
                        if (is_array($product)) {
                            $temp = $product;
                        } else {
                            $temp = $product->attributes;
                        }
                        return Product::getPriceText(array_merge($temp, array('price' => $total, 'currency' => $this->getProductCurrency())));
                    } else {
                        return $total;
                    }
                }
            }
        } else {
            if (!is_null($this->getQuantity($key, $set))) {
                if ($is_configurable) {
                    $product = $this->findProductConfigurable($key);
                } else {
                    $product = $this->findProduct($key, $set);
                }
                if ($product) {
                    $total = $product['price'] * $this->getQuantity($key, $set);
                    $this->setProductCurrency($product['currency']);
                    if ($formatted) {
                        // TODO: format price according to store settings
                        return Product::getPriceText(array_merge($product->attributes, array('price' => $total, 'currency' => $this->getProductCurrency())));
                    } else
                        return $total;
                }
            }
        }
        return 0;
    }

    /**
     * @param $key
     * @param bool $formatted
     * @return int|string
     */
    public function getTotalBonusPointForProduct($key, $formatted = true)
    {
        if (!is_null($this->getQuantity($key))) {
            $product = $this->findProduct($key);
            if ($product) {
                $total = $product['bonus_point'] * $this->getQuantity($key);
                $this->setProductCurrency($product['currency']);
                if ($formatted) {
                    // TODO: format price according to store settings
                    return Product::getPriceText(array('price' => $total, 'currency' => $this->getProductCurrency()));
                } else
                    return $total;
            }
        }
        return 0;
    }

    /**
     * Return total donate of product in shopping cart
     * @param int $key
     * @param boolean $formatted
     * @return int
     */
    public function getTotalDonateForProduct($key, $formatted = true)
    {
        if (!is_null($this->getQuantity($key))) {
            $product = $this->findProduct($key);
            if ($product) {
                $total = $product['donate'] * $this->getQuantity($key);
                $this->setProductCurrency($product['currency']);
                if ($formatted) {
                    // TODO: format price according to store settings
                    return Product::getPriceText(array('price' => $total, 'currency' => $this->getProductCurrency()));
                } else {
                    return $total;
                }
            }
        }
        return 0;
    }

    public function findProductConfigurable($key, $set = null)
    {

        $exp = explode('_', $key);
        $product_id = $exp[0];
        $configurable_id = $exp[1];

        $product_configurable = AttributeHelper::helper()->getProductConfigurable($product_id, $configurable_id);
        return $product_configurable;
    }

    public function findProduct($key, $set = null)
    {
        // Dont use set - Default
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
//            if (isset($this->ProductInfo[$key]) && count($this->ProductInfo[$key])) {
//                $product = $this->ProductInfo[$key];
//            } else {
            $cartInfo = $this->getInfoByKey($key);
            $product = Product::model()->findByPk($cartInfo['product_id']);
            if ($product) {
                $totalProduct = $this->getSumProduct($product->id);
                $discount = $this->getDiscount($product->id, $totalProduct);
                if ($this->getTypeAttByKey($key) == ProductAttribute::TYPE_ATTRIBUTE_CONFIGURABLE) {
                    $attributes = $this->getAttributesByKey($key);
                    if ($attributes && count($attributes)) {
                        $where = 'site_id = ' . Yii::app()->controller->site_id . ' AND product_id=' . $cartInfo['product_id'];
                        $params = array();
                        foreach ($attributes as $attr) {
                            $where .= ' AND ' . $attr['field_configurable'] . '=:' . $attr['field_configurable'];
                            $params[':' . $attr['field_configurable']] = $attr['field_configurable_value'];
                        }
                        $proConfigVal = ProductConfigurableValue::model()->find($where, $params);
                        if ($proConfigVal && $proConfigVal['price']) {
                            $product->price = $proConfigVal['price'];
                        }
                    }
                } elseif ($this->getTypeAttByKey($key) == ProductAttribute::TYPE_ATTRIBUTE_CHANGEPRICE) {
                    $attributes = $this->getAttributesByKey($key);
                    if ($attributes && count($attributes)) {
                        foreach ($attributes as $attr) {
                            $product->price += (int)$attr['change_price'];
                        }
                    }
                }
                $product->price = $product->price - $discount;
            }
            $this->ProductInfo[$key] = $product;
//            }
        } else if (Yii::app()->siteinfo['use_shoppingcart_set'] && !is_null($set)) {
            //Use set - hatv
            if (isset($this->ProductInfo[$set][$key])) {
                $product = $this->ProductInfo[$set][$key];
            } else {
                $cartInfo = $this->getInfoByKey($key, $set);
                $product = Product::model()->findByPk($cartInfo['product_id']);
                if ($product) {
                    if ($this->getTypeAttByKey($key) == ProductAttribute::TYPE_ATTRIBUTE_CONFIGURABLE) {
                        $attributes = $this->getAttributesByKey($key);
                        if ($attributes && count($attributes)) {
                            $where = 'site_id = ' . Yii::app()->controller->site_id . ' AND product_id=' . $cartInfo['product_id'];
                            $params = array();
                            foreach ($attributes as $attr) {
                                $where .= ' AND ' . $attr['field_configurable'] . '=:' . $attr['field_configurable'];
                                $params[':' . $attr['field_configurable']] = $attr['field_configurable_value'];
                            }
                            $proConfigVal = ProductConfigurableValue::model()->find($where, $params);
                            if ($proConfigVal && $proConfigVal['price']) {
                                $product->price = $proConfigVal['price'];
                            }
                        }
                    } elseif ($this->getTypeAttByKey($key) == ProductAttribute::TYPE_ATTRIBUTE_CHANGEPRICE) {
                        $attributes = $this->getAttributesByKey($key);
                        if ($attributes && count($attributes)) {
                            foreach ($attributes as $attr) {
                                $product->price += (int)$attr['change_price'];
                            }
                        }
                    }
                }
                $this->ProductInfo[$set][$key] = $product;
            }
        }
        return $product;
    }

    /**
     * Get sum product follow product_id
     * @param int $product_id
     */
    function getSumProduct($product_id = 0)
    {
        $total = 0;
        $product_id = (int)$product_id;
        if ($product_id) {
//            $total = isset($this->sumProducts[$product_id]) ? $this->sumProducts[$product_id] : 0;
//            if (!$total) {
            foreach ($this->_products as $proInfo) {
                if ($proInfo['product_id'] == $product_id) {
                    $total += $proInfo['qty'];
                }
            }
//            }
        }
//        $this->sumProducts[$product_id] = $total;
        return $total;
    }

    public function findAllProducts()
    {
        $products = array();
        //Dont use set - default
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            foreach ($this->_products as $key => $proInfo) {
                // hungtm add if product configurable
                if (isset($proInfo['is_configurable']) && $proInfo['is_configurable']) {
                    $product = $this->findProductConfigurable($key);
                    if ($product) {
                        $products[$key] = $product;
                        $products[$key]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
                        $products[$key]['price_text'] = Product::getPriceText($product);
                        $products[$key]['inCartInfo'] = $proInfo;
                    }
                } else {
                    $product = $this->findProduct($key);
                    if ($product) {
                        $products[$key] = $product->attributes;
                        $products[$key]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
                        $products[$key]['price_text'] = Product::getPriceText($product->attributes);
                        $products[$key]['inCartInfo'] = $proInfo;
                    }
                }
            }
            return $products;
        } else { // User set Hatv
            foreach ($this->_products as $ary_key => $ary_products) {
                foreach ($ary_products as $product_key => $proInfo) {
                    // hungtm add if product configurable
                    if (isset($proInfo['is_configurable']) && $proInfo['is_configurable']) {
                        $product = $this->findProductConfigurable($product_key, $ary_key);
                        if ($product) {
                            $products[$ary_key][$product_key] = $product;
                            $products[$ary_key][$product_key]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
                        }
                    } else {
                        $product = $this->findProduct($product_key, $ary_key);
                        if ($product) {
                            $products[$ary_key][$product_key] = $product->attributes;
                            $products[$ary_key][$product_key]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
                        }
                    }
                }
            }
            return $products;
        }
    }

    public function findAllProductsInSet($set)
    {
        $products = array();
        //Dont use set - default
        if (count($this->_products[$set])) {
            foreach ($this->_products[$set] as $product_key => $proInfo) {
                // hungtm add if product configurable
                if (isset($proInfo['is_configurable']) && $proInfo['is_configurable']) {
                    $product = $this->findProductConfigurable($product_key, $set);
                    if ($product) {
                        $products[$product_key] = $product;
                        $products[$product_key]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
                    }
                } else {
                    $product = $this->findProduct($product_key, $set);
                    if ($product) {
                        $products[$product_key] = $product->attributes;
                        $products[$product_key]['link'] = Yii::app()->createUrl('economy/product/detail', array('id' => $product['id'], 'alias' => $product['alias']));
                    }
                }
            }
        }
        return $products;
    }

    /**
     * trả về số sản phẩm
     * @return type
     */
    public function countOnlyProducts($set = null)
    {
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            $total = count($this->_products);
            return $total;
        } else {
            $total = (count($this->_products[$set])) ? count($this->_products[$set]) : 0;
            return $total;
        }
    }

    /**
     * trả vể số lượng tất cả các sản phẩm tính cả số lượng của từng sản phẩm
     * @return type
     */
    public function countProducts()
    {
        $total = 0;
        foreach ($this->_products as $proInfo) {
            $total += $proInfo['qty'];
        }

        return $total;
    }

    /**
     * Trả về số lượng set
     * @return type
     */
    public function countSetProduct()
    {
        $total = count($this->_products);
        return $total;
    }

    /**
     * Trả về sản phẩm trong set
     * @return type
     */
    public function countProductInSet($set_key)
    {
        $total = 0;
        foreach ($this->_products[$set_key] as $proInfo) {
            $total += $proInfo['qty'];
        }
        return $total;
    }

    /**
     * Trả về tổng giá thanh của của tất cả sản phẩm trong giỏ hàng (Chưa tính giảm giá)
     * @param boolean $formatted
     * @return mixed
     */
    public function getTotalPrice($formatted = true)
    {

        $total = 0;
        foreach ($this->_products as $key => $proInfo) {
            $total += $this->getTotalPriceForProduct($key, false, $proInfo['is_configurable']);
        }

        if ($formatted)
            return Product::getPriceText(array('price' => $total, 'currency' => $this->getProductCurrency()));
        else
            return $total;
    }

    /**
     * trả về tổng giá thanh của của tất cả sản phẩm trong giỏ hàng
     * @param type $formatted
     * @return type
     */
    public function getSetTotalPrice($set, $formatted = true)
    {
        $total = 0;
        foreach ($this->_products[$set] as $key => $proInfo) {
            $total += $this->getTotalPriceForProduct($key, false, $proInfo['is_configurable'], $set);
        }

        if ($formatted)
            return Product::getPriceText(array('price' => $total, 'currency' => $this->getProductCurrency()));
        else
            return $total;
    }

    /**
     * trả về tổng điểm cộng của tất cả sản phẩm trong giỏ hàng
     * @param type $formatted
     * @return type
     */
    public function getTotalBonusPoint($formatted = false)
    {
        $total = 0;
        foreach ($this->_products as $key => $proInfo) {
            $total += $this->getTotalBonusPointForProduct($key, false);
        }
        if ($formatted)
            return Product::getPriceText(array('price' => $total, 'currency' => $this->getProductCurrency()));
        else
            return $total;
    }

    /**
     * trả về tổng điểm cộng của tất cả điểm từ thiện
     * @param type $formatted
     * @return type
     */
    public function getTotalDonate($formatted = false)
    {
        $total = 0;
        foreach ($this->_products as $key => $proInfo) {
            $total += $this->getTotalDonateForProduct($key, false);
        }
        if ($formatted)
            return Product::getPriceText(array('price' => $total, 'currency' => $this->getProductCurrency()));
        else
            return $total;
    }

    /**
     * Trả về tổng giá thanh của của tất cả sản phẩm trong giỏ hàng và phí vận chuyển
     * @param type $formatted
     * @return type
     */
    public function getTotalPriceWithTranportPrice($formatted = true, $tranport_method_id = 0)
    {
        $total = 0;
        foreach ($this->_products as $key => $proInfo) {
//            $total += $this->getTotalPriceForProduct($key, false);
            $total += $this->getTotalPriceDiscount();
        }
        if (isset($tranport_method_id) && $tranport_method_id != 0) {
            $tranportmethod = OrderTranports::getTransportMethodInfo($tranport_method_id);
        }

        if ($formatted) {
            return Product::getPriceText(array('price' => $total + $tranportmethod['price'], 'currency' => $this->getProductCurrency()));
        } else {
            return ($total + $tranportmethod['price']);
        }
    }

    /**
     * get transport fee
     * @param type $formatted
     * @param type $tranport_method_id
     * @return type
     */
    public function getTranportPrice($formatted = true, $tranport_method_id = 0)
    {
        $price = 0;
        if (isset($tranport_method_id) && $tranport_method_id != 0) {
            $tranportmethod = OrderTranports::getTransportMethodInfo($tranport_method_id);
            $price = $tranportmethod['price'];
        }
        if ($formatted) {
            return Product::getPriceText(array('price' => $price, 'currency' => $this->getProductCurrency()));
        } else {
            return $price;
        }
    }

    /**
     * return attributes
     * @param type $key
     * @return type
     */
    public function getAttributesByKey($key = '', $set = null)
    {
        if (!Yii::app()->siteinfo['use_shoppingcart_set']) {
            $cartInfo = $this->getInfoByKey($key);
            $attributes = isset($cartInfo[ClaShoppingCart::MORE_INFO]['attributes']) ? $cartInfo[ClaShoppingCart::MORE_INFO]['attributes'] : array();
        } else {
            $cartInfo = $this->getInfoByKey($key, $set);
            $attributes = isset($cartInfo[ClaShoppingCart::MORE_INFO]['attributes']) ? $cartInfo[ClaShoppingCart::MORE_INFO]['attributes'] : array();
        }
        return $attributes;
    }

    /**
     * return type attributes
     * @param type $key
     * @return type
     */
    public function getTypeAttByKey($key = '')
    {
        $cartInfo = $this->getInfoByKey($key);
        $type_attributes = isset($cartInfo[ClaShoppingCart::MORE_INFO]['type_attributes']) ? $cartInfo[ClaShoppingCart::MORE_INFO]['type_attributes'] : '';
        return $type_attributes;
    }

    /**
     *
     * @param type $attribute
     */
    public function getAttributeText($attribute = array())
    {
        $text = isset($attribute['value']) ? $attribute['value'] : '';
        if (isset($attribute['ext']) && $attribute['ext']) {
            switch ($attribute['type_option']) {
                case ProductAttribute::TYPE_OPTION_IMAGE:
                    $text = '<img class="attr-image" src="' . $attribute['ext'] . '" title="' . $text . '" />';
                    break;
                case ProductAttribute::TYPE_OPTION_COLOR:
                    $text = '<span class="attr-color" style="background-color:' . $attribute['ext'] . ';" title="' . $text . '"></span>';
                    break;
            }
        }
        if (isset($attribute['change_price'])) {
            $text = '<span class="attr-price" title="' . $text . '">' . $text . ' | ';
            if ($attribute['change_price'] > 0) {
                $text .= HtmlFormat::money_format((int)$attribute['change_price']) . ' đ</span>';
            }
        }

        return $text;
    }

    /**
     * Add diểm người dùng sử dụng vào trong hóa đơn
     * @hatv
     * @param type $code
     * @return boolean
     */
    public function addPointUsed($point_used)
    {
        $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
        if (isset($userinfo['bonus_point']) && $userinfo['bonus_point'] >= $point_used) {
            $this->point_used = $point_used;
            return true;
        }
        return false;
    }

    /**
     * Xóa diểm người dùng sử dụng vào trong hóa đơn
     * @hatv
     * @param type $code
     * @return boolean
     */
    public function deletePointUsed()
    {
        $this->point_used = 0;
        return true;
    }

    /**
     * Xóa diểm người dùng sử dụng vào trong hóa đơn
     * @hatv
     * @param type $code
     * @return boolean
     */
    public function deleteSetProduct()
    {
        $this->point_used = 0;
        return true;
    }

    /**
     * Lấy ra điểm người dùng sử dụng dùng trong hóa đơn
     * @hatv
     * @return type
     */
    public function getPointUsed()
    {
        if ($this->point_used != null && isset($this->point_used)) {
            $this->use_bonus_points = true;
            return $this->point_used;
        }
    }

    /**
     * Lấy ra điểm người dùng sử dụng dùng trong hóa đơn
     * @hatv
     * @return type
     */
    public function checkPointUsed()
    {
        $userinfo = ClaUser::getUserInfo(Yii::app()->user->id);
        $point_used = $this->getPointUsed();
        if (isset($userinfo['bonus_point']) && $userinfo['bonus_point'] < $point_used) {
            return false;
        }
        return true;
    }

    /**
     * Kiểm tra sử dụng điểm
     * @hatv
     * @return type
     */
    public function getUsedPoint()
    {
        if ($this->use_bonus_points != null && isset($this->use_bonus_points)) {
            return $this->use_bonus_points;
        }
    }

    /**
     * Lấy điểm per bonus
     * @hatv
     * @return type
     */
    public function getBonusConfig()
    {
        $config_bonus = BonusConfig::checkBonusConfig();
        if (isset($config_bonus)) {
            return $config_bonus;
        }
        return fasle;
    }

    /**
     * @hatv
     * Kiểm tra lại khi khách hàng thay đổi thông tin sau khi add mã
     */
    public function checkResetBonusPont()
    {
        $point_used = $this->getPointUsed();
        if (isset($point_used)) {
            //check point
            $config_bonus = BonusConfig::checkBonusConfig();
            $user_point = ClaUser::getUserInfo(Yii::app()->user->id)['bonus_point'];
            $shoppingCart = Yii::app()->customer->getShoppingCart();
            $toal_price = $shoppingCart->getTotalPrice(false);
            $min_point = $config_bonus->min_point;
            $max_point = $config_bonus->max_point;
            $min_order_price = $config_bonus->minimum_order_amount;
            if ($config_bonus && $point_used != 0) {
                if ($config_bonus->status == false) {
                    $this->addPointUsed(0);
                } else if ($point_used > $user_point) {
                    $this->addPointUsed(0);
                } else if ($point_used < $min_point && $min_point != 0) {
                    $this->addPointUsed(0);
                } else if ($point_used > $user_point && $max_point != 0) {
                    $this->addPointUsed(0);
                } else if ($toal_price < $min_order_price && $min_order_price != 0) {
                    $this->addPointUsed(0);
                }
            }
        }
    }

    function getProductCurrency()
    {
        return $this->productCurrency;
    }

    function setProductCurrency($productCurrency, $force = false)
    {
        if ($force || !$this->productCurrency) {
            $this->productCurrency = $productCurrency;
            return true;
        }
        return false;
    }

    /**
     * Add discount to shopping cart
     * @param double $percent
     */
    public function addDiscountPercent($percent)
    {
        $this->discountPercent = $percent;
    }

    /**
     * Add discount to shopping cart
     * @return double
     */
    public function getDiscountPercent()
    {
        return $this->discountPercent;
    }

}
