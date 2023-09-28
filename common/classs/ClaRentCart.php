<?php

class ClaRentCart extends BaseHelper
{

    const RENT_QUANTITY_KEY = 'w_qty';
    const RENT_KEY = 'fid';
    const AFFILIATE_SESSION_KEY = 'AFFILIATE_SESSION';

    protected $product = [];
    protected $quantity = 1;
    protected $vat = false;
    protected $insurance = false;
    protected $from_date = null;
    protected $to_date = null;
    protected $currency = 'VND';
    protected $insurance_fee = 0;
    protected $rent_category_id = false;
    protected $deposits_fee = 0;
    protected $vat_percent = 0;
    protected $ship_fee = 0;
    protected $return_fee = 0;

    public $discount = 0;
    public $return_address_id = 0;
    public $receive_address_id = 0;
    public $return_type = 0;
    public $receive_type = 0;
    public $receive_address_name = '';
    public $return_address_name = '';
    public $province_id = null;
    public $district_id = null;
    public $return_province_id = null;
    public $return_district_id = null;

    /**
     * Add product to shopping cart
     */
    public function updateRentCart($billingRent = [], $options = array())
    {
        if (isset($billingRent['rent_product_id'])) {
            $this->addProductById($billingRent['rent_product_id']);
        }

        if (isset($billingRent['from_date'])) {
            $this->addFromDate($billingRent['from_date']);
        }

        if (isset($billingRent['to_date'])) {
            $this->addToDate($billingRent['to_date']);
        }

        if (isset($billingRent['quantity'])) {
            $this->addQuantity($billingRent['quantity']);
        }

        if (isset($billingRent['vat'])) {
            $this->addVat($billingRent['vat']);
        }

        if (isset($billingRent['insurance'])) {
            $this->addInsurance($billingRent['insurance']);
        }
        if (isset($billingRent['rent_category_id'])) {
            $this->addRentCategoryId($billingRent['rent_category_id']);
        }

        if (isset($billingRent['receive_address_id'])) {
            $this->addReceiveType($billingRent['receive_address_id']);
            if ($this->receive_type == 4) {
                $this->province_id = $billingRent['province_id'];
                $this->district_id = $billingRent['district_id'];
            }
            if ($billingRent['receive_address_id'] == 4 && $billingRent['receive_address_name']) {
                $this->addReceiveAddressName($billingRent['receive_address_name']);
            } else {
                $this->addReceiveAddressName(BillingRentCart::aryAddress()[$billingRent['receive_address_id']]);
            }
            $this->addShipfee();
        }

        if (isset($billingRent['return_address_id'])) {
            $this->addReturnType($billingRent['return_address_id']);

            if ($this->return_type == 4) {
                $this->return_province_id = $billingRent['return_province_id'];
                $this->return_district_id = $billingRent['return_district_id'];
            }

            if ($billingRent['return_address_id'] == 4 && $billingRent['return_address_name']) {
                $this->addReturnAddressName($billingRent['return_address_name']);
            } else {
                $this->addReturnAddressName(BillingRentCart::aryAddress()[$billingRent['return_address_id']]);
            }
            $this->addReturnfee();
        }

    }

    public function addQuantity($attributes = [], $options = array())
    {
        $this->quantity = $attributes;
        return true;
    }
    public function addRentCategoryId($attributes = [], $options = array())
    {
        $this->rent_category_id = $attributes;
        return true;
    }

    public function addProduct($attributes = [], $options = array())
    {

        $this->product = $attributes;
        if (!$this->quantity) {
            $this->quantity = 1;
        }
        return true;
    }

    public function addProductById($rent_product_id, $options = array())
    {
        $product = RentProduct::model()->findByPk($rent_product_id);
        $product1 = RentProductPrice::getPriceByProductId($rent_product_id, $this->rent_category_id);
        foreach ($product1 as $pr) {
            $product['insurance_fee'] = $pr['insurance_fee'];
            $product['price'] = $pr['price'];
            $product['price_market'] = $pr['price_market'];
            $product['deposits'] = $pr['deposits'];
        }
        if ($product && $product->site_id == Yii::app()->controller->site_id) {
            $this->product = $product->attributes;
        }
        return true;
    }

    public function addFromDate($from_date, $options = array())
    {
        $this->from_date = $from_date;
        return true;
    }

