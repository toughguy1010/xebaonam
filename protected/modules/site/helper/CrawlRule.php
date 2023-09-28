<?php

/**
 * Description of CrawRule
 *
 * @author MinhBN
 */
class CrawlRule {

    protected $rules = array(); // rules

    function getRules() {
        return $this->rules;
    }

    function setRules($rules) {
        $this->rules = $rules;
    }

    function __construct($options = array()) {
        if (isset($options['rules'])) {
            $this->rules = $options['rules'];
        }
    }

    /**
     * return phimmoi.net rules
     * 
     * @return type
     */
    function getHungtuyRules() {
        // level 0 bắt đầu từ category // http://www.phimmoi.net/the-loai/phim-tam-ly/
        return array(
            // level 0
            0 => array(
                'getLinks' => array(
                    '.main-content31 .shop-products .item-col .vg-item .text-block .item-title a',
                ),
                'getContents' => array(
                    0 => array(
                        'rule' => '.main-content31 .shop-products .item-col .vg-item .text-block .item-meta', // Mã sp
                        'get' => 'innertext',
                    ),
                ),
            ),
                // level 1 link detail
            1 => array(
                'getLinks' => array(),
                'getContents' => array(
                    0 => array(
                        'rule' => '.product-view .summary .vg-title h1', // Tên sản phẩm
                    ),
                    1 => array(
                        'rule' => '.product-view .summary .entry-meta', // Mã sản phẩm
                        'match' => '/^Mã số:/i',
                        'subrule' => 'p',
                        'getText' => 'plaintext', // plaintext, innertext
                        'get' => 'substring',
                        'start' => 'Mã số:',
                        'end' => '',
                    ),
                    2 => array(
                        'rule' => '.product-view .summary .entry-meta', // Nơi san xuat
                        'match' => '/^Nơi sản xuất:/i',
                        'subrule' => 'p',
                        'getText' => 'plaintext', // plaintext, innertext
                        'get' => 'substring',
                        'start' => 'Nơi sản xuất:',
                        'end' => '',
                    ),
                    3 => array(
                        'rule' => '.product-view .summary .entry-meta', // Hang san xuat
                        'match' => '/^Hãng sản xuất:/i',
                        'subrule' => 'p',
                        'getText' => 'plaintext', // plaintext, innertext
                        'get' => 'substring',
                        'start' => 'Hãng sản xuất:',
                        'end' => '',
                    ),
                    4 => array(
                        'rule' => '.entry-content-full .entry-content', // Mô tả dài
                        'get' => 'innertext',
                    ),
                    5 => array(
                        'rule' => '.product-view .summary .entry-meta > p', // Mô tả ngắn
                        'match' => '/^Mô tả:/i',
                        'traverse' => 'next'
                    ),
                    6 => array(
                        'rule' => '.product-view .images .woocommerce-main-image > img', // Avatar
                        'get' => 'attribute',
                        'attribute' => 'src'
                    ),
                    7 => array(
                        'rule' => '.product-view .thumbnails img', // Anh khac
                        'get' => 'attribute',
                        'attribute' => 'src'
                    ),
                    8 => array(
                        'rule' => '.main-container .woocommerce-breadcrumb a', // Breadcrum
                    ),
                ),
            ),
        );
    }

}
