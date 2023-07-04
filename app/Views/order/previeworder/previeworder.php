<?php 
include_once('App\Views\order\header.php'); 

\Config\Services::session();
use App\Models\Ordermodel;
$ordmodel = new Ordermodel();
?>



<style>
.table-responsive {
    overflow-x: inherit!important;
}
</style>
<?php 
$json_data1 = $_SESSION['SalesOrder_result'];
?>



    </div>
    <div class="container preview-of-search-container">
    <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-3" style="padding-left:0px;">
                <!-- <div class="your-order-btn"><a href="#">Your Order</a></div> -->
                <button type="button" class="your-order-btn">Your Order</button>
            </div>
    </div>
            <!-- <div class="col-lg-9">

            </div> -->
        <div class="row ">
            <!-- <div class="container" style="margin-bottom: 74px;"> -->
                <div class="col-lg-12 table-preview-area-row" style="padding: 10px;">
                  
                    <div class="col-lg-12 table-responsive ">
                        <table class="table table-preview-data" id="table-data">
                            <thead>
                                <tr class="table-dark tr-head table-default-preview">
                                    <th class="tr-preview">Customer ID : <br><?php echo $json_data1['ID']; ?></th>
                                    <th class="tr-preview">Order # : <br><?php echo $json_data1['AUTOID']; ?></th>
                                    <th class="tr-preview">PO Number : <br><?php if(isset($_SESSION['po_by_customer'])) { echo $_SESSION['po_by_customer']; } ?></th>
                                    <th class="tr-preview">Date : <br><?php echo $json_data1['INV_DATE']; ?></th>
                                    <th class="tr-preview">Contact number : <br><?php echo $json_data1['C_PHONE']; ?></th>
                                    <th class="tr-preview"> Email : <br><?php echo $json_data1['C_EMAIL']; ?></th>
                                </tr>
                            </thead>

                        </table>
                    </div>


                    <div class="col-lg-12">
                        <div class="row ">
                            <div class="col-lg-6">
                                <div class="card card-design-preview">
                                    <div class="card-body" style="text-align:left;">
                                        <h6 class="card-title">Billing To</h6> 
                                        <h6 class="card-subtitle mb-2 text-body-secondary"># <?php echo $json_data1['ADDRESS1'].$json_data1['ADDRESS2']; ?></h6>
                                        <h6 class="card-subtitle mb-2 text-body-secondary">
                                        	City: <?php echo $json_data1['CITY']; ?> <br>
                                        	State: <?php echo $json_data1['STATE']; ?> <br>
                                        	Country: <?php echo $json_data1['COUNTRY']; ?> <br>
                                        	Zip: <?php echo $json_data1['ZIP']; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card card-design-preview">
                                    <div class="card-body" style="text-align: left;">
                                        <h6 class="card-title">Shipping To</h6> 
                                        <h6 class="card-subtitle mb-2 text-body-secondary"># <?php echo $json_data1['C_ADDRESS1'].$json_data1['C_ADDRESS2']; ?></h6>
                                        <h6 class="card-subtitle mb-2 text-body-secondary">
                                        	City: <?php echo $json_data1['C_CITY']; ?> <br>
                                        	State: <?php echo $json_data1['C_STATE']; ?> <br>
                                        	Country: <?php echo $json_data1['C_COUNTRY']; ?> <br>
                                        	Zip: <?php echo $json_data1['C_ZIP']; ?>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row table-responsive ">

                        <table class="table table-preview table-borderless" id="table-data">
                            <thead>
                                <tr class="table-dark tr-head">
                                    <th class="tr-preview">PART&nbsp;NUMBER</th>
                                    <th class="tr-preview">DESCRIPTION</th>
                                    <th class="tr-preview">STOCK</th>
                                    <th class="tr-preview">QUANTITY</th>
                                    <th class="tr-preview">LIST&nbsp;PRICE</th>
                                    <th class="tr-preview">DEALER&nbsp;DISCOUNT</th>
                                    <th class="tr-preview">*STOCK&nbsp;DEALER&nbsp;PRICE</th>
                                    <th class="tr-preview">EXTENDED&nbsp;PRICE</th>
                                    

                                </tr>
                            </thead>
                            <tbody>
                            <?php
								// $cid = $json_data1['ID'];
								$e1 = '';
                                $result1 = Ordermodel::getproduct_for_preview($cid);
								/*$sql1="SELECT * FROM `product_cart` where `cid`= '".$cid."'";
								$result1 = mysqli_query($conn,$sql1);
								$num_rows1 = mysqli_num_rows($result1);*/
								if(!empty($result1))
								{
								   
                                    foreach ($result1 as $row1)
								    {
								        $rid = $row1['id'];
								        $product = $row1['product'];
								        $lprice = $row1['lprice'];
								        $description = $row1['description'];
                                        $fulldescription=$row1['description'];
                                        $fulldescription=str_replace('"', '', $fulldescription);
								        $sp_price = $row1['sp_price'];
								        if(strlen($description)>15)
								        {
								            $description = substr($description, 0, 15)."...";
								        }
								        $qty = $row1['qty'];
								        $price = $row1['price'];
								        $discount_name = $row1['discount_name'];
								        $discount = $row1['discount'];
								        $totalprice = $row1['totalprice'];
								        $currency = $row1['currency'];
								        $discount8weeks_status = $row1['discount8weeks_status'];
                                        
                                        $sp_price = number_format($sp_price,2);
								        $lprice = number_format($lprice,2);
								        $price = number_format($price,2);
								        $totalprice = number_format($totalprice,2);
								        

                                        $total_8weeksdiscount_amt = $row1['total_8weeksdiscount_amt'];
                                        $total_8weeksdiscount_amt = number_format($total_8weeksdiscount_amt,2);

                                        $row_avl = Ordermodel::geteagle_available_stock_for_preview($cid);
								        /*$sql_avl= "SELECT * FROM `eagle_available_stock` where `Part_Number` = '" . $product . "'";
								        $result_avl = mysqli_query($conn,$sql_avl);
								        $row_avl=mysqli_fetch_array($result_avl);*/
								        $avl_stock ='';
								        $serial_no_count = 0;
								        if(!empty($row_avl))
								        {
								            $avl_stock=$row_avl['S_AVAIL'];
								        }

								        $e1 .='<tr class="table-default-preview">
								                                    <td>'.$product.'</td>
                                                                    <td  data-toggle="tooltip" title="'.$fulldescription.'">'.$description.'</td>
								                                    <td>'.$avl_stock.'</td>
								                                    <td>'.$qty.'</td>
								                                    <td class="align-right">$'.$lprice.'</td>
								                                    <td class="align-right">$'.$sp_price.'</td>
								                                    
								                                ';
								                // stock discount
								                if($discount>0)
								                {
								                    $e1 .= '<td class="align-right"><button class="btn-more-info-order">$'.$totalprice.'</button></td>';
                                                    $e1 .= '<td class="align-right">$'.$totalprice.'</td>';
								                }else
								                {
								                    $e1 .= '<td class="align-right"><form method="post" action="stock-dealer-registration.php">
                                                    <input type="hidden" name="part_number" value="'.$product.'"/>
                                                    <button type="submit" class="cart-table-btn-dealer-price" >Click&nbsp;Here</button></form></td>';
                                                    $e1 .= '<td class="align-right">$'.$price.'</td>';
								                }

								                $e1 .='
								            </tr>';   
								            if(!empty($discount_name) || $discount8weeks_status==1)
								            {
								            	if(strlen($discount_name)>20)
										        {
										            $discount_name = substr($discount_name, 0, 20)."...";
										        }
								                 $e1 .='<tr class="table-default-preview">
                                                            <td>'.$discount_name.'</td>
								                            <td>'.$discount_name.'</td>
								                            <td></td>
								                            <td></td>
								                            <td></td>
                                                            <td></td>
								                            <td></td>';
								                            $e1 .='<td class="align-right">-&nbsp;$'.$total_8weeksdiscount_amt.'</td>
								                        </tr>'; 
								            }

								    }

								    
								}
								echo $e1;


								?>
   
                            <tfoot>
                                <tr>
                                   <td colspan="6" rowspan="3" class="tax-col details" style="text-align: left;"> 
										<div style="color:#fff">
										<b style="color:#ecc712;font-weight: bold;font-size: small;">GRACE DEADLINE :</b> <span><?= $json_data1['GRACE'];?></span><br>
										<b style="color:#ecc712;font-weight: bold;font-size: small;">DISCOUNT TERM :</b> <span><?= $json_data1['DISCOUN'];?></span><br>
										<b style="color:#ecc712;font-weight: bold;font-size: small;">PAYMENT TERM :</b> <span><?= $json_data1['CHARGE'];?></span>
										</div>
                                        <!--
										<b style="color:#ecc712;font-weight: bold;font-size: small;">GRACE DEADLINE :</b> <?= $json_data1['GRACE'];?><br>
                                        <b style="color:#ecc712;font-weight: bold;font-size: small;">DISCOUNT TERM :</b> <?= $json_data1['DISCOUN'];?><br>
                                        <b style="color:#ecc712;font-weight: bold;font-size: small;">PAYMENT TERM :</b> <?= $json_data1['CHARGE'];?> -->
                                    </td>
                                    <td class="tax-design" style="vertical-align:top">Tax:</td>
                                    <td style="float:right"><button class="btn-more-price" style="text-align: right;">$<?php echo number_Format($json_data1['TAX'],2); ?></button></td>
                                </tr>
								
                                <tr>
                                    <td class="tax-design" style="vertical-align:top">Total Amount
                                    </td>
                                    <td style="float:right"><button class="btn-more-price" style="text-align: right;">$<?php echo number_format($json_data1['TOTAL_SO'],2); ?></button></td>
                                </tr>
								
								<tr>
                                   
								</tr>
                            </tfoot>

                            </tbody>
                        </table>
                    </div>

                    
                    <div class="row">
                        <div class="col-md-12" style="text-align:left">
                            <button class="btn cancel-btn" type="button" onclick="clear_cart_item('<?= $_SESSION['E_EID']?>');">Cancel
                                    Order</button>

                        <a href="cart.php"><button class="btn cancel-btn" type="button">Edit Order</button></a>

                            <!-- pop up -->
                            <!-- Button trigger modal -->
                            <form method="post" action="bill-print.php" id="myForm" style="float:right">
                                <input type="hidden" name="auto_id" id="auto_id" value=""/>
			                    <button type="button" style="width:100%; height:100%;" 
                                class="btn place-order-preview-btn" onclick="send_order()">
			                    Place Order
			                    </button>
			                  </form>
                            <!-- Modal -->
                            <div class="modal fade preview-order-modal" id="exampleModal" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content modal-box-design">

                                        <div class="modal-body">
                                            Your order has been placed successfully.
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn popup-btn-okay"><a
                                                    href="bill-print.html">Okay</a></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- pop up -->


                        </div>
                    </div>
                </div>

            </div>
        </div>
    <!-- </div> -->
    <!-- preview order ends -->

<?php include_once('public/assets/js/preview/preview.js'); ?>

<?php include_once('App\Views\order\footer.php'); ?>