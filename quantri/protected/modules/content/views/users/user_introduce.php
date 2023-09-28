<h3 class="username-title"> Mạng lưới toàn hệ thống </h3>
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/tree.css" >
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jstree.min.js"></script>
<div id="using_json_2"></div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#using_json_2').jstree({'core': {
                'data': <?php echo $html ?>
            }});
    });
</script>
