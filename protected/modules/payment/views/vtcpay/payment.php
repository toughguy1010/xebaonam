<form name="form1" method="post" action="checkout.php" id="form1">
    <table>
        <tr>
            <td>OrderID</td>
            <td>
                <input name="txtOrderID" type="text" value="<?php echo date("YmdHis") ?>" id="txtOrderID" />
            </td>
        </tr>
        <tr>
            <td>Customer First Name</td>
            <td>
                <input name="txtCustomerFirstName" type="text" value="" id="txtCustomerFirstName" />
            </td>
        </tr>
        <tr>
            <td>Customer Last Name</td>
            <td>
                <input name="txtCustomerLastName" type="text" value="" id="txtCustomerLastName" />
            </td>
        </tr>
        <tr>
            <td>Bill to address line 1</td>
            <td>
                <input name="txtBillAddress1" type="text" value="" id="txtBillAddress1" />
            </td>
        </tr>
        <tr>
            <td>Bill to address line 2</td>
            <td>
                <input name="txtBillAddress2" type="text" value="" id="txtBillAddress2" />
            </td>
        </tr>
        <tr>
            <td>City</td>
            <td>
                <input name="txtCity" type="text" value="" id="txtCity" /></td>
        </tr>
        <tr>
            <td>Country</td>
            <td>
                <input name="txtCountry" type="text" value="" id="txtCountry" />
            </td>
        </tr>
        <tr>
            <td>Customer Email</td>
            <td>
                <input name="txtCustomerEmail" type="text" value="" id="txtCustomerEmail" />
            </td>
        </tr>
        <tr>
            <td>Customer Mobile</td>
            <td>
                <input name="txtCustomerMobile" type="text" value="" id="txtCustomerMobile" />
            </td>
        </tr>
        <tr>
            <td>Param Exten</td>
            <td>
                <input name="txtParamExt" type="text" value="" id="txtParamExt" />
            </td>
        </tr>
        <tr>
            <td>URL return</td>
            <td>
                <input name="txtUrlReturn" type="text" value="" id="txtUrlReturn" />
            </td>
        </tr>
        <tr>
            <td>Secret Key</td>
            <td>
                <input name="txtSecret" type="text" value="<?php echo $config->secure_pass ?>" id="txtSecret" />
            </td>
        </tr>
        <tr>
            <td>Price: </td>
            <td>
                <input name="txtTotalAmount" type="text" value="10000" id="txtTotalAmount" />
            </td>
        </tr>
        <tr>
            <td class="style1">Unit: </td>
            <td class="style1">
                <input name="txtCurency" type="text" value="1" id="txtCurency" />
                &nbsp;<i>1:VND 2:USD</i>
            </td>
        </tr>
        <tr>
            <td>Website ID</td>
            <td><input name="txtWebsiteID" type="text" value="<?php echo $config->merchan_id ?>" id="txtWebsiteID" /></td>
        </tr>
        <tr><td></td><td></td></tr>
        <tr>
            <td>Recieve Account</td>
            <td>
                <input name="txtReceiveAccount" type="text" value="<?php echo $config->api_user ?>" id="txtReceiveAccount" />
            </td>
        </tr>		
        <tr>
            <td>Description</td>
            <td>
                <input name="txtDescription" type="text" value="MUA_DIEN_THOAI" id="txtDescription" />
            </td>
        </tr>
        <tr>
            <td></td>
            <td>	
                <input type="submit" name="Button1" value="Pay with Paygate" id="Button1" style="width:188px;" />
            </td>
        </tr>
    </table>
</form>