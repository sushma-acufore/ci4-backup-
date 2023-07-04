<?php 
<?php include ( APPPATH . 'views/onlineorder/components/header.php' ); 
\Config\Services::session();
use App\Models\MyordersView;
$ordmodel = new MyordersView();

// include_once("inc/init.php");

//$cid = 'TEST2';
$auto_id = filter_input(INPUT_POST, 'auto_id', FILTER_SANITIZE_STRING);
// $Auto_id1=str_replace('"', '', $Auto_id);
// $Auto_id = trim($Auto_id1);

if(!isset($_POST['auto_id'])){
    echo "<script>window.location.href='my-orders.php'</script>";
}

//$Auto_id = '2ISA62UIS41M4000';
$resultm = MyordersView::getebms_order_one($auto_id);
$result1 = $resultm;

$resultn = MyordersView::getebms_order_two($auto_id);
$result_bill = $resultn;

// $sql1= "SELECT array_data FROM `ebms_order_main` where `AUTOID` = '$Auto_id'";
// $result1 = mysqli_query($conn, $sql1);

// $sql_bill= "SELECT * FROM `ebms_order_billing_details` where `AUTOID` = '$Auto_id'";
// $result_bill = mysqli_query($conn, $sql_bill);

// $fetch_bill=mysqli_fetch_array($result_bill);
$C_ID = '';
$C_NAME = '';
$C_ADDRESS1 = '';
$C_CITY = '';
$C_STATE = '';
$C_COUNTRY = '';
$C_ZIP = '';
$SALESMAN = '';
$SALESMAN_Field = '';
$PO_NO = '';
$SHIP_DATE = '';
$SHIP_VIA = '';
$TERMS = '';
$TAX = '';
$TOTAL_SO = '';
$GRACE = '';
$CHARGE = '';
$DISCOUN = '';

foreach ($result_bill as $fetch_bill) {
    $AUTOID = $fetch_bill['AUTOID'];
    
    foreach ($result1 as $fetch_bill1) {
        $INVOICE = $fetch_bill1['INVOICE'];
    }
    
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
    $SHIP_VIA = $fetch_bill['SHIP_VIA'];
    $TERMS = $fetch_bill['TERMS'];
    $TAX = $fetch_bill['TAX'];
    $TOTAL_SO = $fetch_bill['TOTAL_SO'];
    $GRACE = $fetch_bill['GRACE'];
    $CHARGE = $fetch_bill['CHARGE'];
    $DISCOUN = $fetch_bill['DISCOUN'];
}
?>


<!-- bill print div starts -->
<div class="container my-5">
    <div class="row" style="padding:10px;">
        <div class="col-lg-12 bill-print-div">
            <div class="col-md-12"><small style="display: bold;"><?php echo 'Invoice Number  :  '.$INVOICE.' '; ?></small >
                <div class="col-md-12 image-div">
                    <img src="<?= base_url(); ?>public/assets/img/baumalight-logo2.png" />
                </div>
                <div class="row address-div">
                    <div class="col-md-2 billing-to-div">
                        <h1 class="billing-to-heading">Billing to: </h1>
                        <p class="billing-to-ptag">
                            <?php
                            
                                echo $C_NAME ."<br>"; 
                                echo $C_ADDRESS1 ."<br>";
                                echo $C_CITY ."<br>";
                                echo $C_STATE ."<br>";
                                echo $C_COUNTRY ."<br>";
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
$counter = 1; // Initialize the counter variable
// Retrieve data from the database

$result_t = MyordersView::getebms_order_three($auto_id);
$row = $result_t;

// $query = "SELECT * FROM `ebms_order_child` WHERE `AUTOID` = '$Auto_id'";
// $result = mysqli_query($conn, $query); 
// while ($row = mysqli_fetch_assoc($result))
//  {
foreach ($result_t as $row)
{
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

        if(!empty($discount_name) || $discount8weeks_status==1)
        {
            // if(strlen($discount_name)>20)
            // {
            //     $discount_name = substr($discount_name, 0, 20)."...";
            // }
            echo '<tr class="table-default-preview">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>'.$discount_name.'</td>
                        <td>'.$discount_name.'</td>
                        <td></td>
                        <td></td>
                        <td class="align-right">-&nbsp;$'.$total_8weeksdiscount_amt.'</td>
                    </tr>'; 
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
                <td style="text-align: right;"><b>$<?php echo number_format((float)$TAX, 2); ?></b></td>

            </tr>
            <tr> 
                <td colspan="2" > Total :</td>
                <td style="text-align: right;" ><?php
                $Ftotal = '';

                    $resultm = MyordersView::getebms_order_one($auto_id);
                    $result1 = $resultm;
                    foreach ($resultm as $result1)
                        {
                                $Ftotal = $result1['totalprice'];
                        }
                // $sql1 = "SELECT * FROM `ebms_order_main` where `AUTOID`='$Auto_id'";
                // $result1 = mysqli_query($conn, $sql1);
                    
                // while($row = mysqli_fetch_assoc($result1)){
                //     $Ftotal = $row['totalprice'];
                // } 
                echo "$".number_format($Ftotal,2);
                    ?></td>
                
            </tr>
        </tfoot>
         <!-- table foot for tax and total display ends-->

</table>
                        
<div style='float: right; margin-top: 20px; margin-bottom: 20px;'>
    <button class="button" onclick="redirectToIndex()" style="float: right; color: #0A4276; background-color: #ECC712; border: none; border-radius: 50px; width: 20%; height:37px;">Back to My Orders </button>
</div>




                    </div>
                </div>


            </div>
        </div>
    </div>
</div>


<script>
    function redirectToIndex() {
    window.location.href = '<?= base_url(); ?>my-orders';
    }
</script>

<!-- bill print div ends -->

<?php include ( APPPATH . 'views/onlineorder/components/footer.php' ); ?>




