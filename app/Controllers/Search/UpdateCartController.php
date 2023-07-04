<?php 
namespace App\Controllers\Search;
use App\Models\Search\UpdateCart;
use CodeIgniter\Controller;

class UpdateCartController extends BaseController
{
	protected $ordermodel;
    public function __construct()
    {
        \Config\Services::session();
        $this->updatecart = new UpdateCart();
    }

    public function update_index_cart()
    {
        $in_value = $_POST['in_value'];
        $rid = $_POST['rid'];
        $updt_qty = $_POST['updt_qty'];
        $cid = $_SESSION['user']['ebms_id'];

        $num_rows12 = $this->updatecart->update_index_cart_check_cid($rid);

        if (!empty($num_rows12)) {
            
            foreach($num_rows12 as $row)
            {
                $Part_Number=$pno=$row['product'];
                $curl=$row['currency'];
                //fetching list price and price level
                $row1 = $this->updatecart->fetch_list_price($pno);
                if (!empty($row1))
                {

                    $Part_Number = $row1['Part_Number'];
                    $Description = $row1['Description'];
                    $C60_price_level_price = $row1['C60_price_level_price'];
                    $U60_price_level_price = $row1['U60_price_level_price'];
                    $lprice = '';
                    $price_level = 'C60';

                    if($curl == "usa" or $curl=="usd" or $curl=="USD") 
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

                    // var_dump($json_data1); 

                    $sp_price = (float)$lprice;

                    if(isset($json_data1['Price']))
                    {
                        $sp_price = $json_data1['Price'];
                    }

                    //checking for stock dealer or not and discount from SQL SERVER
                    // $qry5 = "SELECT DISCOUNT,EP_DISC FROM [ARCUSTSTK] 
                    // INNER JOIN [INVENTRY] ON [ARCUSTSTK].TREE_PATH = [INVENTRY].TREE_PATH 
                    // WHERE [ARCUSTSTK].CUST_ID = '".$cid."'
                    // AND [INVENTRY].ID='".$pno."';";

                    // $is_stk_dealer=0;
                    // $result5 = odbc_exec($conn_odbc,$qry5);
                    // while($dt5 = odbc_fetch_array($result5))
                    // {
                    //     //$stock_discount = (float)$dt5['DISCOUNT'];
                    //     $is_stk_dealer = $dt5['EP_DISC'];
                    // }

                    $in_value = trim($in_value);
                    if($in_value==2)
                    {
                        $qty = (int)$row['qty'] + 1;
                        $price = (int)$qty * (float)$sp_price;

                        if($row['discount']<=0)
                        {
                            $discount = 0;
                            $totalprice = (float)$price;    
                        }else
                        {
                            $discount = (float)$price * $row['discount'];
                            $discount = (float)$discount / 100;
                            $totalprice = (float)$price - (float)$discount;    
                        }
                        $total_8weeksdiscount_amt=0;
                        if($row['discount_name']!=null or $row['discount_name']!=''){
                            $total_8weeksdiscount_amt=$row['discount_8weeks_amount']*$qty;
                            $total_8weeksdiscount_amt = (float)$total_8weeksdiscount_amt; 
                        }else{
                            $total_8weeksdiscount_amt=0;
                        }

                        $sqlq1 = $this->updatecart->update_product_cart_index($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid);
                    }
                    elseif($in_value==1) 
                    {
                        $qty = (int)$row['qty'] - 1;

                        if($qty>0)
                        {
                            $price = (int)$qty * (float)$sp_price;
                            if($row['discount']<=0)
                            {
                                $discount = 0;
                                $totalprice = (float)$price;    
                            }else
                            {
                                $discount = (float)$price * $row['discount'];
                                $discount = (float)$discount / 100;
                                $totalprice = (float)$price - (float)$discount;    
                            }

                            $total_8weeksdiscount_amt=0;
                            if($row['discount_name']!=null or $row['discount_name']!=''){
                                $total_8weeksdiscount_amt=$row['discount_8weeks_amount']*$qty;
                                $total_8weeksdiscount_amt = (float)$total_8weeksdiscount_amt; 
                            }else{
                                $total_8weeksdiscount_amt=0;
                            }

                            $sqlq1 = $this->updatecart->update_product_cart_index($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid);
                        }
                    }
                    elseif($in_value==3) 
                    {
                        $qty = $updt_qty;
                        if($qty>0)
                        {
                            $price = (int)$qty * (float)$sp_price;
                            if($row['discount']<=0)
                            {
                                $discount = 0;
                                $totalprice = (float)$price;    
                            }else
                            {
                                $discount = (float)$price * $row['discount'];
                                $discount = (float)$discount / 100;
                                $totalprice = (float)$price - (float)$discount;    
                            }

                            $total_8weeksdiscount_amt=0;
                            if($row['discount_name']!=null or $row['discount_name']!=''){
                                $total_8weeksdiscount_amt=$row['discount_8weeks_amount']*$qty;
                                $total_8weeksdiscount_amt = (float)$total_8weeksdiscount_amt; 
                            }else{
                                $total_8weeksdiscount_amt=0;
                            }

                            $sqlq1 = $this->updatecart->update_product_cart_index($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid);
                        }
                    }
                }
            }
        }
    }


}