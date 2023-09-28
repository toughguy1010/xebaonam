<?php
if (isset($data) && count($data)) {
     ?>
     <div class="menu-show">
          <div class="row">
               <?php
               foreach ($data as $menu_id => $menu) {
                    $m_link = $menu['menu_link'];
                    ?>
                    <div class="col-xs-3 col-sm-3 menu-small">
                         <div class="box-menu-small">
                              <a href="<?php echo $m_link; ?>"
                                 title="<?php echo $menu['menu_title']; ?>">
                                   <h3><?php echo $menu['menu_title']; ?></h3>
                              </a>
                         </div>
                    </div>
               <?php } ?>
          </div>
     </div>
<?php } ?>