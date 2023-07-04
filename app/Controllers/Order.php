<?php 
namespace App\Controllers;
use App\Models\Ordermodel;
use App\Models\Moreinfo;
use CodeIgniter\Controller;

class Order extends BaseController
{
    protected $ordermodel;
    public function __construct()
    {
      \Config\Services::session();
      $this->ordermodel = new Ordermodel();
      $this->moreinfo = new Moreinfo();
    }
    public function index()
    {
      // echo view("order/index");
      echo view("onlineorder/content/search/search");
    }

    public function ebms_customer_help()
    {
      echo view("onlineorder/content/help/ebms_customer_help");
    }

    public function test()
    {
      if(1==1)
      {
        $firstname= 'TEST';
        $part_number= 'TRL620D';
        $cid= 'TEST2';
        $intended_stocking_quantity= '3';
        $email= 'akshay.j@acufore.com';

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

          $headers = "MIME-Version: 1.0" . "\r\n";
          $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";// More headers
          $headers .= 'From: <'.$email.'>' . "\r\n";
      
          $ms.="<html></body><div></br></br>";  
          $ms.= "Requesting to upgrade as Stock Dealer, please find the details below.<br><br>";   
          $ms.="<div style='padding-top:8px;'></div>     
          <div style='padding-top:10px;'>$html</div>      
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
?>