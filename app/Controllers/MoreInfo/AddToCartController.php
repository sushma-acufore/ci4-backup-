<?php 
namespace App\Controllers\Moreinfo;
use App\Models\MoreInfo\AddToCart;
use CodeIgniter\Controller;

class AddToCartController extends BaseController
{
    protected $Moreinfo;
    public function __construct()
    {
        \Config\Services::session();
        $this->addtocart = new AddToCart();
    }

    public function add_to_cart()
    {
        $pno = trim($_POST['pno']);
        $curl = strtolower($_POST['curl']);
        $cntry = strtolower($_POST['cntry']);
        $cid = $_POST['cid'];
        $stk_discount = $_POST['stk_discount'];
        $stock_dealer_discount = $_POST['stk_discount'];
        $prod_8weeks = $_POST['prod_8weeks'];
        $mstatus = $_POST['mstatus'];
        $qty = $_POST['qty'];

        $pno = trim($pno);
        $e23 = 0;
        $e='';
        $status2='';
        $is_stock_dealer=0;
        // $is_stock_dealer=$_POST['apply_discount'];

        if($mstatus==1)
        {
            $status2='Active';    
        }

        //checking available stock
        $row_avl = $this->addtocart->checking_avail_stock($pno);

        $avl_stock ='';
        if(!empty($row_avl))
        {
            $avl_stock=$row_avl['S_AVAIL'];
        }

        $row = $this->addtocart->get_gp_report($pno);
        if(!empty($row))
        {
            $Part_Number = $row['Part_Number'];
            $Description = $row['Description'];
            $C60_price_level_price = $row['C60_price_level_price'];
            $U60_price_level_price = $row['U60_price_level_price'];
            $lprice = '';
            $price_level = 'C60';
            if($curl == '' AND $cntry=="US") 
            {
                $lprice = $U60_price_level_price;
                $price_level = 'U60';
            }
            else if($curl == '' AND $cntry !="US") 
            {
                $lprice = $C60_price_level_price;
                $price_level = 'C60';
            }
            else if($curl == "usa" or $curl=="usd" or $curl=="USD") 
            {
                $lprice = $U60_price_level_price;
                $price_level = 'U60';
            }
            else if($curl == "cad" or $curl == "CAD") 
            {
                $lprice = $C60_price_level_price;
                $price_level = 'C60';
            }
            
                    //fetching special price from API
                    $curlc = curl_init();
                    curl_setopt_array($curlc, array(
                      CURLOPT_URL => 'https://ECC842362022020802.servicebus.windows.net/MyEbms/MTB/OData/INVENTRY(ID=\''.$Part_Number.'\')/Model.Entities.GetPrice',
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => '',
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => 'POST',
                      CURLOPT_POSTFIELDS =>'{
                        "PriceLevel":"'.$price_level.'",
                        "Uom":"",
                        "CustomerId":"'.$cid.'",
                        "Quantity":1
                    }
                    ',
                      CURLOPT_HTTPHEADER => array(
                        'Content-Type:  application/json',
                        'Authorization: Basic QVBJQUNDRVNTOkFQSWFjY2Vzc0w='
                      ),
                    ));

                    $response = curl_exec($curlc);
                    $json_data1 = json_decode($response,true);
                    curl_close($curlc);

                    //var_dump($json_data1);     

                    $sp_price = (float)$lprice;
                    if(isset($json_data1['Price']))
                    {
                        $sp_price = $json_data1['Price'];
                    }


            $num_rows1 = $this->addtocart->ProductCart($cid,$Part_Number);
            if($num_rows1>0)
            {
                $c_error = 0;
                $cc_curl = $curl;
                $cc_curl = strtolower($cc_curl);
                $num_rows12 = $this->addtocart->check_product_by_cid($cid);
                if($num_rows12>0)
                {
                    foreach($num_rows12 as $row12) 
                    {
                        $currency12 = $row12['currency'];
                        $currency12 = strtolower($currency12);
                        $currency12 = trim($currency12);
                        // $e23 .= $cc_curl."!=".$currency12;
                        if($cc_curl!=$currency12)
                        {
                            $c_error = 1;
                        }
                    }
                }
                if($c_error==0)
                {
                    $row1 = $num_rows1;
                    $existing_qty = (int)$row1['qty'];
                    $row_id=$row1['id'];
                    $qty = (int)$row1['qty'] + (int)$qty;
                    
                    $price = (int)$qty * (float)$sp_price;
                    
                    if($row1['discount']==0)
                    {
                        $discount = 0;
                        $totalprice = (float)$price;    
                    }
                    else 
                    {
                        $discount = (float)$price * $row1['discount'];
                        $discount = (float)$discount / 100;
                        $totalprice = (float)$price;   
                        
                        $total_discount_price=(float)$discount;
                        $disc_per_item=(float)$total_discount_price/$qty;

                    }
                    
                    $sqlq1 = $this->addtocart->upate_product_cart($row_id,$lprice,$sp_price,$qty,$price,$totalprice,$curl);

                    $sqlq2 = $this->addtocart->upate_product_discount_items($row_id,
                    $disc_per_item,$total_discount_price);

                    $e23 = 1;
                }else
                {
                    $e23 = 3;
                }
            }
            else
            {
                $c_error = 0;
                $cc_curl = $curl;
                $cc_curl = strtolower($cc_curl);
                $num_rows12 = $this->addtocart->check_product_by_cid($cid);
                if($num_rows12>0)
                {
                    foreach($num_rows12 as $row12)
                    {
                        $currency12 = $row12['currency'];
                        $currency12 = strtolower($currency12);
                        $currency12 = trim($currency12);
                        // $e23 .= $cc_curl."!=".$currency12;
                        if($cc_curl!=$currency12)
                        {
                            $c_error = 1;
                        }
                    }
                }
                if($c_error==0)
                {
                    $price = (int)$qty * (float)$sp_price;
                    $totalprice = $price;

                        if($status2=="Active")
                        {
                            $discount_t=0;
                            $discount_name_fin='';
                            $TYPE=0;
                            $discount_t = (float)$stk_discount;
                           
                           if($discount_t>0 && $is_stock_dealer==1){
                                $dic_name="DISCOUNT ".$discount_t." AND 8 PERCENT";
                                $fetch_final_discount = $this->addtocart->check_discount_on_odbc_index_1($dic_name);
                                $num_rows_disc= odbc_num_rows($fetch_final_discount);
                                if($num_rows_disc>0){
                                    $final_disc = odbc_fetch_array($fetch_final_discount);
                                    $discount_name_fin=$final_disc['ID'];
                                    $TYPE=$final_disc['TYPE'];
                                }else if($num_rows_disc==0){                       
                                    $e23 = 4;
                                }
                                else{
                                    $e23 = 4;
                                }
                            }else{
                                $e23 = 4;
                            }

                          
                            if($e23!=4){
                                if($discount_t!=0)
                                {
                                    $totalprice = (float)$price; 
                                    $eight_weeks_per_total=(float)$price * $TYPE;
                                    $eight_weeks_per_total=(float)$eight_weeks_per_total / 100;
                                    $discount_8weeks_amount =(float)$eight_weeks_per_total;    
                                    $disc_per_item=$discount_8weeks_amount/$qty;
                                    
                                    $sqlq = $this->addtocart->insert_product_cart_on_index_1($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount);
                                }else
                                {
                                    $dic_name_8="DISCOUNT 8 PERCENT";
                                    $fetch_final_discount_8 = $this->addtocart->check_discount_on_odbc_index_2($dic_name_8);
                                    $final_disc_8 = odbc_fetch_array($fetch_final_discount_8);
                                    $discount_name_fin=$final_disc_8['ID'];
                                    $TYPE=$final_disc_8['TYPE'];
                                    
                                    $totalprice = (float)$price; 
                                    $eight_weeks_per_total=(float)$price * $TYPE;
                                    $eight_weeks_per_total=(float)$eight_weeks_per_total / 100;
                                    $discount_8weeks_amount =(float)$eight_weeks_per_total;      
                                    $disc_per_item=$discount_8weeks_amount/$qty;

                                    $sqlq = $this->addtocart->insert_product_cart_on_index_2($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$is_stock_dealer,$stock_dealer_discount);
                                
                                }
                                
                                $e23 = 2;
                                
                                $cart_id=$sqlq;
            
                                $sqlq_items = $this->addtocart->insert_product_cart_discount_items($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$discount_8weeks_amount); 
                            }else{

                                if($is_stock_dealer==0){
                                
                                $dic_name_8="DISCOUNT 8 PERCENT";
                                $fetch_final_discount_8 = $this->addtocart->more_info_odbc_discount_2($dic_name_8);
                                $final_disc_8 = odbc_fetch_array($fetch_final_discount_8);
                                $discount_name_fin=$final_disc_8['ID'];
                                $TYPE=$final_disc_8['TYPE'];

                                $totalprice = (float)$price; 
                                $eight_weeks_per_total=(float)$price * $TYPE;
                                $eight_weeks_per_total=(float)$eight_weeks_per_total / 100;
                                $discount_8weeks_amount =(float)$eight_weeks_per_total;   
                                $disc_per_item=$discount_8weeks_amount/$qty;

                                $sqlq = $this->addtocart->insert_product_cart_on_index_3($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount);
                               
                                $cart_id=$sqlq;
            
                                $sqlq_items = $this->addtocart->insert_product_cart_discount_items_2($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount);
                                $e23 = 2;
                                }
                                else{
                                    $e23 = 4;
                                }
                            }
                            
                        }else
                        { 
                            $discount_t = (float)$stk_discount;
                            if($discount_t>0 && $is_stock_dealer==1)
                            {
                                $dic_name_ind="DISCOUNT ".$discount_t." PERCENT";
                                $fetch_final_discount_ind=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name_ind'");
                                $num_rows_disc_ind= odbc_num_rows($fetch_final_discount_ind);

                                if($num_rows_disc_ind>0){
                                    $final_disc_ind = odbc_fetch_array($fetch_final_discount_ind);
                                    $discount_name_fin=$final_disc_ind['ID'];
                                    $TYPE=$final_disc_ind['TYPE'];  
                                
                                    $discount = (float)$price * $discount_t;
                                    $discount = (float)$discount / 100;
                                    $disc_per_item=$discount/$qty;

                                    $totalprice = (float)$price;    
                                    
                                    $sqlq = $this->addtocart->insert_product_cart_on_index_4($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$is_stock_dealer,$stock_dealer_discount);

                                    $cart_id=$sqlq;

                                    $sqlq_items = $this->addtocart->insert_product_cart_discount_items_3($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount);
                                    $e23 = 2;
                                }
                                else{
                                    $e23 = 4;
                                }

                            }else{

                                $sqlq = $this->addtocart->insert_product_cart_on_index_5($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$mstatus,$is_stock_dealer,$stock_dealer_discount);
                            }

                        }
                        echo $sqlq;

                }else
                {
                    $e23 = 3;
                }
                
            }
          }
          echo $e23;
    }     





}