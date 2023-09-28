<?php

/**
 * PJuiAutoComplete class file.
 *
 * @author phongphamhong <phongbro1805@gmail.com>
 * extended from CJuiAutoComplete
 */
Yii::import('zii.widgets.jui.CJuiAutoComplete');
class PJuiAutoComplete extends CJuiAutoComplete {

    /**
     * param defautl config
     */
    public $paramDefaultConfig = array(
        'delay' => 400,
        'minLength' => 2,
        'autoFocus' => true,
        'showAnim' => 'fold'
    );

    /**
     * Run this widget.
     * This method registers necessary javascript and renders the needed HTML code.
     */
    public function run() {
        $option = $this->options;
        foreach ($this->paramDefaultConfig as $key => $item) {
            if (!isset($option[$key])) {
                $option[$key] = $item;
            }
        }
        $this->options = $option;
        return parent::run();
    }

}
