<table class="table table-bordered">
    <tbody>
        <tr align="center">
            <th class="center"><b>Tiền gốc(VND)</b></th>
            <th class="center"><b>Tiền lãi(VND)</b></th>
            <th class="center"><b>Số tiền thanh toán cuối kỳ(VND)</b></th>
        </tr>
        <tr align="center">
            <td><?php echo number_format($array_money['principal'], 0, '', '.'); ?></td>
            <td><?php echo number_format($array_money['interest'], 0, '', '.'); ?></td>
            <td><?php echo number_format($array_money['sum_printcipal_interest'], 0, '', '.'); ?></td>
        </tr>
        <tr style="font-weight: bold; color: #FF0000" align="center">
            <td>Tổng</td>
            <td></td>
            <td><?php echo number_format($array_money['sum_printcipal_interest'], 0, '', '.'); ?></td>
        </tr>
    </tbody>
</table>