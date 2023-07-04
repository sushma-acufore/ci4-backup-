<?php 
namespace App\Controllers\Cart;
use App\Models\Cart\SavePreviewDetails;
use CodeIgniter\Controller;

class SavePreviewDetailsController extends BaseController
{
	protected $SavePreviewDetails;
	public function __construct()
	{
	    \Config\Services::session();
        $this->save_preview_details = new SavePreviewDetails();
	}

	public function save_preview_details()
    {

        $json_data1 = '';
        $cid = strtoupper($_POST['cid']);
        $ship_id = strtoupper($_SESSION['ship_id']);
    
        $e = '';
        $result1 = $this->save_preview_details->getproduct_cid($cid);
        if(!empty($result1))
        {
            $e .='{
                    "ID": "'.$cid.'", 
                    "C_ID": "'.$ship_id.'",
                    "Details":
                    [';
            foreach ($result1 as $row1) 
            {
                $rid = $row1['id'];
                $fetch_disc_items = $this->save_preview_details->getproduct_cart_discount_items($rid);
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

                $lprice = number_format($lprice,2);
                $price = number_format($price,2);
                $totalprice = number_format($totalprice,2);

                $discount8weeks_status=$row1['discount8weeks_status'];

                $e .='
                        {
                            "INVEN": "'.$product.'",
                            "M_QUAN_VIS": "'.$qty.'"
                        },
                    '; 
                   if(!empty($fetch_disc_items))
                    { 
                        foreach ($fetch_disc_items as $fetch_disc_item_row) 
                        {
                        
                        $discount_item_name=$fetch_disc_item_row['discount_name'];
                        $e .='
                            {
                                "INVEN": "'.$discount_item_name.'",
                                "M_QUAN_VIS": "1"
                            },
                        ';  
                        } 
                    }            
            }

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

                //var_dump($json_data1);

                if(isset($json_data1['AUTOID']))
                    {
                    $_SESSION['SalesOrder_result'] = $json_data1;
                    
                    // echo "<br>";
                    $AUTOID = $json_data1['AUTOID'];
                    $AUTOID = trim($AUTOID);
            
                    $e = $json_data1;
                    $e = $AUTOID;

                    }else{
                        $e=2;
                    }

        if(!empty($AUTOID))
        {
            //delete API using AutoID
            $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://ECC842362022020802.servicebus.windows.net/myebms/MTB/OData/ARINV(\''.$AUTOID.'\')',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'DELETE',
              CURLOPT_HTTPHEADER => array(
                'Content-Type:  application/json',
                'Authorization: Basic QVBJQUNDRVNTOkFQSWFjY2Vzc0w='
              ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            // echo $response;
            if(empty($response))
            {
                //echo "<br>Temp order deleted successfully";
            }
        }
               
        }else
        {
            $e = 1;
        }
        echo $e;
    }
    public function set_session_po_new_addr()
    {
        if($_POST['po_by_customer'])
        {
            $po_by_customer= strtoupper(trim($_POST['po_by_customer']));
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

            $ebms_po_no=strtoupper($json_data1["value"][0]['PO_NO']);

            if($po_by_customer==$ebms_po_no){
                $response=1;
            }else{
                $response=0;
            }
           
            echo json_encode($response);
        }
    }
    public function set_session_po()
    {
        if($_POST['po_by_customer'])
        {
            $po_by_customer= strtoupper(trim($_POST['po_by_customer']));
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

            $ebms_po_no=strtoupper($json_data1["value"][0]['PO_NO']);

            if($po_by_customer==$ebms_po_no)
            {
                $response=1;
            }
            else
            {
                $_SESSION['po_by_customer'] = $_POST['po_by_customer'];
                $response=0;
            }
           
            echo json_encode($response);
        }
    }
    public function unset_shipping_session()
    {
        unset($_SESSION['po_by_customer']);
        unset($_SESSION['ship_addr']);
    }
}