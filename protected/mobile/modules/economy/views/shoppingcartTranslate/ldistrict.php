<ul>
    <?php foreach ($langs as $key => $lang) { ?>
        <li>
            <label><? echo ClaLanguage::getCountryName($key) ?>
                <input value="<?= $key ?>" name="langto[]" type="checkbox">
                <span class="checkmark"></span>
            </label>
        </li>
    <?php } ?>
</ul>