<div class="row">
<?php
foreach ($data as $menu_id => $menu) {
     $i++;
     if ($i > $cols) {
          break;
     }
     ?>
     <div class="col-xs-6 customer-support">
          <h4><?php echo $menu['menu_title']; ?></h4>
          <?php if ($menu['items']) { ?>
          <ul>
               <?php } ?>
               <?php
               foreach ($menu['items'] as $item) {
                    ?>
                    <li>
                         <a href="<?php echo $item['menu_link']; ?>"
                            title="<?php echo $item['menu_title']; ?>">
                                   <span
                                        style="color: #fcae41;">●</span> <?php echo $item['menu_title']; ?>
                         </a>
                    </li>
               <?php } ?>
               <?php if ($menu['items']) { ?>
          </ul>
     <?php } ?>
     </div>
<?php } ?>
</div>