    public function addToDate($to_date, $options = array())
    {
        $this->to_date = $to_date;
        return true;
    }

    public function addVat($vat = false, $options = array())
    {
        if ($vat) {
            $this->vat = true;
            $this->vat_percent = 0;
        } else {
            $this->vat = false;
            $this->vat_percent = 0;
        }
        return true;
    }

    public function addShipfee()
    {
        $shipfee = 0;
        if ($this->receive_type == 4) {
            $pid = $this->province_id;
            $did = $this->district_id;
            if ($pid || $did) {
                $data_shipfee = SiteConfigShipfee::getAllConfigShipfee();
                $data_compare = array();
                foreach ($data_shipfee as $shipfee_item) {
                    $key = $shipfee_item['province_id'] . $shipfee_item['district_id'];
                    $data_compare[$key] = $shipfee_item;
                }
                $key_compare1 = $pid . $did;
                $key_compare2 = $pid . 'all';
                $key_compare3 = 'allall';
                if (isset($data_compare[$key_compare1]) && !empty($data_compare[$key_compare1])) {
                    $shipfee += $data_compare[$key_compare1]['price'];
                } else if (isset($data_compare[$key_compare2]) && !empty($data_compare[$key_compare2])) {
                    $shipfee += $data_compare[$key_compare2]['price'];
                } else if (isset($data_compare[$key_compare3]) && !empty($data_compare[$key_compare3])) {
                    $shipfee += $data_compare[$key_compare3]['price'];
                }
            }
        }
        $this->ship_fee = $shipfee;
    }

    public function addReturnfee()
    {
        $shipfee = 0;
        if ($this->return_type == 4) {
            $pid = $this->return_province_id;
            $did = $this->return_district_id;
            if ($pid || $did) {
                $data_shipfee = SiteConfigShipfee::getAllConfigShipfee();
                $data_compare = array();
                foreach ($data_shipfee as $shipfee_item) {
                    $key = $shipfee_item['province_id'] . $shipfee_item['district_id'];
                    $data_compare[$key] = $shipfee_item;
                }
                $key_compare1 = $pid . $did;
                $key_compare2 = $pid . 'all';
                $key_compare3 = 'allall';
                if (isset($data_compare[$key_compare1]) && !empty($data_compare[$key_compare1])) {
                    $shipfee += $data_compare[$key_compare1]['price'];
                } else if (isset($data_compare[$key_compare2]) && !empty($data_compare[$key_compare2])) {
                    $shipfee += $data_compare[$key_compare2]['price'];
                } else if (isset($data_compare[$key_compare3]) && !empty($data_compare[$key_compare3])) {
                    $shipfee += $data_compare[$key_compare3]['price'];
                }
            }
        }
        $this->return_fee = $shipfee;
    }

    public function addReceiveType($type = false, $options = array())
    {
        $this->receive_type = $type;
        return true;
    }

    public function addReturnType($type = false, $options = array())
    {
        $this->return_type = $type;
        return true;
    }

    public function addReceiveAddressName($name = false, $options = array())
    {
        $this->receive_address_name = $name;
        return true;
    }

    public function addReturnAddressName($name = false, $options = array())
    {
        $this->return_address_name = $name;
        return true;
    }

    /**
     * Add product to shopping cart
     */
    public function addInsurance($insurance, $options = array())
    {
        if ($insurance && $this->product && $this->quantity > 0) {
            $this->insurance = true;
            $this->insurance_fee = $this->quantity * $this->getDateRange() * $this->product['insurance_fee'];
        } else {
            $this->insurance = false;
            $this->insurance = 0;
        }
        return true;
    }

    /**
     * Remove product in shopping cart
     * @param int $key
     * @param int $set
     */
    public function remove($key)
    {
        if (isset($this->product))
            unset($this->product);
    }

    /**
     * Count word of file
     * @param int $key
     * @param int $set
     */
    public function getQuantity()
    {
        if (isset($this->quantity)) {
            return $this->quantity;
        }
        return null;
    }


    public function getShipfee()
    {
        if (isset($this->ship_fee)) {
            return $this->ship_fee;
        }
        return null;
    }
    public function getCategoryId()
    {
        if (isset($this->rent_category_id)) {
            return $this->rent_category_id;
        }
        return null;
    }

