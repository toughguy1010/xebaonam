<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/5/2020
 * Time: 2:18 PM
 */

Class ClaInstallment
{
    const COUNT_PRE_DEFAULT = 0.3; //Trả trước mặc định 30%
    static function AllPrice()
    {
        return [
            'count_price_market' => 12000000,//Giá thị trường
            'count_price' => 10000000, //Giá niêm yết
            'count_pre' => 30 / 100, // Trả trước %
            'count_interest_home' => 2.27 / 100, //Lãi suất home credit %
            'count_interest_fe' => 3.3 / 100, // Lãi suất FE credit %
            'count_interest_saison' => 1.83 / 100, // Lãi suất saison %
            'count_insurrance' => 3 / 100, // Bảo hiểm khoản vay %
            'collection_fee' => 11000, //Phí thu hộ
        ];
    }

    static function getCompanyBank() {
        $bank = Installment::getAll();
        return $bank;
    }

    static function AllMonth()
    { //Config số tháng
        $string = '6,8,9,10,12,15,18';
        $arr = explode(',', $string);
        return $arr;
    }

    static function getDiscount($price_market, $price)
    { //
        $price_market = str_replace('.', '', $price_market);
        $price = str_replace('.', '', $price);
        return round(($price_market - $price) / ($price_market / 100));
    }

    static function getPapers($price)
    { //Hố sơ
        if ($price >= 10000000) {
            $papers = 'Chứng minh thư, sổ hộ khẩu';
        } else {
            $papers = 'Chứng minh thư, bằng lái';
        }
        return $papers;
    }
    static function getSex($sex)
    { //Hố sơ
        $result = 'Nam';
        if ($sex == 1) {
            $result = 'Nữ';
        }
        return $result;
    }

    static function getPrePrice($price = 0)
    { //Config danh sách trả trước
        if (isset($price) && $price) {
            return [
                0 => 'Trả trước: '.number_format(0, 0, ',', '.'). '₫ - 0%',
                '0.3' => 'Trả trước: '.number_format($price*0.3, 0, ',', '.'). '₫ - 30%',
                '0.4' => 'Trả trước: '.number_format($price*0.4, 0, ',', '.'). '₫ - 40%',
                '0.5' => 'Trả trước: '.number_format($price*0.5, 0, ',', '.'). '₫ - 50%',
                '0.6' => 'Trả trước: '.number_format($price*0.6, 0, ',', '.'). '₫ - 60%',
                '0.7' => 'Trả trước: '.number_format($price*0.7, 0, ',', '.'). '₫ - 70%',
            ];
        }
        return [
            0 => 0.3,
            1 => 0.4,
            2 => 0.5,
            3 => 0.6,
            4 => 0.7,
        ];
    }

    static function getEveryMonth($number_month, $count_pre, $count_price)
    { //Trả trước hàng tháng
        $every_month = (1 - $count_pre) * $count_price / $number_month;
        return $every_month;
    }

    static function getInsurrance($every_month, $count_insurrance)
    { //Bảo hiểm khoản vay
        $count_insurrance_price = $every_month * $count_insurrance;
        return $count_insurrance_price;
    }

    static function getInteresBank($every_month, $count_insurrance, $interes_bank,$collection_fee, $option = [])
    { //Tính trả góp theo ngân hàng
        $number_month = (isset($option['number_month'])&& $option['number_month']) ? $option['number_month'] : 0 ;
        $count_price = (isset($option['count_price']) && $option['count_price']) ? $option['count_price'] : 0 ;
        $count_pre = (isset($option['count_pre']) && $option['count_pre']) ? $option['count_pre'] : 0 ;
        $result = [];
        $count_insurrance_price = self::getInsurrance($every_month, $count_insurrance);
        $interes = (1 - $count_pre) * $count_price * (double)$interes_bank; // Lãi suất
        $every_month_bank = $interes + $collection_fee + $count_insurrance_price + $every_month;//Góp mỗi tháng
        $total = $every_month_bank * $number_month;
        $result['interes'] = $interes;
        $result['every_month'] = $every_month_bank;
        $result['total'] = $total;
        return $result;
    }

    static function getDifference($total, $count_price, $count_pre) {
      return $total - ($count_price - $count_price * $count_pre);
    }
}

?>