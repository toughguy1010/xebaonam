<?php
$cdata = count($data);
if ($data && $cdata) {
    ?>
    <ul class="breadcrumb">
        <?php
        foreach ($data as $name => $crumb) {
            ?>
            <li><a href="<?php echo $crumb ?>" title="<?php echo $name ?>" ><?php echo $name; ?></a></li>
        <?php } ?>
    </ul>
    <style>
      .breadcrumb li a{
          text-transform: lowercase;
          display: inherit;
          /*visibility:hidden;*/
      }
      .breadcrumb li a::first-letter{
          text-transform: capitalize;
          visibility:visible;
      }
    </style>
<?php } ?>