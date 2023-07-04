<?php 
namespace App\Controllers\StockRegister;
use App\Models\Ordermodel;
use App\Models\Moreinfo;
use CodeIgniter\Controller;

class StockRegisterController extends BaseController
{
	protected $ordermodel;
    public function __construct()
    {
        \Config\Services::session();
        $this->ordermodel = new Ordermodel();
        $this->moreinfo = new Moreinfo();
    }

    public function stock_dealer()
    {
      echo view('onlineorder/content/stock_dealer_register/stock_dealer_register');
    }

    public function save_stock_dealer()
    {
      if(isset($_POST))
      {
        $firstname= $_POST['firstname'];
        $part_number= $_POST['part_number'];
        $cid= $_POST['cid'];
        $intended_stocking_quantity= $_POST['intended_stocking_quantity'];
        $email= $_POST['email'];

        $status=0;
        $msg="";
        $headers="";
        $ms="";

        $query = $this->ordermodel->insert_stock_register($part_number,$firstname,$cid,$email,$intended_stocking_quantity);
        
        $msg="Thanks message";
        $html = "<table style='width:80%'>";
        $fields = array(
            'Name of the Requester' => $firstname,
            'Email ID' => $email,
            'Part Number' => $part_number,
            'Intended Stocking Quantity' => $intended_stocking_quantity
        );

        foreach ($fields as $label => $value) {
          if ($value) {
            $html .= "<tr style='border:1px solid gray;'><td style='border:1px solid gray;border-collapse:collapse;padding:5px;font-weight:bold;width:20%'>$label </td><td style='border:1px solid gray;border-collapse:collapse;padding:5px;'>$value</td></tr>";
          }
        }
        $html .= "</table>";
        if($query)
        {  
          $to='akshay.j@acufore.com';
          // $to='menno@baumalight.com';
          //$to='no-reply@baumalight.com';
          $dealer_name = $_SESSION['E_FULL_NAME'];
          $subject="Request for Stock Dealer - ".$dealer_name;
          
          //   $headers .= "MIME-Version: 1.0"."\r\n";
          //   $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
          //   $headers .= 'From:Baumalight | Register as stock dealer request'."\r\n";

          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";// More headers
          $headers .= 'From: <'.$email.'>' . "\r\n";
      
          // $ms.="<html></body><div></br></br>";  
          // $ms.= "Requesting to upgrade as Stock Dealer, please find the details below.<br><br>";   
          // $ms.="<div style='padding-top:8px;'></div>     
          // <div style='padding-top:10px;'>$html</div>      
          // </div>
          // </body></html>";

          $ms.="<html></body><div></br></br>";  
      //$ms.= "Requesting to upgrade as Stock Dealer, please find the details below.<br><br>";   
      $ms.="<div style='padding-top:8px;'></div>     
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
                                $dealer_name is requesting to become a Stock Dealer!
                            </h5>
                        </td>
                    </tr>
                    
                    <tr>
                        <td align='left' style='padding-top: 20px;'>
                            <table cellspacing='0' cellpadding='0' border='0' width='100%'>
                                <tr>
                                    <td width='75%' align='left' bgcolor='#eeeeee' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;'>
                                        Product Info
                                    </td>
                                    <td width='25%' align='left' bgcolor='#eeeeee' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;'>
                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td width='75%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                        Product 
                                    </td>
                                    <td width='25%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                        <b>$part_number</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td width='75%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                        Intended Qty. 
                                    </td>
                                    <td width='25%' align='left' style='font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;'>
                                        <b>$intended_stocking_quantity</b>
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
      </div>
      </body></html>";

          $mail=mail($to,$subject,$ms,$headers);
          if($mail){
            $res=1;
          }else{
            $res=0;
          }      
        }
        else
        {
          $res=0;
        }
        echo json_encode($res); 
      }
    }
}