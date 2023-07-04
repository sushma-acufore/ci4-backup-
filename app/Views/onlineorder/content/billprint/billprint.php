<?php include ( APPPATH . 'views/onlineorder/components/header.php' ); 
\Config\Services::session();
use App\Models\MyordersView;
$ordmodel = new MyordersView();

$auto_id=trim($auto_id);
$result_t = MyordersView::get_ebms_order_billing_details($auto_id);

   $fetch_bill = $result_t;
   $AUTOID = $fetch_bill['AUTOID'];
   $Auto_id = $auto_id = $AUTOID;
   $INVOICE = $fetch_bill['INVOICE'];
   $C_ID = $fetch_bill['cid'];
   $C_NAME = $fetch_bill['C_NAME'];
   $C_ADDRESS1 = $fetch_bill['C_ADDRESS1'];
   $C_CITY = $fetch_bill['C_CITY'];
   $C_STATE = $fetch_bill['C_STATE'];
   $C_COUNTRY = $fetch_bill['C_COUNTRY'];
   $C_ZIP = $fetch_bill['C_ZIP'];
   $SALESMAN = $fetch_bill['SALESMAN'];
   $SALESMAN_Field = $fetch_bill['SALESMAN_Field'];
   $PO_NO = $fetch_bill['PO_NO'];
   //$SHIP_DATE = $fetch_bill['SHIP_DATE'];
   $SHIP_DATE = '';

   $SHIP_VIA = $fetch_bill['SHIP_VIA'];
   $TERMS = $fetch_bill['TERMS'];
   $TAX = $fetch_bill['TAX'];
   $TOTAL_SO = $fetch_bill['TOTAL_SO'];
   $GRACE = $fetch_bill['GRACE'];
   $CHARGE = $fetch_bill['CHARGE'];
   $DISCOUN = $fetch_bill['DISCOUN'];

   $billto_ADDRESS1 = $fetch_bill['BILLEDTO_ADDRESS1'];
   $billto_CITY = $fetch_bill['BILLEDTO_CITY'];
   $billto_COUNTRY = $fetch_bill['BILLEDTO_COUNTRY'];
   $billto_STATE = $fetch_bill['BILLEDTO_STATE'];
   $billto_ZIP=$fetch_bill['BILLEDTO_ZIP'];	
?>
<!-- bill print div starts -->
<div class="container my-5">
    <div class="row" style="padding:10px;">
        <div class="col-lg-12 bill-print-div">
            <div class="col-md-12"><small style="display: bold;"><?php echo 'Invoice Number  :  '.$INVOICE.' '; ?></small >
                <div class="col-md-12 image-div">
                    <img src="<?php echo base_url(); ?>public/assets/img/baumalight-logo2.png" />
                </div>
                <div class="row address-div">
                    <div class="col-md-2 billing-to-div">
                        <h1 class="billing-to-heading">Billing to: </h1>
                        <p class="billing-to-ptag">
                            <?php
                                echo $C_NAME ."<br>"; 
                                echo $billto_ADDRESS1 ."<br>";
                                echo $billto_CITY ."<br>";
                                echo $billto_STATE ."<br>";
                                echo $billto_COUNTRY ."<br>";
                            ?>
                        </p>
                    </div>


<div class="col-md-8 shipping-to-div">
</div>

                    <div class="col-md-2 shipping-to-div" style="text-align: left;">
                        <h1 class="shipping-to-heading">Shipping to:</h1>
                        <p class="shipping-to-ptag" >
                            <?php
                                echo $C_NAME ."<br>"; 
                                echo $C_ADDRESS1 ."<br>";
                                echo $C_CITY ."<br>";
                                echo $C_STATE ."<br>";
                                echo $C_COUNTRY ."<br>";
                            ?>
                        </p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="row table-responsive bill-table-customer-details">
                        <table class="table">
                            <thead class="bill-table-head">
                                <tr>
                                    <th>Customer ID</th>
                                    <th>Sales Person</th>
                                    <th>P.O Number</th>
                                    <th>Entered By</th>
                                    <th>Expected ship date</th>
                                    <th>Ship via</th>
                                    <th>Terms</th>
                                </tr>
                            </thead>
                            <tbody class="bill-table-cust">
                                <tr>
                                    <td><?php echo $C_ID ; ?></td>
                                    <td><?php echo $SALESMAN ; ?></td>
                                    <td><?php echo $PO_NO ; ?></td>
                                    <td><?php echo $SALESMAN_Field; ?></td>
                                    <td><?php echo $SHIP_DATE ; ?></td>
                                    <td><?php echo $SHIP_VIA ; ?></td>
                                    <td><?php echo $TERMS ; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row table-responsive bill-table-product-details">
                        <table class="table bill-table-product">
                            <thead>
                                    <tr>
                                        <th>SL.NO.</th>
                                        <th>Unit</th>
                                        <th>Weight</th>
                                        <th>Product ID</th>
                                        <th class="align-left">Description</th>
                                        <th class="align-left">List Price</th>
                                        <th class="align-left">Discount Price</th>
                                        <th class="align-left">Extended Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                            
