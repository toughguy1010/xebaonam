<?php

/**
 * change language for site
 */
class languages extends WWidget {

    public $languages = array();
    protected $name = 'languages';
    protected $view = 'view';
    protected $actionKey = ''; // lưu tham số url hiện tại

    public function init() {
        if (!ClaSite::isMultiLanguage()){
            return false;
        }
        // set name for widget, default is class name
        if ($this->name == '') {
            $this->name = get_class($this);
        }
        //
        $flags = array(
            'vi' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAK4SURBVHja7Jc9axRRFIafMzM7k5jEjUERO0XRKgTE1tbGwir4DxTBXqwsBHut9BdYiD/AThDEQlSiYiWIjQQx0f2YvbP341jMrtldd8lsM2lyYLiwc3fOc+6877l3RFU5yIg44DgEECAGssFYZ3igSICjPzY3d4hrzi/CqadP1xKgSRSxePlyrfn7X74ANBMg0xDQoiC0WjC0pUg5TtpUZHzONBtP/ndiXtRsgrUAWQKAc6gxqDG1VK/GoCUAJYD3hF6P0OvNZ6FlQCF05yRoNAijAOocmufonADJeQ8xFO/mE7AmCTg3AuA92m6j3flKydYL1AjmVTofAKD9/sgrsBbf6aB5Xt1FDUjPdkFA3RJazAGgCkUxAuAcodOZKUJJFckGrUPLq3E6EB3LwUN6NmA+RuU9AUkhtGU2fAgwugJqLXQ66IBq0mpRoixccqzeMEisqAeJBVxptbU7OdoXpKFoX/j9JKP7ojGt9PLZzqGTGqDb/WeNyXA5dJ5B8RbW7hnSMwHCYDWGVWXQ/xqxc/8I9psF7Ox3YC1E0bgGXJ4Pm8Ps5v0eflxXjt81LF0r9gAEOs8zfj1YRH2rkg3jlZU9gOAceA8h7C+gHtjvCjI+122D2lBNhd6XOYfbsTpXCqPKJYGlqwUQ6L2O6b2Jyt+umBKqwjMkhPFO6J0jUa20Aum6p3HOsvtwkT+PMwBWbxtWbxnSC5b+p7iKD8c7YXAOVUUrACxsWLZvLpK/bFAqEXYfpRSfheyipdiSSgB+1AXBOUiS6TvbxPGl2BLMh//n9l4mZBuutMZ+51yRCYBh5fsBKJi3MdMyqJ19b1oMc0YAPoS9Pbym09AYQFBFagSQEYCyEw5WIFperg1iFMAHYLfVos4YKMULcBJYB07UfCz/CXyUwTfBymCsMwqgLYcfpwcN8HcAxaOgKWN6t2cAAAAASUVORK5CYII=',
            'en' => 'data:image/png;base64,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',
            'jp' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAABSlBMVEX///8AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADYAwPZBATaAQbaCAvbAQzbAQ3bAw3bAw/bBg7bCAvcBBHcBhHcBhPcCBXcCxHcCxXcERjdCxXdCxfeHCLeHyXfHCbfHCffJyngJyvgJzHgJzLgJzPhPj7iKzbiMzniMzviMz3iMz7jS0vkOkPkPkfkPkjlS1HlS1LlS1PmVljmVlnnVlrnVlvoWWLpaWzqbXPqbnPqdHjrdHrsdn3tgont7e3u7u7v7+/w8PDxnaLyqq3y8vLzqKzzqazzq7D0sbT09PT1srb1ubv1vcH19fX29vb3xMf3xcf3xsr3ycz39/f4y834zM/51Nf51tj5+fn74uT75eb75uf7+/v86On86uv87Oz98fH9/f3+9vf++Pj++vv+/Pz+/v7//v7///8na8hLAAAADnRSTlMAAwcKDREUFxsgJCdEWan4JYAAAAEESURBVHgBYxgMgJGZBQ9gZmRgzcULWBk48SvgZODGr4CbRAU5KeGhSVm4FcTZW1hamdtE41IQZmBiBgSmBt7YFSRoGRlDgFYkNgU51jr6evp6evr6erqGmVgUJKtpqqtramoAoaZqFBYF/ooqcKDshEWBl4wCHMg7IinIhjLjxaXhQDAQKpgNVJAGc6S2mBQUSMpmQAXTgAoSYabF8EtAAb8PTCwRqCAW7md3PhFRIBDhs4MLxQIVRCCCLURJQEhYQM4DIRIMVBCEFPLpAQ62vqlIAn5ABZ74YtsTqMANnwI3oAJXfApcuBm4nF3wAGcuBnYeXjyAh52BiY0DD2BjokPWBABNuvHXj+2/7wAAAABJRU5ErkJggg==',
        );
        //
        $module = isset(Yii::app()->controller->module->id) ? Yii::app()->controller->module->id . '/' : '';
        $controller = isset(Yii::app()->controller->id) ? Yii::app()->controller->id . '/' : '';
        $action = (isset(Yii::app()->controller->action->id) && Yii::app()->controller->action->id) ? Yii::app()->controller->action->id : '';
        $curentUrl = $module . $controller . $action;
        if ($curentUrl == Yii::app()->defaultController) {
            $curentUrl = '/';
        }
        //
        $this->actionKey = base64_encode(json_encode(array('url' => $curentUrl, 'params' => $_GET)));
        //
        $languages = ClaSite::getLanguagesForSite();
        unset($languages['vi']);
        $languages = ClaArray::AddArrayToBegin($languages, array('vi' => 'vi'));
        $currentLanguage = Yii::app()->language;
        //
        foreach ($languages as $language) {
            $this->languages[$language]['name'] = $language;
            $this->languages[$language]['key'] = $language;
            $this->languages[$language]['image'] = $flags[$language];
            $this->languages[$language]['link'] = Yii::app()->createUrl('/setting/setting/setlanguage', array(ClaSite::LANGUAGE_KEY => $language, ClaSite::LANGUAGE_ACTION_KEY => $this->actionKey));
            $this->languages[$language]['active'] = ($language == $currentLanguage) ? true : false;
        }
        //
        parent::init();
    }

    public function run() {
        $this->render($this->view, array(
            'languages' => $this->languages,
        ));
    }

}
