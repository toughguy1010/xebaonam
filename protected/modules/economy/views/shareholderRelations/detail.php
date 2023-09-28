<script>
    $(document).ready(function (e) {
        setInterval(getData, 1000);
        startTime();
    });

    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var ap = "AM";

        //to add AM or PM after time

        if (h > 11) ap = "PM";
        if (h > 12) h = h - 12;
        if (h == 0) h = 12;

        //to add a zero in front of numbers<10

        m = checkTime(m);
        s = checkTime(s);

        $('#clock').html(h + ":" + m + ":" + s + " " + ap);
        t = setTimeout('startTime()', 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }

    function getData() {
        var url = "http://117.0.32.72:8080/sudico2016/json.php";
        $.ajax({
            type: 'GET',
            url: 'json.php',
            dataType: 'json',
            cache: false,

            success: function (data) {
                $('.so1').html(data.so1);
                $('.so2').html(data.so2);
                $('.so3').html(data.so3 + "%");
            }
        });
    }
</script>
<div class="style1">
    <span class="style2">
    <table style="width: 100%; height: 183px" class="style26">
        <tr>
            <td class="style23" style="width: 166px">
            <img alt="" height="179" src="images/logo.jpg" width="161"></td>
            <td class="style27">
            <h3 class="style18">CÔNG TY CỔ PHẦN ĐẦU TƯ PHÁT TRIỂN ĐÔ THỊ KCN
            SÔNG ĐÀ</h3>
    <span class="style2">
            <h3 class="style18">Song Da Urban Industrial Zone Development AndInvestment Joint Stock Company</h3>
    </span>
            <hr style="width: 631px; height: -15px">
            </td>
            </tr>
        </table>
        <h1 class="style22" style="height: 6px"></h1>
        <h3><span class="style12"><?= $shareholder_relation['title'] ?> </span>
<br class="style25"></h3>
    <span class="style20">
<p class="style19"><?= $shareholder_relation['title_en'] ?></p>
    </span>
    </span>
    <br>

    <table cellspacing="0" cellpadding="10" align="center">
        <tr>
            <td class="style14">
                TỔNG SỐ CỔ ĐÔNG THAM DỰ ĐẠI HỘI<br>Total number of shareholders attending the meeting
            </td>
            <span class="style2">
            <td class="style28"><span class="so1" style="font-size:20pt;"> <?= $shareholder_relation['total'] ?></span>
        </tr>

        <tr>
            <td class="style14">TỔNG SỐ CỔ PHIẾU CÓ QUYỀN BIỂU QUYẾT<br>Total number of shares with voting rights
            </td>
            <td class="style2">
                <span class="so2"
                      style="font-size:20pt;"><?= number_format($shareholder_relation['total_shares'], 0, '', ','); ?></span>
            </td>
        </tr>
        <tr>
            <td class="style14">
                TỶ LỆ <br>
                Ratio
            </td>
            <td class="style20">
                <span class="so3" style="font-weight: bold;"><?= $shareholder_relation['percentage']; ?> %</span>
            </td>
        </tr>
    </table>
    <br>
    <font id="clock" size="70"> 11:17:57 AM </font>

    <style>
        content {
            height: 75px;
            background-color: #000;
            color: #fff;

            min-width: 740px;
            max-width: 1200px;
        }

        table td {
            border-collapse: collapse;
            border: solid 1px black;
            table-layout: fixed;
        }

        .style1 {
            text-align: center;
        }

        .style1 table {
            margin: 0 auto;
        }

        .style2 {
            font-size: xx-large;
        }

        .style12 {
            font-family: "Times New Roman", Times, serif;

            font-size: 20pt;
            color: #FF0000;
        }

        .style14 {
            text-align: left;
            font-size: x-large;
        }

        .style18 {
            text-align: center;
            font-family: "Times New Roman", Times, serif;
            font-size: x-large;
        }

        .style19 {
            text-align: center;
            color: #FF0000;
        }

        .style20 {
            font-size: x-large;
        }

        .style21 {
            font-size: x-large;
            font-weight: bold;
        }

        .style22 {
            text-align: center;
            font-size: x-large;
        }

        .style23 {
            border-color: #FFFFFF;
            font-size: x-large;
            font-family: "Times New Roman", Times, serif;
        }

        .style25 {
            font-size: 2.87251 e+026;
        }

        .style26 {
            border: 1px solid #FFFFFF;
        }

        .style27 {
            border-color: #FFFFFF;
            font-size: xx-large;
        }

        .style28 {
            font-size: 5.82414 e+019;
            font-weight: bold;
        }


    </style>