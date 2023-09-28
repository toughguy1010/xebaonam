<div class="text-center">
    <span class="<?php echo $this->buttonClass; ?> fileinput-button">
        <i class="icon-cloud-upload bigger-200"></i>
        <span class="bigger-200"><?php echo $this->buttontext; ?></span>
        <input id="<?php echo ($this->id) ? $this->id : 'uploadfile'; ?>" type="file" multiple="<?php echo ($this->multi) ? 'true' : 'false'; ?>" name="<?php echo ($this->name) ? $this->name : 'files' ?>" />
    </span>
    <br></br>
</div>