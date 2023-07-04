<?php 
namespace App\Controllers\Search;
use App\Models\Search\Search;
use CodeIgniter\Controller;

class SearchController extends BaseController
{
	protected $ordermodel;
    public function __construct()
    {
        \Config\Services::session();
        $this->search = new Search();
    }

    public function getSearchedData()
    {
        $search = $_POST['search'];
        $search = str_replace("'", "", $search);
        $search = str_replace('"', '', $search);

        $curl = strtolower($_POST['curl']);
        $cntry = strtolower($_POST['cntry']);
        $e = '';

        $result1 = $this->search->getSearchedProducts($search);
        if(!empty($result1))
        {  
                $e .='  <div class="row">
                    <div class="col-lg-12">
                    <div class="col-md-2 currency-part-div">
                        <li class="nav-item dropdown">
                          <a style="float:right" class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Currency : ';
                                if($curl == '' AND $cntry=="US") 
                                {
                                    $e .='<span id="curl_area" class="ycolor"><u>USD</u></span>';
                                }
                                else if($curl == '' AND $cntry !="US") 
                                {
                                    $e .='<span id="curl_area" class="ycolor"><u>CAD</u></span>';
                                }
                                else if($curl == "usa" or $curl=="usd" or $curl=="USD") 
                                {
                                    $e .='<span id="curl_area" class="ycolor"><u>USD</u></span>';
                                }
                                else if($curl == "cad" or $curl == "CAD") 
                                {
                                    $e .='<span id="curl_area" class="ycolor"><u>CAD</u></span>';
                                }
              $e .='      </a>
                          <ul class="dropdown-menu dropdown-menu-end currency_ul">
                          <li><a class="dropdown-item" onclick="change_currency(\'CAD\')" style="font-size: 14px;">
                              <img src="public/assets/img/CA.png" style="width:30px;">&nbsp; CANADA</a>
                            </li>

                            <li><a class="dropdown-item" onclick="change_currency(\'USD\')" style="font-size: 14px;">
                              <img src="public/assets/img/US.png" style="width:30px;">&nbsp; UNITED STATES</a>
                            </li>

                            <li><a class="dropdown-item" onclick="change_currency(\'USD\')" style="font-size: 14px;">
                              <img src="public/assets/img/globe.png" style="width:30px;">&nbsp; INTERNATIONAL</a>
                            </li>
                            
                           
                          </ul>
                        </li>
                    </div>
                    </div>
                </div>';
            $e .= '<div class="row">
            <div class="col-lg-12" style="padding: 10px 25px;">
                <div class="row table-area-row table-responsive">
                    <table class="table search-table-data" id="table-data">
                        <thead>
                            <tr class="table-dark tr-head">
                                <th>PARTS NUMBER SS</th>
                                <th>DESCRIPTION</th>
                                <th>STOCK</th>
                                <th>LIST PRICE</th>
                                <th>QUANTITY</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>';
                        foreach ($result1 as $row) 
                        {
                          $fulldescription=$row['Description'];
                          $fulldescription=str_replace('"', '', $fulldescription);

                          $C60_price_level_price = $row['C60_price_level_price'];
                          $U60_price_level_price = $row['U60_price_level_price'];
                          $price_level = '$0';
                          if($curl == '' AND $cntry=="US") 
                          {
                              if ($U60_price_level_price !='')
                              {
                                  $price_level = "$". number_format($U60_price_level_price, 2)." USD";
                              }
                          }
                          else if($curl == '' AND $cntry !="US") 
                          {
                              if ($C60_price_level_price !='')
                              {
                                  $price_level = "$". number_format($C60_price_level_price, 2)." CAD";
                              }
                          }
                          else if($curl == "usa" or $curl=="usd" or $curl=="USD") 
                          {
                              if ($U60_price_level_price !='')
                              {
                                  $price_level = "$". number_format($U60_price_level_price, 2)." USD";
                              }
                          }
                          else if($curl == "cad" or $curl == "CAD") 
                          {
                              if ($C60_price_level_price !='')
                              {
                                  $price_level = "$". number_format($C60_price_level_price, 2)." CAD";
                              }  
                          }

                          $e .='<tr class="table-default">
                                <td>'.$row['Part_Number'].'</td>';
                                if(strlen($row['Description'])>60)
                                {
                                    $e .= '<td data-toggle="tooltip" title="'.''.$fulldescription.''.'">'.substr($row['Description'], 0, 60).'...</td>';
                                }else
                                {
                                    $e .= '<td>'.$row['Description'].'</td>';
                                }
                                $row_avl = $this->search->sql_avl($row['Part_Number']);
                                if(!empty($row_avl))
                                {
                                  foreach ($row_avl as $row_available) 
                                  {
                                    $avl_stock=$row_available['S_AVAIL'];
                                    $e .= '<td><span id="stk_val'.$row['Part_Number'].'">'.$avl_stock.'</span></td>';
                                  }
                                }else{
                                    $e .= '<td><span id="stk_val'.$row['Part_Number'].'">0</span></td>';
                                }
                          //price display
                          $e .= '<td>'.$price_level.'</td>';

                          $e .= '<td>
                                    <div class="quantity-container">
                                    <input onchange=\'change_input_quantity("'.$row['Part_Number'].'","'.$avl_stock.'")\' id="qty_value'.$row['Part_Number'].'" value="01"  style="background-color : #ecebeb; border-color: #ecebeb;border: 1px solid #ecebeb;width:30px;">
                                    <!--<h2 id="search-table-counting" style="font-size: 14px;font-family: \'Inter\',sans-serif;"><span  id="qty_value'.$row['Part_Number'].'">01</span></h2>-->
                                        <div class="row"
                                            style="padding: 0px 13px;margin: 0px -11px;background: none;width:-2px;">
                                            <button onclick=\'change_quantity(2,"'.$row['Part_Number'].'")\' style="padding: 0px 0px;height:15px;">
                                              <img src="public/assets/img/Arrow-drop-up.png"></button>
                                            <button onclick=\'change_quantity(1,"'.$row['Part_Number'].'")\' style="padding: 0px 0px;height:10px;"><img
                                                    src="public/assets/img/Arrow-drop-down.png"></button>
                                        </div>
                                    </div>
                                </td>';
                                if($price_level=='$0.00 USD' || $price_level=='$0.00 CAD'){
                                  $e .= '<td>
                                  <img style="cursor: pointer;"src="public/assets/img/basket-icon-tbl.png" id="image_'.$row['Part_Number'].'" onclick=\'price_alert("'.$row['Part_Number'].'")\' />
                                  </td>';
                                }else{
                                    $e .= '<td>
                                    <img style="cursor: pointer;"src="public/assets/img/basket-icon-tbl.png" id="image_'.$row['Part_Number'].'" onclick=\'add_to_cart("'.$row['Part_Number'].'","'.$curl.'","'.$cntry.'","'.$avl_stock.'")\' />
                                    </td>';
                                }

                                $e .='<td>
                                    <form action="more-info" method="post" style="margin-bottom:0px;">
                                    <input type="hidden" name="part_no" value="'.$row['Part_Number'].'"/>
                                    <input type="hidden" name="curl" value="'.$curl.'"/>
                                    <input type="hidden" name="cntry" value="'.$cntry.'"/>
                                    <input type="hidden" name="avl_stock" value="'.$avl_stock.'"/>
                                    <button type="submit" class="btn-more-info">More&nbsp;Info</button></form>
                                </td>';
                                $e .='</tr>';

                        } 
        }else{
        $e .='<tr class="table-default"><td colspan="7" style="text-align:center!important">No Results Found</td></tr>';
        } 
        $e .='</tbody>
                    </table>
                </div>
            </div>
        </div>';

        echo $e;      
    }
}