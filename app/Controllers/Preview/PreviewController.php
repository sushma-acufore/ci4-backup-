<?php 
namespace App\Controllers\Preview;
use App\Models\Preview\Preview;
use CodeIgniter\Controller;

class PreviewController extends BaseController
{
	protected $Preview;
    public function __construct()
    {
        \Config\Services::session();
        $this->preview = new Preview();
    }

    public function preview_order()
    {
        echo view('onlineorder/content/previeworder/previeworder');
    }

    public function billprint()
    {   
        // $Auto_id = 'VO6T3A8EG2CT0000';
        $Auto_id = trim($_POST['auto_id']);
        $Auto_id1=str_replace('"', '', $Auto_id);
        $Auto_id = trim($Auto_id1);
        
        if(!isset($_POST['auto_id'])){
            echo "<script>window.location.href='index.php'</script>";
        }
        $data['auto_id'] = $Auto_id;
        echo view('onlineorder/content/billprint/billprint', $data);
    }

    public function save_order_details()
    {
        $json_data1 = '';
        $cid = strtoupper($_POST['cid']);
        $ship_id = strtoupper($_SESSION['ship_id']);
        if(isset($_SESSION['po_by_customer']))
        {
            $po_by_customer = $_SESSION['po_by_customer'];
        }else
        {
            $po_by_customer = '';
        }
        $e = '';
        $result = $this->preview->getproduct_cid($cid);
        $result1 = $result->getNumRows();

        $child_items = $result->getResultArray();
        if($result1>0){
        $e .='{
			"ID": "'.$cid.'", 
			"C_ID": "'.$ship_id.'",
			"PO_NO": "'.$po_by_customer.'",
			"Details":
			[';

        foreach ($child_items as $row1) 
            {
                $rid = $row1['id'];

                $num_disc_items=$this->preview->getproduct_cart_discount_items_count($rid);
                $fetch_disc_items=$this->preview->getproduct_cart_discount_items($rid);
              
                $product = $row1['product'];
                $lprice = $row1['lprice'];
                $description = $row1['description'];
                $sp_price = $row1['sp_price'];
                if(strlen($description)>60)
                {
                    $description = substr($description, 0, 60)."...";
                }
                $qty = $row1['qty'];
                $price = $row1['price'];
                $discount_name = $row1['discount_name'];
                $discount = $row1['discount'];
                $totalprice = $row1['totalprice'];
                $currency = $row1['currency'];
                $discount8weeks_status = $row1['discount8weeks_status'];
               
                $e .='
                        {
                            "INVEN": "'.$product.'",
                            "M_QUAN_VIS": "'.$qty.'"
                        },
                    ';              
                    if($num_disc_items>0)
                    { 
                        foreach ($fetch_disc_items as $fetch_disc_item_row) {
                        $discount_item_name=$fetch_disc_item_row['discount_name'];
                        $e .='
                            {
                                "INVEN": "'.$discount_item_name.'",
                                "M_QUAN_VIS": "1"
                            },
                        ';  
                        } 
                    } 
            } //foreach end
            $e .=']
        }';

         //var_dump($e);

        //create sales order API
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://ECC842362022020802.servicebus.windows.net/myebms/MTB/odata/ARINV',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>''.$e.'',
        CURLOPT_HTTPHEADER => array(
        'Content-Type:  application/json',
        'Authorization: Basic QVBJQUNDRVNTOkFQSWFjY2Vzc0w='
        ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $json_data1 = json_decode($response,true);

        if(isset($json_data1['AUTOID']))
        {
            $_SESSION['SalesOrder_result'] = $json_data1;

            //var_dump($json_data1);

            // echo "<br>";
            $AUTOID='';
            $INVOICE='';
            
            $AUTOID = $json_data1['AUTOID'];
            $INVOICE = $json_data1['INVOICE'];
            //$totalprice = $json_data1['TOTAL_S_SO'];
            $totalprice = $json_data1['TOTAL_SO'];

           $AUTOID = trim($AUTOID);
           $C_ID = $json_data1['C_ID'];
           $C_NAME = $json_data1['C_NAME'];
           $C_ADDRESS1 = $json_data1['C_ADDRESS1'];
           $C_CITY = $json_data1['C_CITY'];
           $C_STATE = $json_data1['C_STATE'];
           $C_COUNTRY = $json_data1['C_COUNTRY'];
           $C_ZIP = $json_data1['C_ZIP'];
           $SALESMAN = $json_data1['SALESMAN'];
       
           //$SALESMAN_Field = $json_data1['SALESMAN_Field'];
           $SALESMAN_Field = $_SESSION['E_FULL_NAME'];
           $PO_NO = $json_data1['PO_NO'];
           
           $SHIP_DATE1 = $json_data1['SHIP_DATE'];
           $SHIP_DATE=date('Y-m-d h:i:s', strtotime($SHIP_DATE1));
           
           $SHIP_VIA = $json_data1['SHIP_VIA'];
           $TERMS = $json_data1['TERMS'];
           $TAX = $json_data1['SO_TAX'];
           $TOTAL_SO = $json_data1['TOTAL_SO'];
           $GRACE = $json_data1['GRACE'];
           $CHARGE = $json_data1['CHARGE'];
           $DISCOUN = $json_data1['DISCOUN'];

           $billto_ADDRESS1 = $json_data1['ADDRESS1'].$json_data1['ADDRESS2'];
           $billto_ADDRESS2 = $json_data1['ADDRESS2'];
           $billto_CITY = $json_data1['CITY'];
           $billto_COUNTRY = $json_data1['COUNTRY'];
           $billto_STATE = $json_data1['STATE'];
           $billto_ZIP=$json_data1['ZIP'];	
        
           $cid=$json_data1['ID'];

            $artostr =  $response;
            $e = $json_data1;
            $curr_date=date('Y-m-d H:i:s');
           
            if($AUTOID!='')
            {
                $_SESSION['po_by_customer']='';
                $_SESSION['ship_addr']='';

                $grand_total=$TOTAL_SO;
                $sql_main = $this->preview->insert_ebms_order_main($AUTOID,$INVOICE,$cid,$totalprice,$curr_date,$artostr);
                
                $sql_billing = $this->preview->insert_ebms_order_billing_details($AUTOID,$INVOICE,$cid,$C_NAME,$C_ADDRESS1,$C_CITY,$C_STATE,$C_COUNTRY,$C_ZIP,$SALESMAN,$SALESMAN_Field,$PO_NO,$SHIP_DATE,$SHIP_VIA,$TERMS,$TAX,$TOTAL_SO,$GRACE,$CHARGE,$DISCOUN,$curr_date,$billto_ADDRESS1,$billto_ADDRESS2,$billto_CITY,$billto_COUNTRY,$billto_STATE,$billto_ZIP);


                if(!empty($sql_main)){
                    $result_query= $this->preview->getproduct_cid($cid);
                    $child_item_count=$result_query->getNUmRows();
                    $result2=$result_query->getResultArray();
                    $sub_total=0;
                    $items_count=0;
                    if($child_item_count>0){
                        
                        foreach ($result2 as $row1)
                        {
                            $items_count++;
                            $rid = $row1['id'];
                            $num_disc_items=$this->preview->getproduct_cart_discount_items_count($rid);
                            $fetch_disc_items=$this->preview->getproduct_cart_discount_items($rid);

                            $product = $row1['product'];
                            $lprice = $row1['lprice'];

                            $description1 = $row1['description'];
                            $description=str_replace('"', "''", $description1);
                            $description=str_replace("''", "''", $description);

                            $sp_price = $row1['sp_price'];
                            $qty = $row1['qty'];
                            $price = $row1['price'];
                            $discount_name = $row1['discount_name'];
                            $discount = $row1['discount'];
                            $totalprice = $row1['totalprice'];
                            $currency = $row1['currency'];
                            $discount8weeks_status=$row1['discount8weeks_status'];
                            $discount_8weeks_amount = $row1['discount_8weeks_amount'];
                            $total_8weeksdiscount_amt = $row1['total_8weeksdiscount_amt'];

                            $lprice = $lprice;
                            $price =$price;
                            $totalprice = $totalprice;

                            $sub_total=$sub_total+$totalprice;

                            $sql_child = $this->preview->insert_ebms_order_child($AUTOID,$INVOICE,$cid,$product,$description,$lprice,$qty,$sp_price,$price,$discount_name,$discount,$totalprice,$currency,$discount8weeks_status,$discount_8weeks_amount,$total_8weeksdiscount_amt);
                            
                            $ebms_child_id=$sql_child;

                            $discount_sum=0;
                            $total_discount_price=0;
                            if($num_disc_items>0)
                                {
                                    foreach ($fetch_disc_items as $fetch_disc_item_row) {
                                        
                                        $product=$fetch_disc_item_row['product'];
                                        $discount_name=$fetch_disc_item_row['discount_name'];
                                        $discount=$fetch_disc_item_row['discount'];
                                        $discount_price=$fetch_disc_item_row['discount_price'];
                                        $total_discount_price=$fetch_disc_item_row['total_discount_price'];
                                        $discount_sum=$discount_sum+$total_discount_price;

                                        $sql_discount_items = $this->preview->insert_ebms_order_discount_items($ebms_child_id,$AUTOID,$INVOICE,$cid,$product,$discount_name,$discount,$discount_price,$total_discount_price);
                                    }
                                }
                        }
                    }
                }

                //deleting items in cart tbl

                $e = $AUTOID;
                $sqlq1 = $this->preview->delete_product_cid_preview($cid);

            }else{
                $e = 0;
            }

        }else
        {
            $e = 0;
        }

       
        if($INVOICE!='' && $e!=''){
            //sending mails
            //common headers for both admin and customer
            $email='no-reply@baumalight.com';
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
            $headers .= 'From: <'.$email.'>' . "\r\n";

            /******************/
            //composing mail to customer
            $to_mail_customer='sushma.n@acufore.com';
            $dealer_name = $_SESSION['E_EID'];
            $subject_customer="Order Placed Successfully - ".$dealer_name;
            
            $sub_total=$sub_total-$discount_sum;
            $sub_total=number_format($sub_total,2);
            
            $grand_total=round($grand_total);
            $grand_total=number_format($grand_total,2);
            $TAX=number_format($TAX,2);

            $mail_body_cust='';
            $mail_body_cust.="<div style='padding-top:8px;'></div>     
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
           <tr>
           <td align='center' style='background-color: #eeeeee;' bgcolor='#eeeeee'>
           
           <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
              
               <tr>
                   <td align='center' style='padding: 35px 35px 20px 35px; background-color: #ffffff;' bgcolor='#ffffff'>
                   <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                       <tr>
                           <td align='center' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 5px;'>
                           
                               
                               <h5 style='font-size: 22px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;'>
                                  Thank You For Your Order!
                               </h5>
                                <h6 style='font-size: 18px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;'>
                                   Order No: $INVOICE
                               </h6>
                           </td>
                       </tr>
                       
                         <tr>
                           <td align='left' style='padding-top: 20px;'>
                               <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                   <tr>
                                       <td width='75%' align='left' bgcolor='#eeeeee' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;'>
                                           Order Confirmation #
                                       </td>
                                       <td width='25%' align='left' bgcolor='#eeeeee' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;'>
                                          
                                       </td>
                                   </tr>
                                   <tr>
                                       <td width='75%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                           Purchased Item ($items_count)
                                       </td>
                                       <td width='25%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                           $ $sub_total
                                       </td>
                                   </tr>
                                  
                                   <tr>
                                       <td width='75%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;'>
                                       Tax
                                       </td>
                                       <td width='25%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;'>
                                           $ $TAX
                                       </td>
                                   </tr>
                               </table>
                           </td>
                       </tr>
                       
                        <tr>
                           <td align='left' style='padding-top: 20px;'>
                               <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                   <tr>
                                       <td width='75%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;'>
                                           TOTAL
                                       </td>
                                       <td width='25%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;'>
                                           $ $grand_total
                                       </td>
                                   </tr>
                               </table>
                           </td>
                       </tr>
                       
                       </table>
                   </td>
               </tr>
               
                <tr>
                   <td align='center' height='100%' valign='top' width='100%' style='padding: 0 35px 35px 35px; background-color: #ffffff;' bgcolor='#ffffff'>
                   <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:660px;'>
                       <tr>
                           <td align='left' valign='top' style='font-size:0;'>
                               <div style='display:inline-block; max-width:100%; min-width:240px; vertical-align:top; width:100%;'>
   
                                   <table align='left' border='0' cellpadding='0' cellspacing='0' width='100%' >
                                       <tr>
                                           <td align='left' valign='top' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;'>
                                               <p style='font-weight: 800;'>Billed Address</p>
                                               <p>$billto_ADDRESS1 ,<br>$billto_CITY ,<br>$billto_STATE, $billto_COUNTRY ,<br>$billto_ZIP</p>
                                           </td>
   
                                       </tr>
   
                                      
                                   </table>
                               </div>
                              
                           </td>
                       </tr>
                   </table>
                   </td>
               </tr>
               
                <tr>
                   <td align='center' style='padding: 15px; background-color: #000;' bgcolor='#000'>
                   <table align='center' border='0' cellpadding='0' cellspacing='0' width='100%' style='max-width:600px;'>
                       
                       <tr>
                           <td align='center' style='padding: 10px 0 10px 0;'>
                               <table border='0' cellspacing='0' cellpadding='0'>
                                   <tr>
                                   <td style='text-align:center'>
                                  
                                   </td>
                                   </tr>
                               </table>
                           </td>
                       </tr>
                   </table>
                   </td>
               </tr>
             
           </table>
            </td>
            </tr>
       </table>
         </div>
         </body></html>";

        $mail_customer=mail($to_mail_customer,$subject_customer,$mail_body_cust,$headers);

        /******************/
        //composing mail to Admin

        $to_mail_admin='sushma.n@acufore.com';
        //$to_mail_admin='order@baumalight.com';
        $dealer_name = $_SESSION['E_FULL_NAME'];
        $subject="Order Placed by - ".$dealer_name;
        $mail_body_admin='';
        $mail_body_admin.="<html></body><div></br></br>";
        $mail_body_admin.= "Hello Admin, <br/><br/> Dealer ".$dealer_name.", has placed an order and Invoice number is ".$INVOICE.", please check details in EBMS.";
        
        //$mss.="<div>$product_details</div>";
        $mail_body_admin.= "</body></html>";
        $mail_admin=mail($to_mail_admin,$subject,$mail_body_admin,$headers);

        }

        echo json_encode($e);   
            }
    }
}