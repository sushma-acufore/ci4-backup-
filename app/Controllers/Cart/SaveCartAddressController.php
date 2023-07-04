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
        $response=0; 
        if(isset($_POST)) 
        {
            $dealer_id = $_SESSION['E_EID'];
            //$dealer_name = $_SESSION['E_EID'];

            $cid = $_POST['cid'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $po_number = $_POST['new_addr_po_number'];
            $phone_no = $_POST['phone_no'];
            $email = $_POST['email'];
            $company_name = $_POST['company_name'];
            $address_1 = $_POST['address_1'];
            $address_2 = $_POST['address_2'];
            $city = $_POST['city'];
            $state = $_POST['state'];
            $country = $_POST['country'];
            $pin_code = $_POST['pin_code'];
            $note = $_POST['note'];

            $result = $this->savecartaddress->insert_shipping_address_request($cid,$first_name,$last_name,$po_number,$phone_no,$email,$company_name,$address_1,$address_2,$city,$state,$country,$pin_code,$note);

    if($result==1){
        $new_msg_body="     
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
                               Requesting to add new Shipping Address
                            </h5>
                             <h6 style='font-size: 18px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;'>
                               Dealer ID : $dealer_id
                            </h6>
                        </td>
                    </tr>
                    
                      <tr>
                        <td align='left' style='padding-top: 20px;'>
                            <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                <tr>
                                    <td width='50%' align='left' bgcolor='#eeeeee' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;'>
                                        New Shipping Address
                                    </td>
                                    <td width='50%' align='left' bgcolor='#eeeeee' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;'>
                                    </td>
                                </tr>
                                <tr>
                                    <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                    First Name 
                                    </td>
                                    <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                    $first_name
                                    </td>
                                </tr>

                                <tr>
                                    <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                    Last Name 
                                    </td>
                                    <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                    $last_name
                                    </td>
                                </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                PO Number 
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $po_number
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Customer ID 
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $dealer_id
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Company Name 
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $company_name
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Phone Number
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $phone_no
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Email ID
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $email
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Address
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $address_1
                                </td>
                            </tr>
                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Second Address
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $address_2
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                City
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $city
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                State
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $state
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Country
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $country
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Pincode
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $pin_code
                                </td>
                            </tr>

                            <tr>
                                <td width='40%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                Note
                                </td>
                                <td width='60%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                $note
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
      ";

                $email='no-reply@baumalight.com';
                //$to='order@baumalight.com';
                $to='sushma.n@acufore.com';
                $subject="Request to add New Shipping Address from dealer - ".$dealer_id;
                //mail headers
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";// More headers
                $headers .= 'From: <'.$email.'>' . "\r\n";
                 
                //mail body
                $ms='';
                $ms.="<html></body><div>";
                $ms.="<div style='padding-top:10px;'></div>
                <div style='padding-top:10px;'>$new_msg_body</div><br/>
                </div>
                </body></html>";

                $mail=mail($to,$subject,$ms,$headers);
                if($mail){
                  $response=1;
                }else{
                  $response=2;
                }

            }else{
                $response=0; 
            }


            echo $response;
        }
    }

}