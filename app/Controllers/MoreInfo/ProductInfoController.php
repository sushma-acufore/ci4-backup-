<?php 
namespace App\Controllers\Moreinfo;
use App\Models\Moreinfo;
use CodeIgniter\Controller;

class ProductInfoController extends BaseController
{
	protected $Moreinfo;
	public function __construct()
    {
        \Config\Services::session();
        $this->moreinfo = new Moreinfo();
    }

    public function more_information()
    { 
      $from_cart_icon=0;
      if(isset($_POST['from_cart_icon'])) {
          $from_cart_icon=$_POST['from_cart_icon'];
      }

      $pno=$part_no=$_POST['part_no'];
      $curl=$_POST['curl'];
      $cntry=$_POST['cntry'];
      $avl_stock=$_POST['avl_stock'];
      $qty=1;
      $cid=$_SESSION['E_EID'];
      $status2 = 0;
      $stock_discount = 0;
      $is_stock_dealer=0;

      $user = "admin"; 
      $password = "the2eS9t";
      $database = "mtb";
      $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
      $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

      $check_in_cart = $this->moreinfo->check_in_cart_wrt_user($pno,$cid);
      $num_rows_in_cart=$check_in_cart->getNumRows();
      if($num_rows_in_cart>0){

        $fetch_arr = $check_in_cart->getRowArray();
        
        $status2 = $fetch_arr['discount8weeks_status'];
        $is_stock_dealer =$fetch_arr['is_stock_dealer'];
        
        if($is_stock_dealer==1){
            $stock_discount =$fetch_arr['stock_dealer_discount'];
        }else{
            $stock_discount =$fetch_arr['stock_dealer_discount'];
        }
      }else{
          //to fetch discount and apply(to check stock dealer)
          $qry5 = "SELECT APPLY,DISCOUNT FROM [ARCUSTSTK] 
          INNER JOIN [INVENTRY] ON [ARCUSTSTK].TREE_PATH = [INVENTRY].TREE_PATH 
          WHERE [ARCUSTSTK].CUST_ID = '".$cid."'
          AND [INVENTRY].ID='".$pno."';";
          $result5 = odbc_exec($conn_odbc,$qry5);
          $num_rows2 = odbc_num_rows($result5);
                while($dt5 = odbc_fetch_array($result5))
                  {
                      $stock_discount = (float)$dt5['DISCOUNT'];
                      $is_stock_dealer = $dt5['APPLY'];
                      // $stock_discount = 4;
                  }

          //to fetch EP_DISC
          $qry_disc = "SELECT EP_DISC FROM [INVENTRY] where [INVENTRY].ID='".$pno."';";
          $result_disc= odbc_exec($conn_odbc,$qry_disc);
          $num_rows_disc= odbc_num_rows($result_disc);
                while($dt_disc = odbc_fetch_array($result_disc))
                  {
                      $status2 = $dt_disc['EP_DISC'];
                      // $status2 = 1;
                  }
      }

      $mstatus=$status2;
      $stk_discount=$stock_discount;

      $row = $this->moreinfo->get_product_details($pno);

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

    //   $qry_comp = "SELECT COMP_ID FROM [INVENACC] WHERE [INVENACC].COMP_ID!='' and [INVENACC].ID = '".$part_no."';";
    //   $result_comp = odbc_exec($conn_odbc,$qry_comp);
    //   $result_comp1 = odbc_exec($conn_odbc,$qry_comp);
    //   $recom_item_to_loop = array();
    //   while($data_comp1 = odbc_fetch_array($result_comp1)){
    //     $COMP_ID1 = $data_comp1['COMP_ID'];

    //     $row = $this->moreinfo->get_recomm_products($pno);

    //     $recom_sql1 = "SELECT * FROM `gp_report` WHERE status='Active' and `Part_Number` = '".$COMP_ID1."' ";

    //     $result_recom_gp1 = mysqli_query($conn,$recom_sql1);
    //     while($row_gp1=mysqli_fetch_array($result_recom_gp1)){
    //         array_push($recom_item_to_loop,$COMP_ID1);
    //     }
    //   }

    // var_dump($recom_item_to_loop);

      $c_error = 0;
        $cc_curl = $curl;
        $cc_curl = strtolower($cc_curl);
        if($c_error==0)
        {
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

           //var_dump($json_data1);      

           $price = (int)$qty * (float)$sp_price;
           $totalprice = $price;

           $discount_t = (float)$stk_discount;

           if($is_stock_dealer==1)
           {
               $discount = (float)$price * $discount_t;
               $discount = (float)$discount / 100;
               $totalprice = (float)$price - (float)$discount;  
           }else
           {
               
           }

              // $e23="2"."||".$lprice."||".$sp_price."||".$totalprice."||".$mstatus."||".$curl;
                $data['ee'] = [
                  'lprice' => $lprice,
                  'sp_price' => $sp_price,
                  'totalprice' => $totalprice,
                  'mstatus' => $mstatus,
                  'curl' => $curl,
                  'pno' => $pno,
                  'stk_discount' => $stk_discount,
                  'description' => $Description,
                  'from_cart_icon' =>$from_cart_icon,
                  'is_stock_dealer' =>$is_stock_dealer
                ];
        }else
        {
          $e23 = 3;
        }

      echo view("onlineorder/content/moreinfo/moreinfo", $data);
    }




}