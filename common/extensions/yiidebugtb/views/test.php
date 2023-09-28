<script>
    alert("abc");
</script>
<?php
    echo '<script>alert("'.Yii::app()->findLocalizedFile($viewFile,'en').'")</script>';
?>
Test