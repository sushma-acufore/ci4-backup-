<?php 
namespace App\Controllers\Header;
use App\Models\Header\HeaderModel;

use App\Models\Ordermodel;
use App\Models\Moreinfo;
use CodeIgniter\Controller;

class HeaderController extends BaseController
{	
	protected $ordermodel;
    public function __construct()
    {
        \Config\Services::session();
        $this->headermodel = new HeaderModel();
        $this->ordermodel = new Ordermodel();
        $this->moreinfo = new Moreinfo();
    }

    public function refresh_basket()
    {
        $cid = $_POST['cid'];
        $e1 = '';
        $result1 = $this->headermodel->getproduct_by_cid($cid);
        if(!empty($result1))
        {
          $e1 .= '<li>
                  <div class="navbar-order-list refresh_basket_scroll" style="height: 250px;overflow-y: auto;">';
                    foreach ($result1 as $row1) 
                    { 
                            $product = $row1['product'];
                            $description = $row1['description'];
                            if(strlen($description)>18)
                            {
                                $description = substr($description, 0, 18)."...";
                            }
                            $e1 .='<div class="order-details-div">
                                    <p class="d-inline-block text-truncate" style="max-width: 270px;">'; 
                                    $e1 .= '<b>Item : '.$product.'</b><br>'; 
                                    $e1 .= '<b>Description : '.$description.'</b></p>';
                                  $e1 .= '</div>';
                    }
                    $e1 .= '</div>
                  </li>';
                  $e1 .= '<li>';
                            $row = $this->headermodel->getTotal_cid($cid);
                            $e1 .= '<div style="padding: 10px;">
                              <p class="order-details-total-amt">Total List Amount :</p>
                              <button class="btn btn-sm btn-warning order-details-btn"
                                  style="background-color: #ECC712!important;border-radius:60px;color: #0A4276;font-weight:400;">$'.number_format($row['SUM(totalprice)'],2).'</button>
                              
                                  <a href="'.base_url().'/cart" style="padding:0px!important;float:right"><button class="btn btn-sm btn-warning order-details-btn"
                                    style="float:right;background-color: #ECC712!important;border-radius:60px;color: #0A4276;font-weight:400;cursor:pointer!important" >View Cart</button></a>
                            </div>
                          </li>';
        }else{
          $e1 .='<li style="text-align:center;color:#fff">No items in your cart</li>';
        }

        echo $e1;
    }


    public function refresh_orders()
    {
     $ee2 = '';
                        
      if(isset($_SESSION['E_EID']))
      {
        $_SESSION['user']['ebms_id'];
        $eid = $_SESSION['E_EID'];
      
      
      $getResult2 = headermodel::getebms_order_main($eid);

      if(!empty($getResult2))
      {  
        $cid=$_SESSION['user']['ebms_id'];
        $ee2 = '<li class="navbar-order-list scrollBar" style="height: 300px;overflow-y: scroll;">';
        foreach ($getResult2 as $getRow2) 
        { 
          $autoID = $getRow2['AUTOID'];
          $INVOICE = $getRow2['INVOICE'];
          $DateTime = $getRow2['date_time'];
          $onylDate = date('d-m-Y',strtotime($DateTime));

          $ee2 .= '<div style="padding: 2px 10px;">
                    <div class="shipping-details-div">
                        <p><b>Orderd id </b>: '.$INVOICE.'</p>
                        <p><b>Orderd on </b>: '.$onylDate.'</p>
                    </div>
                  </div>';
        }
        $ee2 .= '</li>';
        $ee2 .= '<li>';
        $row = headermodel::getgetTotal($cid);
        $ee2 .= '<div style="padding: 10px;">
          <p class="order-details-total-amt">Total Amount :</p>
          <button class="btn btn-sm btn-warning order-details-btn"
              style="background-color: #ECC712!important;border-radius:60px;color: #0A4276;font-weight:400;">$'.$row['SUM(totalprice)'].'</button>
          
              <a href="my-orders.php" style="float:right;padding:0px!important;">
              <button class="btn btn-sm btn-warning order-details-btn"
                style="cursor:pointer!important;float:right;background-color: #ECC712!important;border-radius:60px;color: #0A4276;font-weight:400;" >View Orders</button></a>

        </div>
      </li>';

      }else{
        $ee2 .= '<li class="navbar-order-list">
                    <div style="padding: 2px 10px;">
                      <div class="shipping-details-div">
                        <p>No Orders Found</p>    
                    </div>
                  </div>
                </li>';
      }}else{
        $ee2 .= '<li class="navbar-order-list" style="text-align:center">
                        <p style="color:#fff;margin-top:8px;">No Orders Found</p>  
                </li>';
      }
      echo $ee2;
    }

    public function account_page()
    {   
      $cid = "ABRA1";
      $data['users'] = $this->headermodel->getLoggedInUser($cid);
      echo view("onlineorder/content/account/account-page", $data);

    }

    public function logout()
    {  
      session_destroy();
      return redirect()->to('https://baumalight.acufore.com/login/en/login.php');
    }

    public function my_orders()
    {   
    
      // echo view('order/myorders');
      echo view('onlineorder/content/myorders/myorders');
    }

    public function getMyorders()
    {
      $e = '';
      $e .= '<div class="col-lg-12" style="padding: 10px 25px;" > ';
      if(isset($_SESSION['E_EID']))
      {
        $cid=$_SESSION['E_EID'];
        $check_items = $this->headermodel->getebms_order($cid);     
        if(!empty($check_items))
        {
          $e .= '<div class="row table-area-row table-responsive" >
            <table class="table myorders-table-data" id="table-data">
              <thead>
                <tr class="table-dark tr-head">
                  <th>Sl No</th>
                  <th>Invoice Number</th>
                  <th>PO Number</th>
                  <th>Order Date</th>
                  <th>No of Items</th>
                  <th>Total Amount</th>
                  
                  <th></th>
                </tr>
              </thead>
              <tbody>';
              $slno=0;
              foreach ($check_items as $row) 
              {
                  $AUTOID=$row['AUTOID'];
                  $INVOICE=$row['INVOICE'];
                  $po_no ='';
                  $po_no_q = '';
                  $po_no_q = $this->headermodel->getebms_order1($AUTOID,$cid);
                  if(!empty($po_no_q))
                  {
                      $po_no = $po_no_q['PO_NO'];
                  }
                  $item_count = $this->headermodel->getebms_order2($AUTOID,$cid);
                  $result2 = $this->headermodel->getebms_order2a($AUTOID,$cid);
                  $date_time1 = $result2['date_time'];
                  $slno++;
              $e .='
                    <tr class="table-default">
                      <td>'.$slno.'</td>
                      <td style="text-align:center!important">'.$INVOICE.'</td>
                      <td style="text-align:center!important">'.$po_no.'</td>
                      <td>'.$date_time1.'</td>
                      <td >'.$item_count.'</td>
                      <td >'.number_format($row['totalprice'],2).'</td>
                      <td >
                      <form action="'.base_url('myordersitemsview').'" method="post" style="margin: 0;">
                        <input type="hidden" name="auto_id" value="'.$row['AUTOID'].'"/>
                        <button type="submit" class="my-orders-btn-more-info">Items View</button>
                      </form>
                      </td>
                    </tr>';
                    }
                  $e .='</tbody>
                </table>
              </div>';
        }
        }else
        {
        }
      $e .='</div>';
      echo $e;
    }

    public function my_orders_itemsview()
    {
      echo view('order/myordersitemsview');
    }


}