    public function getReturnfee()
    {
        if (isset($this->return_fee)) {
            return $this->return_fee;
        }
        return null;
    }

    /**
     * Vat Status
     * @param int $key
     * @param int $set
     */
    public function getVatStatus()
    {
        return $this->vat;
    }

    /**
     * get Insurance Status
     * @param int $key
     * @param int $set
     */
    public function getInsuranceStatus()
    {
        return $this->insurance;
    }

    public function getInsuranceFee()
    {
        if ($this->insurance) {
            return $this->insurance_fee;
        } else {
            return 0;
        }
    }

    public function getDepositsFee()
    {
        if (isset($this->quantity) && $this->quantity) {
            $this->deposits_fee = $this->getProductInfo()['deposits'] * $this->quantity;
            return $this->deposits_fee;
        }
        return null;
    }

    public function getVatFee()
    {
        if (isset($this->quantity) && $this->quantity && $this->vat) {
            return $this->getProductPrice() * $this->vat_percent / 100;
        }
        return null;
    }

    public function getDateFrom($isUnixTime = false)
    {
        if (isset($this->from_date)) {
            if ($isUnixTime) {
                $date_from = DateTime::createFromFormat('d/m/Y', $this->from_date);
                return $date_from->getTimestamp();
            } else {
                return $this->from_date;

            }
        }
        return null;
    }

    public function getDateTo($isUnixTime = false)
    {
        if (isset($this->to_date)) {
            if ($isUnixTime) {
                $date_from = DateTime::createFromFormat('d/m/Y', $this->to_date);
                return $date_from->getTimestamp();
            } else {
                return $this->to_date;

            }
        }
        return null;
    }
    public function getDateRange()
    {
        if (isset($this->to_date) && isset($this->from_date)) {
            $compareValue = DateTime::createFromFormat('d/m/Y', $this->to_date);
            $validateValue = DateTime::createFromFormat('d/m/Y', $this->from_date);
            $interval = $validateValue->diff($compareValue);
            $range = $interval->days + 1;
            if ($range <= 0) {
                return 1;
            }
            return $range;
        }
        return null;
    }

    /**
     * Get product info in shopping cart by key
     * @editor: Hatv
     * */
    public function getProductInfo()
    {
        $info = isset($this->product) ? $this->product : null;
        $product = RentProductPrice::getPriceByProductId($info['id'], $this->rent_category_id);
        foreach ($product as $pr){
            $info['rent_category_id'] = $this->rent_category_id;
            $info['insurance_fee'] = $pr['insurance_fee'];
            $info['price'] = $pr['price'];
            $info['price_market'] = $pr['price_market'];
            $info['deposits'] = $pr['deposits'];
        }
        return $info;
    }

    /**
     * Trả về giá cuối cùng
     * @param boolean $formatted
     * @return mixed
     */
    public function getTotalPrice()
    {
        $total = 0;
        if ($this->quantity && $this->product) {
            $total = floatval($this->getProductPrice()) - $this->discount;
            if ($this->vat) {
                $total += floatval($this->getVatFee());
            }
            if ($this->insurance) {
                $total += floatval($this->getInsuranceFee());
            }
            $total += floatval($this->getShipfee());

            $total += floatval($this->getReturnfee());

            $total += floatval($this->getDepositsFee());
        }
        return $total;
    }

    /**
     * Trả về tổng giá thanh của của phẩm trong giỏ hàng (Chưa tính giảm giá)
     * @param boolean $formatted
     * @return mixed
     */
    public function getProductPrice($options = array())
    {
        $total = 0;
        if (count($this->product)) {
            if (Yii::app()->siteinfo['sim_store'] == 1) {
                $total = $this->getProductInfo()['price'] * $this->quantity;
            }
            else {
                $total = $this->getProductInfo()['price'] * $this->quantity * $this::getDateRange();
            }
        }
        return $total;
    }

    /**
     * Trả về tổng giá thanh của của tất cả sản phẩm trong giỏ hàng (Chưa tính giảm giá)
     * @param boolean $formatted
     * @return mixed
     */
    public function getItems()
    {
        return $this->product;
    }

    function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    function getCurrency()
    {
        return $this->currency;
    }
}
