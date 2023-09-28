<?php

/**
 * Simple widjet for count down
 *
 * @author <minhcoltech@gmail.com>
 * @version 1.0
 */
class flipClock extends CWidget {

    public $clockFace = 'DailyCounter'; // style
    public $autoStart = 'false';
    public $time = 0; // Microtime
    public $element = ''; // Add clock to this element
    public $language = 'vi';

    public function init() {
        if ($this->element) {
            $this->time = (int) $this->time;
            //
            $cs = Yii::app()->getClientScript();
            $assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets');
            if (!defined('W3N_FlipClock')) {
                $cs->registerCssFile($assets . '/flipclock.css');
                $cs->registerScriptFile($assets . '/flipclock.js', CClientScript::POS_END);
                define('W3N_FlipClock', 'true');
            }
            //
        }
    }

    //
    function run() {
        Yii::app()->clientScript->registerScript('flipClock', ""
                . "var clock;
			clock = $('$this->element').FlipClock({
		        clockFace: '$this->clockFace',
                        language:'$this->language',
		        autoStart: $this->autoStart
		    });
				    
		    clock.setTime($this->time);
		    clock.setCountdown(true);
		    clock.start();"
                , CClientScript::POS_END);
    }

}
