<?php 
namespace App\Controllers\Cart;
use App\Models\Ordermodel;
use App\Models\Moreinfo;
use CodeIgniter\Controller;

class SetSessionPoController extends BaseController
{
	protected $Moreinfo;
  public function __construct()
  {
    \Config\Services::session();
    $this->ordermodel = new Ordermodel();
    $this->moreinfo = new Moreinfo();
  }

  public function set_session_po()
  {

      /*if($_POST['po_by_customer'])
      {
          $po_by_customer= $_POST['po_by_customer'];
          //$po_by_customer= 'E003786';
          //https://ECC842362022020802.servicebus.windows.net/myebms/MTB/odata/ARINV?$filter=PO_NO eq 'E003786'

          //checking po number exists or not
          $user_name = 'APIACCESS';
          $password = 'APIaccessL';
          $ch1 = curl_init();
          curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch1, CURLOPT_TIMEOUT, 100);
          curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
          $api_request_url = 'https://ECC842362022020802.servicebus.windows.net/myebms/MTB/odata/ARINV?$filter=PO_NO%20eq%20\''.$po_by_customer.'\'';
          curl_setopt($ch1, CURLOPT_URL, $api_request_url);
          curl_setopt($ch1, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
          curl_setopt($ch1, CURLOPT_USERPWD, "$user_name:$password");

          $resp1 = curl_exec($ch1);
          if($e1 = curl_error($ch1))
          {
              echo $e1;
          }
          else 
          {
              $json_data1 = json_decode($resp1,true);
          }
          $json_data1 = json_decode($resp1,true);
          curl_close($ch1);

          $ebms_po_no=$json_data1["value"][0]['PO_NO'];

          if($po_by_customer==$ebms_po_no){
              $response=1;
          }else{
              $_SESSION['po_by_customer'] = $_POST['po_by_customer'];
              $response=0;
          }
         
          echo json_encode($response);
      }*/
    }


}