<?php 
namespace App\Controllers\Cart;
use App\Models\Cart\ShippingAddress;
use CodeIgniter\Controller;

class ShippingAddressController extends BaseController
{
	protected $Moreinfo;
  public function __construct()
  {
    \Config\Services::session();
    $this->shippingaddress = new ShippingAddress();
  }

  public function get_ship_address()
  {
      // $cid = 'TEST2';
      $cid = $_POST['cid'];
      $count=0;
      $count = $this->shippingaddress->getproduct_cart_countAll($cid);
      if($count>0)
      {
          $e='';
          $e .=' <div class="col-md-12" id="shipping-address">
                          <p class="shipp-address-leb">Shipping Address :</p>
                          <select class="form-select" style="border-radius: 27px;" id="ship_to_address" onchange="add_shipping_address(this.value)">
                          <option value="0" >-------------Select address-----------</option>
                          <option disabled style="font-weight:bold">&nbsp;SHIP ID &nbsp;&nbsp; | &nbsp;CITY&nbsp;&nbsp; | &nbsp;STATE &nbsp;&nbsp;</option>';
          
          $result5 = $this->shippingaddress->getARSHIP($cid);
          while($dt = odbc_fetch_array($result5))
          {
              $ship_id=$dt['SHIPTOID'];
              $fetch_more = $this->shippingaddress->getARCUST($ship_id);
              $city=$fetch_more['CITY'];
              $state=$fetch_more['STATE'];

              $e .='<option value="'.$dt['ID']."|".$dt['SHIPTOID'].'">'.$dt['SHIPTOID'].' | '.$city.' | '.$state.'</option>';
          }
          $e .='</select>
                          <span><a class="request-new-ship-address" id="createAddress" onclick="createNewAddress()">Request
                              Baumalight to add new shipping address (Click here).</a></span>
                      </div>';
      }else{
          $e='';
      }
      echo $e;
  }

  public function get_ship_address_info()
  {
      $cid = $_POST['cid'];
      $ship_and_cust_id = trim($_POST['a']);

      $e='';

      if(empty($ship_and_cust_id) || $ship_and_cust_id==0)
      {
      }
      else{
          $ship_and_cust_id = explode('|', $ship_and_cust_id);
          $cid_id = $ship_and_cust_id[0];
          $ship_id = $ship_and_cust_id[1];
          $_SESSION['ship_id'] = $ship_id;
          $result5 = $this->shippingaddress->getARCUST_info($ship_id);
          while($dt = odbc_fetch_array($result5))
          {
             $e .= "<div class='col-md-12'>
                          <div class='table-display-cust-details'>
                              <table style='width:100%'>
                                  <tbody>
                                      <tr>
                                          <td>First Name :</td>
                                          <td>".$dt['F_NAME']."</td>
                                      </tr>
                                      <tr>
                                          <td>Last Name :</td>
                                          <td>".$dt['L_NAME']."</td>
                                      </tr>
                                      <tr>
                                          <td>Phone number :</td>
                                          <td>".$dt['CONTACT_1']."</td>
                                      </tr>
                                      <tr>
                                          <td>Email :</td>
                                          <td>".$dt['CONTACT_3']."</td>
                                      </tr>
                                      <tr>
                                          <td>Address 1:</td>
                                          <td>".$dt['ADDRESS1']."</td>
                                      </tr>
                                      <tr>
                                          <td>Address 2 (optional):</td>
                                          <td>".$dt['ADDRESS2']."</td>
                                      </tr>
                                      <tr>
                                          <td>City :</td>
                                          <td>".$dt['CITY']."</td>
                                      </tr>
                                      <tr>
                                          <td>State :</td>
                                          <td>".$dt['STATE']."</td>
                                      </tr>
                                      <tr>
                                          <td>Country :</td>
                                          <td>".$dt['COUNTRY']."</td>
                                      </tr>
                                      <tr>
                                          <td>Pincode :</td>
                                          <td>".$dt['ZIP']."</td>
                                      </tr>
                                  </tbody>
                              </table>
                          </div>
                      </div>";
          }
      }

      echo $e;
  }




}