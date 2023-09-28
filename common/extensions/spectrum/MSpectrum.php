<?php

/**
 * MSpectrum generates a color picker.
 *
 * The color picker widget is implemented based this jQuery plugin:
 * (see {@link http://bgrins.github.io/spectrum/}).
 *
 * This widget is more useful as a textfield (the default mode)
 *
 * @author Minhbn
 * @package application.extensions.spectrum
 * @since 1.0
 */
class MSpectrum extends CInputWidget {

    //***************************************************************************
    // Properties
    //***************************************************************************
    /**
     *
     * @var type array
     * spectrum options
     */
    public $options = array();

    /**
     * language
     * @var type 
     */
    public $language = 'vi';

    /**
     * set value for the starting color.
     *
     * @param string $value
     */
    public function setValue($value) {
        $this->value = $value;
    }

    /**
     *
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    //***************************************************************************
    // Paint the widget
    //***************************************************************************

    public function run() {
        list($name, $id) = $this->resolveNameID();
        list($name, $id) = $this->resolveNameID();
        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $id;
        }
        if (isset($this->htmlOptions['name'])) {
            $name = $this->htmlOptions['name'];
        }
        if ($this->hasModel()) {
            $attribute = $this->attribute;
            echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
            $this->setValue($this->model->$attribute);
        } else {
            echo CHtml::textField($name, $this->value, $this->htmlOptions);
        }
        //
        $this->setOptionsDefault();
        //
        $this->registerScript();
    }

    /**
     * load default options
     */
    function setOptionsDefault() {
        //
        if (!isset($this->options['color']))
            $this->options['color'] = ($this->value) ? $this->value : '#000';
        //
        //
        if (!isset($this->options['preferredFormat']))
            $this->options['preferredFormat'] = 'hex';
        //
        //
        if (!isset($this->options['showInput']))
            $this->options['showInput'] = true;
        //
        //
        if (!isset($this->options['showPalette']))
            $this->options['showPalette'] = true;
        //
        //
        if (!isset($this->options['showPaletteOnly']))
            $this->options['showPaletteOnly'] = false;
        //
        //
        if (!isset($this->options['togglePaletteOnly']))
            $this->options['togglePaletteOnly'] = false;
        //
        if (!isset($this->options['togglePaletteMoreText']))
            $this->options['togglePaletteMoreText'] = 'more';
        //
        if (!isset($this->options['togglePaletteLessText']))
            $this->options['togglePaletteLessText'] = 'less';
        //
        if (!isset($this->options['palette']))
            $this->options['palette'] = array(
                array("#000", "#444", "#666", "#999", "#ccc", "#eee", "#f3f3f3", "#fff"),
                array("#f00", "#f90", "#ff0", "#0f0", "#0ff", "#00f", "#90f", "#f0f"),
                array("#f4cccc", "#fce5cd", "#fff2cc", "#d9ead3", "#d0e0e3", "#cfe2f3", "#d9d2e9", "#ead1dc"),
                array("#ea9999", "#f9cb9c", "#ffe599", "#b6d7a8", "#a2c4c9", "#9fc5e8", "#b4a7d6", "#d5a6bd"),
                array("#e06666", "#f6b26b", "#ffd966", "#93c47d", "#76a5af", "#6fa8dc", "#8e7cc3", "#c27ba0"),
                array("#c00", "#e69138", "#f1c232", "#6aa84f", "#45818e", "#3d85c6", "#674ea7", "#a64d79"),
                array("#900", "#b45f06", "#bf9000", "#38761d", "#134f5c", "#0b5394", "#351c75", "#741b47"),
                array("#600", "#783f04", "#7f6000", "#274e13", "#0c343d", "#073763", "#20124d", "#4c1130"),
            );
        //
    }
    /**
     * generate script
     */
    function registerScript() {
        ///
        if (!defined('YII_MSpectrum')) {
            $dir = dirname(__FILE__);
            $baseUrl = Yii::app()->getAssetManager()->publish($dir);
            $cs = Yii::app()->getClientScript();
            $cs->registerScriptFile($baseUrl . '/js/colorpicker.js');
            $cs->registerCssFile($baseUrl . '/css/colorpicker.css');
            //
            if ($this->language)
                $cs->registerScriptFile($baseUrl . '/js/i18n/language-' . $this->language . '.js');
            define('YII_MSpectrum', 'true');
        }
        //
        $cs = Yii::app()->clientScript;
        //
        $selector = '#' . $this->htmlOptions['id'];
        $cs->registerScript(
                __CLASS__ . $selector, 'jQuery(' . CJavaScript::encode($selector) . ').spectrum(' . CJavaScript::encode($this->options) . ');', CClientScript::POS_READY
        );
    }

}
