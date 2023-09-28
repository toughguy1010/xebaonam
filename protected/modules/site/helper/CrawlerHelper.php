<?php

/**
 * Created by minhbn
 * Date: 08/20/2013
 * Category: 
 */
class CrawlerHelper extends BaseHelper {

    protected $rootLink = ''; // root link
    protected $ruleObject = array(); // ruleObject Class for get rules
    protected $data = array(); // Lưu dữ liệu sau khi crawl xong
    protected $baseUrl; // domain of link
    public $links = array();
    public $parents = array();
    protected $requestDelayTime = 0;
    protected $requestUseProxy = false;

    function getRootLink() {
        return $this->rootLink;
    }

    function getRuleObject() {
        return $this->ruleObject;
    }

    function setRootLink($rootLink) {
        $this->rootLink = $rootLink;
    }

    function setRuleObject($ruleObject) {
        $this->ruleObject = $ruleObject;
    }

    function getRules() {
        return $this->ruleObject->getRules();
    }

    function setRules($rules = array()) {
        $this->ruleObject->setRules($rules);
    }

    function getData() {
        return $this->data;
    }

    function getBaseUrl() {
        return $this->baseUrl;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setBaseUrl($baseUrl) {
        $this->baseUrl = $baseUrl;
    }

    public function __construct($options = array()) {
        if (isset($options['rootLink'])) {
            $this->rootLink = $options['rootLink'];
            //
            $host = parse_url($this->getRootLink());
            $baseurl = (isset($host ['scheme']) ? $host ['scheme'] . '://' : '') . (isset($host ['host']) ? $host ['host'] : '');
            $this->setBaseUrl($baseurl);
        }
        if (isset($options['ruleObject'])) {
            $this->ruleObject = $options['ruleObject'];
        } else {
            $this->ruleObject = new CrawlRule();
        }
    }

    /**
     * get dom html of root link
     * 
     * @return boolean
     */
    public function getDom($link = '') {
        $url = ($link) ? $link : $this->getRootLink();
        if (!$url) {
            return false;
        }
        //
        $curl = new CrawlCurl(array('method' => 'get', 'delay' => $this->getRequestDelayTime(), 'useProxy' => $this->getRequestUseProxy()));
        $html = $curl->sendRequest($url);
        if (!$html) {
            return false;
        }
        $simplehtmldom = new SimpleHtmlDom();
        $dom = $simplehtmldom->str_get_html($html);
        if ($dom) {
            return $dom;
        }
        return false;
    }

    // Lấy nội dung trang web với độ sâu depth
    public function crawler($link = '', $idx = 0, $options = array()) {
        $start = microtime(true);
        // Bắt đầu từ root, position: 0
        $depth = isset($options['depth']) ? (int) $options['depth'] : 0;
        $linkLimit = isset($options['limit']) ? (int) $options['limit'] : 0; // limit get links in a page
        $linkFrom = isset($options['from']) ? (int) $options['from'] : 1; // limit get links in a page
        $rules = $this->getRules();
        if (!$rules) {
            return array();
        }
        $data = array();
        if ($link) {
            if ($idx <= $depth) {
                $link = $this->createAbsoluteUrl($link);
                $dom = $this->getDom($link);
                if (!$dom) {
                    return $data;
                }
                // Nếu link sub chưa có rules để lấy content thì lấy rule content tổng quát của cha làm rule content
                $getContentsRules = isset($rules[$idx]['getContents']) ? $rules[$idx]['getContents'] : array();
                //
                $data['link'] = $link;
                $data['level'] = $idx;
                $data['content'] = array();
                if ($getContentsRules && is_array($getContentsRules)) {
                    // Lấy content
                    foreach ($getContentsRules as $linkposition => $rule) {
                        $data['content'][$linkposition] = $this->getContent(array(
                            'dom' => $dom,
                            'rule' => $rule,
                        ));
                    }
                }
                // Lấy link
                //
                if (!isset($rules[$idx]['getLinks'])) {
                    $rules[$idx]['getLinks'] = array();
                }
                if ($rules[$idx]['getLinks']) {
                    $getLinkRules = $rules[$idx]['getLinks'];
                    if (isset($rules[$idx]['limit'])) {
                        $linkLimit = (int) $rules[$idx]['limit'];
                    }
                    if (isset($rules[$idx]['from'])) {
                        $linkFrom = (int) $rules[$idx]['from'];
                    }
                    if ($idx > 0) {
                        $linkFrom = 1;
                    }
                    $linkCount = 1;
                    //$commonIndex = isset($rules[$idx]['index']) ? $rules[$idx]['index'] : null;
                    foreach ($getLinkRules as $rule) {
                        $domItemsLink = $dom->find($rule);
                        foreach ($domItemsLink as $linkitem) {
                            if ($linkCount > ($linkLimit + $linkFrom - 1)) {
                                break;
                            }
                            if ($linkCount < $linkFrom) {
                                $linkCount++;
                                continue;
                            }
                            if (isset($linkitem->href)) {
                                $data['links'][$this->createAbsoluteUrl($linkitem->href)] = $this->crawler($linkitem->href, $idx + 1, $options);
                            } elseif (isset($linkitem->src)) {
                                $data['links'][$this->createAbsoluteUrl($linkitem->src)] = $this->crawler($linkitem->src, $idx + 1, $options);
                            }
                            $linkCount++;
                        }
                    }
                }
                //
                $idx++;
                $dom = null;
                unset($dom);
            }
            $results = $data;
        }
        //
        $end = microtime(true);
        $this->setData(array($this->getRootLink() => $results));
        return $results;
    }

    function getContent($options = array()) {
        $results = array();
        $dom = isset($options['dom']) ? $options['dom'] : null;
        if (!$dom) {
            return $results;
        }
        $rule = isset($options['rule']) ? $options['rule'] : '';
        if (!$rule) {
            return $results;
        }
        //
        $proccessAll = true;
        $ruleString = '';
        $subRuleString = ''; // sub rules
        $index = null;
        $get = 'plaintext';
        $attribute = '';
        $match = '';
        $traverse = null; // Biến con trỏ để xác định lấy ở đối tượng tìm thấy hoặc lấy ở đối tượng kề bên....
        if (is_string($rule)) {
            $ruleString = $rule;
        } else {
            $ruleString = isset($rule['rule']) ? $rule['rule'] : $ruleString;
            $get = isset($rule['get']) ? $rule['get'] : $get;
            $index = isset($rule['index']) ? $rule['index'] : $index;
            $subRuleString = isset($rule['subrule']) ? $rule['subrule'] : $subRuleString;
            $match = isset($rule['match']) ? $rule['match'] : $match;
            $attribute = isset($rule['attribute']) ? $rule['attribute'] : $attribute;
            $proccessAll = ($index !== null || $match) ? false : $proccessAll;
            $traverse = isset($rule['traverse']) ? $rule['traverse'] : $traverse;
        }
        $items = array();
        if (!$proccessAll && !$match) {
            $items[] = $dom->find($ruleString, $index);
        } elseif (!$proccessAll && $match) {
            $domItems = $dom->find($ruleString);
            foreach ($domItems as $matchItem) {
                $text = $matchItem->plaintext;
                if ($text) {
                    $text = trim($text);
                }
                if ($text && preg_match($match, $text)) {
                    $items[] = $matchItem;
                    //echo $text.'<br></br>';
                }
            }
        } else {
            $items = $dom->find($ruleString);
        }
        //
        foreach ($items as $item) {
            if ($traverse) {
                switch ($traverse) {
                    case 'next': {
                            $item = $item->next_sibling();
                        }break;
                    case 'prev': {
                            $item = $item->prev_sibling();
                        }break;
                }
            }
            if (!$item) {
                continue;
            }
            //
            if ($subRuleString) {
                $domSubItem = $item->find($subRuleString);
                foreach ($domSubItem as $titleitem) {
                    switch ($get) {
                        case 'attribute': {
                                if ($attribute) {
                                    $results [] = $titleitem->{$attribute};
                                } else {
                                    continue;
                                }
                            }break;
                        case 'substring': {
                                $start = isset($rule['start']) ? $rule['start'] : '';
                                $end = isset($rule['end']) ? $rule['end'] : '';
                                $getText = isset($rule['getText']) ? $rule['getText'] : 'innertext';
                                $innertext = $titleitem->{$getText};
                                $results[] = $this->fetchValue($innertext, $start, $end);
                            }break;
                        case 'regex': {
                                $regex = isset($rule['regex']) ? $rule['regex'] : '';
                                if ($regex) {
                                    $getText = isset($rule['getText']) ? $rule['getText'] : 'innertext';
                                    $innertext = $titleitem->{$getText};
                                    preg_match($regex, $innertext, $results);
                                }
                            }break;
                        default: {
                                $results [] = $titleitem->{$get};
                            }break;
                    }
                }
                //
            } else {
                switch ($get) {
                    case 'attribute': {
                            if ($attribute) {
                                $results [] = $item->{$attribute};
                            } else {
                                continue;
                            }
                        }break;
                    case 'substring': {
                            $start = isset($rule['start']) ? $rule['start'] : '';
                            $end = isset($rule['end']) ? $rule['end'] : '';
                            $innertext = $item->innertext;
                            $results[] = $this->fetchValue($innertext, $start, $end);
                        }break;
                    case 'regex': {
                            $regex = isset($rule['regex']) ? $rule['regex'] : '';
                            if ($regex) {
                                $getText = isset($rule['getText']) ? $rule['getText'] : 'innertext';
                                $innertext = $item->{$getText};
                                preg_match($regex, $innertext, $results);
                            }
                        }break;
                    default: {
                            $results [] = $item->{$get};
                        }break;
                }
            }
            //
        }

        return $results;
    }

    /**
     * return data follow level
     * @param type $level
     */
    function getCrawlData($level = 0, $data = null) {
        if ($data === null) {
            $data = $this->getData();
        }
        $count = 0;
        while ($count + 1 <= $level && $data) {
            $dbTemple = array();
            foreach ($data as $li => $da) {
                $links = isset($da['links']) ? $da['links'] : array();
                foreach ($links as $link => $info) {
                    $dbTemple[$link] = $info;
                }
            }
            $data = $dbTemple;
            $count++;
        }
        return $data;
    }

    /**
     * is full url
     * 
     * @param type $url
     * @return boolean
     */
    public function isFullUrl($url = '') {
        if (!$url) {
            return false;
        }
        $host = parse_url($url);
        if (isset($host ['host'])) {
            return true;
        }
        return false;
    }

    /**
     * 
     * @param type $url
     * @param type $baseUrl
     * @return type
     */
    public function createAbsoluteUrl($url = '', $baseUrl = '') {
        if (!$url) {
            return $baseUrl;
        }
        if ($this->isFullUrl($url)) {
            return $url;
        }
        if (!$baseUrl) {
            $baseUrl = $this->getBaseUrl();
        }
        $first = substr($url, 0, 1);
        return $baseUrl . (($first == '/') ? '' : '/') . $url;
    }

    /**
     * 
     * @param type $str
     * @param type $find_start
     * @param type $find_end
     * @return string
     */
    function fetchValue($str, $find_start, $find_end) {
        $start = mb_stripos($str, $find_start);
        if ($start === false)
            return '';
        $length = mb_strlen($find_start);
        if ($find_end == '') {
            $end = mb_strlen($str);
        } else {
            $end = mb_stripos(mb_substr($str, $start + $length), $find_end);
        }
        return trim(mb_substr($str, $start + $length, $end));
    }

    function getRequestDelayTime() {
        return $this->requestDelayTime;
    }

    function getRequestUseProxy() {
        return $this->requestUseProxy;
    }

    function setRequestDelayTime($requestDelayTime) {
        $this->requestDelayTime = $requestDelayTime;
    }

    function setRequestUseProxy($requestUseProxy) {
        $this->requestUseProxy = $requestUseProxy;
    }

}
