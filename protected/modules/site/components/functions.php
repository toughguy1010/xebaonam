<?php

function replaceCallBack($matches) {
    $string = '';
    if (isset($matches[0])) {
        $string = '<img src="' . mb_strtolower($matches[3]).'" '.$matches['5'].'>';
    }
    return $string;
}