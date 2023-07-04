<?php 
namespace App\Controllers\Cart;
use App\Models\Cart\SaveCartAddress;
use CodeIgniter\Controller;

class SaveCartAddressController extends BaseController
{
	protected $Moreinfo;
  public function __construct()
  {
    \Config\Services::session();
    $this->savecartaddress = new SaveCartAddress();
  }

  public function save_cart_address()
  {
      $flag=0;
      if(isset($_POST))
      {
          $cid = $_POST['cid'];
          $first_name = $_POST['first_name'];
          $last_name = $_POST['last_name'];
          $phone_no = $_POST['phone_no'];
          $email = $_POST['email'];
          $company_name = $_POST['company_name'];
          $address1 = $_POST['address_1'];
          $address_2 = $_POST['address_2'];
          $city = $_POST['city'];
          $state = $_POST['state'];
          $country = $_POST['country'];
          $pin_code = $_POST['pin_code'];

          $result = $this->savecartaddress->insert_shipping_address_request($cid,$first_name,$last_name,$phone_no,$email,$company_name,$address1,$address_2,$city,$state,$country,$pin_code);
          if ($result) 
          {
              $flag=1;
          } 
          else 
          {
              $flag=0;
          }

          $status=0;
          $msg="";
          $headers="";
          $ms="";
          if($flag==1)
          {
          $e1 = '';
          
          $result1 = $this->savecartaddress->getproduct_cart($cid);
          if(!empty($result1))
          {
              $e1 .='<table class="table table-border">
                                <thead>
                                      <tr class="table-dark tr-head">
                                          <th>Part #</th>
                                          <th>Description</th>
                                          <th>Stock</th>
                                          <th>Quantity</th>
                                          <th>List Price</th>
                                          <th>Special&nbsp;Price</th>
                                          <th>Stock&nbsp;Dealer&nbsp;Price</th>
                                          <th>Total&nbsp;Price&nbsp;&nbsp;</th>
                                      </tr>
                                  </thead>
                                  <tbody>';
              foreach ($result1 as $row1) 
              {
                  $rid = $row1['id'];
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
                  $discount8weeks_status = $row1['discount8weeks_status'];
                  $discount = $row1['discount'];
                  $totalprice = $row1['totalprice'];
                  $currency = $row1['currency'];

                  $sp_price = number_format($sp_price,2);
                  $lprice = number_format($lprice,2);
                  $price = number_format($price,2);
                  $totalprice = number_format($totalprice,2);

                  $discount_8weeks_amount = $row1['discount_8weeks_amount'];
                  $discount_8weeks_amount = number_format($discount_8weeks_amount,2);
                  
                  $total_8weeksdiscount_amt = $row1['total_8weeksdiscount_amt'];
                  $total_8weeksdiscount_amt = number_format($total_8weeksdiscount_amt,2);

                  $row_avl = $this->savecartaddress->geteagle_available_stock($product);
                  $avl_stock ='';
                  $serial_no_count = 0;
                  if(!empty($row_avl))
                  {
                      $avl_stock=$row_avl['S_AVAIL'];
                  }

                  $existing_qty=$row1['qty'];

                  $e1 .='<tr class="table-default">
                          <td>'.$product.'</td>
                          <td>'.$description.'</td>
                          <td>'.$avl_stock.'</td>
                          <td>
                              <div>
                                  <h2 id="search-table-counting" style="font-size: 14px;font-family: \'Inter\',sans-serif;">'.$qty.'</h2>
                              </div>
                          </td>
                          <td>$'.$lprice.'</td>
                          <td>$'.$sp_price.'</td>';
                          
                          // stock discount
                          if($discount>0)
                          {
                              $e1 .= '<td>$'.$totalprice.'</td>';
                              $e1 .= '<td>$'.$totalprice.'</td>';
                          }else
                          {
                              $e1 .= '<td> - </td>';
                              $e1 .= '<td>$'.$price.'</td>';
                          }

                          $e1 .='</tr>'; 
                      if(!empty($discount_name) || $discount8weeks_status==1)
                      {
                           $e1 .='<tr class="table-default">
                           <td>'.$discount_name.'</td>
                           <td>'.$discount_name.'</td>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td></td>
                           ';
                           $e1 .= '<td>-&nbsp;$'.$total_8weeksdiscount_amt.'</td>';
                           $e1 .='<td></td>
                       </tr>'; 
                      }      
              }

              $e1 .='</tbody>
                      <tfoot>';
              $totallprice = 0;
              $totalspecialprice = 0;
              $totalprice=0;
              $price = 0;
              $totaldisc_price=0;



              $row_avl = $this->savecartaddress->getproduct_cart($cid);
              if(!empty($result1))
              {   
                  foreach ($result1 as $row1)
                  {
                      $totallprice = $totallprice + $row1['lprice'];
                      $totalspecialprice =  $totalspecialprice + $row1['sp_price'];
                      $price =  $price + $row1['price'];
                      $totalprice = $totalprice + $row1['totalprice'];
                      
                      $totaldisc_price = $totaldisc_price + $row1['total_8weeksdiscount_amt'];
                  }
                  $totallprice = number_format($totallprice,2);
                  $totalspecialprice = number_format($totalspecialprice,2);
                  $price = number_format($price,2);
                  
                  $totalprice =$totalprice-$totaldisc_price;
                  $totalprice = number_format($totalprice,2);

                  $e1 .=' <tr>
                              <td colspan="7" style="text-align: end;font-weight: bolder;">Total</td>
                              <td><button class="btn btn-warning yellow-btns-cart">$'.$totalprice.'</button></td>
                              <td></td>
                          </tr>';
              }  
              $e1 .=' </tfoot>
                  </table>';
          }
            $new_address_info="<table style='border:1px solid gray'>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>First Name </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$first_name</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Second Name </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$last_name</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Customer ID </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$cid</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Company Name </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$company_name</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Phone Number </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$phone_no</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Email ID </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$email</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Address </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$address1</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Second Address </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$address_2</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>City </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$city</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>State </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$state</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Country </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$country</td></tr>
            <tr><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold'>Pincode </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$pin_code</td></tr>
            </table>";
                $to='menno@baumalight.com';
                
                
                $dealer_name = $_SESSION['E_FULL_NAME'];
                $subject="Request to add New Shipping Address from dealer - ".$dealer_name;
                
                
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";// More headers
                $headers .= 'From: <'.$email.'>' . "\r\n";
                  
                $ms.="<html></body><div></br></br>";
                $ms.= "Requesting to add new shipping address, please find the details below.</br>";
                
                 $ms.="<div style='padding-top:8px;'></div>
                <div style='padding-top:10px;'>New Shipping Address - $cid:</div><br/>
                <div style='padding-top:10px;'>$new_address_info</div><br/>
                </div>
                </body></html>";

                $mail=mail($to,$subject,$ms,$headers);
                if($mail)
                {
                      $response=1;
                }
                else
                {
                      $response=2;
                }

              }else{
                  $response=0; 
              } 
                echo json_encode($response);
      }
  }




}