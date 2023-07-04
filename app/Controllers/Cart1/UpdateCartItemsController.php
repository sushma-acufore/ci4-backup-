<?php 
namespace App\Controllers\Cart;
// use App\Models\Cart\UpdateCartItems;
use CodeIgniter\Controller;

class UpdateCartItemsController extends BaseController
{
	protected $Moreinfo;
	public function __construct()
	{
    \Config\Services::session();
    $this->update_cart_items = new UpdateCartItems();
	}

	public function updatecartitems()
  {
      $in_value = $_POST['in_value'];
      $rid = $_POST['rid'];
      $updt_qty = $_POST['updt_qty'];
      $cid = $_SESSION['user']['ebms_id'];
      $result12 = $this->update_cart_items->getproduct_by_rid($rid);
      if(!empty($result12))
      {
          foreach ($result12 as $row) 
          {
              $Part_Number=$pno=$row['product'];
              $curl=$row['currency'];
              //fetching list price and price level
              $result = $this->update_cart_items->getgp_report($pno);             
              if(!empty($result))
              {
                  $row1=$result;
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
                  

                  $result = $this->update_cart_items->update_product_cart($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid);
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
                      
                      $result = $this->update_cart_items->update_product_cart1($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid);
                  }
              }
              else if($in_value==3)
              {

                  $qty = $updt_qty;
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
                  $result = $this->update_cart_items->update_product_cart2($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid);
              }
          }
      }
  }

}