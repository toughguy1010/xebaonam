<?php if (isset($data) && count($data)) { ?>
     <ul class="menu-repairs menu-video clearfix">
          <?php
          $i = 0;
          foreach ($data as $menu_id => $menu) {
               ++$i;
               $m_link = $menu['menu_link'];
               ?>
               <li class="<?php echo ($menu['active']) ? 'active' : '' ?>">
                    <a href="<?php echo $m_link; ?>" title="<?php echo $menu['menu_title']; ?>">
                         <?php if (isset($menu['active']) & $i == 1) { ?>
                              <i class="icon-repairs repairs-home"></i>
                         <?php } ?>
                         <span><?php echo $menu['menu_title']; ?></span>
                    </a>
               </li>
          <?php } ?>
     </ul>
<?php } ?>