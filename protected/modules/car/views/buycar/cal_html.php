<table class="table table-bordered">
    <tbody>
        <tr>
            <th><b>Kỳ</b></th>
            <th><b>Tiền gốc(VND)</b></th>
            <th><b>Tiền lãi(VND)</b></th>
            <th><b>Gốc + Lãi(VND)</b></th>
            <th><b>Dư nợ(VND)</b></th>
        </tr>
        <?php
        $total_principal = 0;
        $total_interest = 0;
        $total_printcipal_interest = 0;
        foreach ($array_money as $month => $money) {
            $total_principal += $money['principal'];
            $total_interest += $money['interest'];
            $total_printcipal_interest += $money['sum_printcipal_interest'];
            ?>
            <tr align="center">
                <td><?php echo $month ?></td>
                <td><?php echo number_format($money['principal'], 0, '', '.'); ?></td>
                <td><?php echo number_format($money['interest'], 0, '', '.'); ?></td>
                <td><?php echo number_format($money['sum_printcipal_interest'], 0, '', '.'); ?></td>
                <td><?php echo ($money['recover_money'] > 0) ? number_format($money['recover_money'], 0, '', '.') : 0; ?></td>
            </tr>
            <?php
        }
        ?>
        <tr style="font-weight: bold; color: #FF0000" align="center">
            <td>Tổng</td>
            <td><?php echo number_format($total_principal, 0, '', '.'); ?></td>
            <td><?php echo number_format($total_interest, 0, '', '.'); ?></td>
            <td><?php echo number_format($total_printcipal_interest, 0, '', '.'); ?></td>
            <td></td>
        </tr>
    </tbody>
</table>