<?php
$counter = 1; 
// Initialize the counter variable
// Retrieve data from the database

$result_t = MyordersView::get_ebms_bill_child($auto_id);
foreach ($result_t as $row)
{
    $qty = $row['qty'];
    $rid = $row['id'];

    $num_disc_items = MyordersView::getproduct_cart_discount_items_count($rid);
    $fetch_disc_items = MyordersView::getproduct_cart_discount_items($rid);

    $qty = $row['qty'];
    $product = $row['product'];
    $description = $row['description'];
    $lprice = $row['lprice'];
    $sp_price = $row['sp_price'];
    $totalprice = $row['totalprice'];

    $discount_name = $row['discount_name'];
    $discount8weeks_status = $row['discount8weeks_status'];
    $total_8weeksdiscount_amt = $row['total_8weeksdiscount_amt'];
    $total_8weeksdiscount_amt = number_format($total_8weeksdiscount_amt,2);
    // Append the row
    echo '<tr>
            <td>'.$counter.'</td>
            <td>'.$qty.'</td>
            <td>-</td>
            <td>'.$product.'</td>
            <td class="align-left">'.$description.'</td>
            <td class="align-right">$'.number_format($lprice,2).'</td>
            <td class="align-right">$'.number_format($sp_price,2).'</td> 
            <td class="align-right">$'.number_format($totalprice,2).'</td> 
        </tr>';

        if($num_disc_items>0)
        {
            foreach ($fetch_disc_items as $fetch_disc_item_row) 
            {
            $discount_item_name=$fetch_disc_item_row['discount_name'];
            $full_discount_item_name=$fetch_disc_item_row['discount_name'];
            if(strlen($fetch_disc_item_row['discount_name'])>20)
            {
                $discount_item_name = substr($fetch_disc_item_row['discount_name'], 0, 20)."...";
            }
             $total_discount_amt=$fetch_disc_item_row['discount_price']*$qty;
            echo '<tr class="table-default-preview">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>'.$full_discount_item_name.'</td>
                        <td>'.$full_discount_item_name.'</td>
                        <td></td>
                        <td></td>
                        <td class="align-right">-&nbsp;$'.$total_discount_amt.'</td>
                    </tr>'; 
        }
    }
         $counter++; // Increment the counter variable
}
?>
    </tbody>
        
        <!-- table foot for tax and total display -->
        <tfoot>
            <tr>
                <td colspan="5" rowspan="2" class="tax-col details" style="text-align: left;"> 
                    <?php
                    echo '<p style="font-size: 15px;">' .
                        'GRACE DEADLINE : ' . $GRACE . '<br>' .
                        'DISCOUNT TERM : ' . $DISCOUN. '<br>' .
                        'PAYMENT TERM : ' . $CHARGE. ' ' .
                        '</p>';
                    ?>
                </td>
                <td colspan="2" >Tax :</td>
                <td style="text-align: right;"><b>$<?php echo number_format($TAX,2); ?></b></td>
            </tr>
            <tr> 
                <td colspan="2" > Total :</td>
                <td style="text-align: right;" ><?php
                $Ftotal = '';

                $result1 = MyordersView::get_ebms_bill_main($Auto_id);
                foreach ($result1 as $row) {
                // while($row = mysqli_fetch_assoc($result1)){
                    $Ftotal = $row['totalprice'];
                } 
                echo "$".number_format($Ftotal,2);
                    ?></td>
                
            </tr>
        </tfoot>
         <!-- table foot for tax and total display ends-->

</table>
                        
<div style='float: right; margin-top: 20px; margin-bottom: 20px;'>
    <a href='index'><button class="button" style="float: right; color: #0A4276; background-color: #ECC712; border: none; border-radius: 50px; width: 20%; height:37px;">Back to home </button></a>
</div>




                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<?php include ( APPPATH . 'views/onlineorder/components/footer.php' ); ?>




