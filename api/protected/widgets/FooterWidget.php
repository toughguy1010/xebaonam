<?php

class FooterWidget extends CWidget {

    public $year;
    public function init() {
        $this->year = 0;
    }

    public function run() {
        $this->render('footer',array('year'=>  $this->year));
    }

}