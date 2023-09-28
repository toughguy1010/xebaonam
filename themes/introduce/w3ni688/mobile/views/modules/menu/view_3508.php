<?php if (isset($data) && count($data)) { ?>
    <style>
        .fixed-top {
            position: fixed;
            width: 100%;
            float: left;
            text-align: center;
            top: 0;
            display: none;
            z-index: 9;
        }

        body.fixed .fixed-top {
            display: block;
        }

        .fixed-top ul li {
            display: inline-block;
            width: 20%;
            float: left;
            padding: 10px 5px;
            background-color: #ed2024;
            border-right: 1px solid #fff;
        }

        .fixed-top ul li a {
            color: #fff;
            text-transform: uppercase;
        }
    </style>
    <div class="fixed-top">
        <ul>
            <?php foreach ($data as $menu_id => $menu) { ?>
                <li>
                    <a href="<?= $menu['menu_link'] ?>"><?= $menu['menu_title']; ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
<?php } ?>