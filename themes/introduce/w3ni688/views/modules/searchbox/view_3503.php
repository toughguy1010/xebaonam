 <form method="<?= $method; ?>" action="<?= $action; ?>" class="timkiem_top no_box">
     <div class="search">
         <a onclick="$('.timkiem.no_box').submit()"
            style="cursor:pointer"> <i class="fa fa-search"></i></a>
         <input type="text" autocomplete="off" placeholder="<?= $placeHolder; ?>" value="<?= $keyWord; ?>" name="<?php echo $keyName; ?>" class="input_search input_search_enter"  id="key" >
     </div>
 </form>