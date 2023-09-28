<style type="text/css">
    #demo-wrap{
        -webkit-transition-property: all;
        -moz-transition-property: all;
        transition-property: all;
        -webkit-transition-duration: 300ms;
        -moz-transition-duration: 300ms;
        transition-duration: 300ms;
        -webkit-transition-timing-function: cubic-bezier(0.605, 0.195, 0.175, 1);
        -moz-transition-timing-function: cubic-bezier(0.605, 0.195, 0.175, 1);
        transition-timing-function: cubic-bezier(0.605, 0.195, 0.175, 1);
        max-width: 100%;
        max-height: 100%;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }
    #demo-wrap iframe{
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        height: 100%;
        min-width: 100%;
        border: none;
    }
</style>
<div id="demo-wrap">
    <iframe id="frame" src="<?php echo $theme['previewlink']; ?>"></iframe>
</div>