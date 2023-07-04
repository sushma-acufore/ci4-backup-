<?php 
namespace App\Controllers\Cart;
use App\Models\Cart\RefreshCart;
use CodeIgniter\Controller;

class RefreshCartController extends BaseController
{
	protected $RefreshCart;
  public function __construct()
  {
    \Config\Services::session();
    $this->refreshcart = new RefreshCart();
  }

  public function refresh_cart()
  {
    $cid = $_POST['cid'];
    $e1 = '';
    $result1 = $this->refreshcart->getproduct_cid($cid);
    if(!empty($result1))
    {
      $e1 .=' 
          <table class="table cart-table-data" style="margin-bottom:0px;">
            <thead>
                  <tr class="table-dark tr-head">
                      <th>Part Number</th>
                      <th>Description</th>
                      <th>Stock</th>
                      <th>Quantity</th>
                      <th>List Price</th>
                      <th>Dealer&nbsp;Discount</th>
                      <th>Stock&nbsp;Dealer&nbsp;Price</th>
                      <th>Extended&nbsp;Price</th>
                      
                      <th>Remove</th>
                  </tr>
              </thead>
              <tbody>';
            
            foreach ($result1 as $row1)
            {
                $rid = $row1['id'];
                $check_desc_items = $this->refreshcart->product_cart_discount_items($rid);
                $num_disc_items = $check_desc_items->getNumRows();
                $fetch_arr = $check_desc_items->getResult();

                $product = $row1['product'];
                $lprice = $row1['lprice'];
                $description = $row1['description'];
                
                $fulldescription=$row1['description'];
                $fulldescription=str_replace('"', '', $fulldescription);

                $sp_price = $row1['sp_price'];
                if(strlen($description)>15)
                {
                    $description = substr($description, 0, 15)."...";
                }
                $qty = $row1['qty'];
                $price = $row1['price'];
                $discount_name = $row1['discount_name'];
                $discount = $row1['discount'];
                $totalprice = $row1['totalprice'];
                $currency = $row1['currency'];
                $discount8weeks_status = $row1['discount8weeks_status'];
                $is_stock_dealer = $row1['is_stock_dealer'];
                $stock_dealer_discount = $row1['stock_dealer_discount'];
                
                $sp_price = number_format($sp_price,2);
                $lprice = number_format($lprice,2);
                $price = number_format($price,2);
                $totalprice = number_format($totalprice,2);
                $total_8weeksdiscount_amt = $row1['total_8weeksdiscount_amt'];
                $total_8weeksdiscount_amt = number_format($total_8weeksdiscount_amt,2);


                $ind_discount_amt = (float)$row1['sp_price']*$discount;
                $ind_discount_amt = (float)$ind_discount_amt/100;
                $total_ind_discount_amt = $ind_discount_amt*$qty;
                $total_ind_discount_amt = number_format($total_ind_discount_amt,2);

                $row_avl = $this->refreshcart->geteagle_available_stock($product);

                $avl_stock =0;
                $serial_no_count = 0;
                if(!empty($result_avl))
                {
                $avl_stock=$result_avl['S_AVAIL'];
                }
                $existing_qty=$row1['qty'];

                $e1 .='<tr class="table-default">
                        <td>'.$product.'</td>
                        <td  data-toggle="tooltip" title="'.$fulldescription.'">'.$description.'</td>
                        <td>'.$avl_stock.'</td>
                        <td>
                            <div class="quantity-container">
                            <input onchange=\'change_input_quantity_cart("'.$rid.'","'.$product.'","'.$avl_stock.'","'.$existing_qty.'","'.$qty.'")\' id="qty_value_cart'.$product.'" value="'.$qty.'"  style="background-color : #ecebeb; border-color: #ecebeb;border: 1px solid #ecebeb;width:30px;">
                                <!--<h2 id="search-table-counting" style="font-size: 14px;font-family: \'Inter\',sans-serif;">'.$qty.'</h2>-->
                                <div class="row"
                                    style="padding: 0px 13px;margin: 0px -11px;background: none;width:-2px;">
                                    <button onclick=\'change_quantity_in_cart(2,"'.$rid.'","'.$avl_stock.'","'.$existing_qty.'","'.$existing_qty.'")\' style="padding: 0px 0px;height:15px;"><img
                                            src="'.base_url().'public/assets/img/Arrow-drop-up.png"></button>
                                    <button onclick=\'change_quantity_in_cart(1,"'.$rid.'","'.$avl_stock.'","'.$existing_qty.'","'.$existing_qty.'")\' style="padding: 0px 0px;height:10px;"><img
                                            src="'.base_url().'public/assets/img/Arrow-drop-down.png"></button>
                                </div>
                            </div>
                        </td>
                        <td class="align-right">$'.$lprice.'</td>
                        <td class="align-right">$'.$sp_price.'</td>';
                        
                        // stock discount
                        if($is_stock_dealer==1)
                        {
                            $e1 .= '<td class="align-right">Discount&nbsp;in&nbsp;below&nbsp;line</td>';
                            $e1 .='<td class="align-right">$'.$totalprice.'</td>';
                        }else
                        {
                            $e1 .= '<td class="align-right">
                                        <button type="button" class="cart-table-btn-dealer-price" onclick=\'stock_dealer_alert("'.$product.'","'.$row1['sp_price'].'","'.$row1['stock_dealer_discount'].'","index.php")\' >Click&nbsp;Here</button>
                                    </td>';
                            $e1 .='<td class="align-right">$'.$price.'</td>';
                        }

                        $e1 .='<td><a onclick=\'delete_cart_item("'.$rid.'")\'><img class="search-cart-trash" src="'.base_url().'public/assets/img/Trash.png" /></a></td>
                    </tr>'; 
                    if($num_disc_items>0)
                        {
                            foreach($fetch_arr as $fetch_disc_item_row){
                            $discount_price=$fetch_disc_item_row->discount_price;
                            $total_discount_amt=$discount_price*$existing_qty;
                            $e1 .='<tr class="table-default">
                                    <td>'.$fetch_disc_item_row->discount_name.'</td>
                                    <td>'.$fetch_disc_item_row->discount_name.'</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>';
                                $e1 .= '<td class="align-right">-&nbsp;$'.$total_discount_amt.'</td>';
                                $e1 .='<td></td>
                                </tr>'; 
                                }
                            }
            }

            $e1 .='</tbody>
                    <tfoot>';
            $totallprice = 0;
            $totalspecialprice = 0;
            $totalprice=0;
            $price = 0;
            $totaldisc_price=0;

            $result1 = $this->refreshcart->getproduct_cart($cid);
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
                
                //$totalprice = number_format($totalprice,2);

                $totalprice =$totalprice-$totaldisc_price;
                $totalprice = number_format($totalprice,2);

                // $e1 .=' <tr>
                //             <td colspan="4" style="text-align: end;font-weight: bolder;">Total</td>
                //             <td><button class="btn btn-warning yellow-btns-cart">$'.$totallprice.'</button></td>
                //             <td><button class="btn btn-warning yellow-btns-cart">$'.$totalspecialprice.'</button></td>
                //             <td><button class="btn btn-warning yellow-btns-cart">$'.$price.'</button></td>
                //             <td><button class="btn btn-warning yellow-btns-cart">$'.$totalprice.'</button></td>
                //             <td></td>
                //         </tr>';
            
                $e1 .=' <tr>
                     <td colspan="2" style="text-align:left;font-weight: bolder;padding-left: 0px;"><a href="index.php" id="add_product_top">
                     <button style="cursor:pointer!important"class="add_more_btn" type="button"
                >Add More Product</button></a></td>
                

                            <td colspan="5" style="text-align: end;font-weight: bolder;">Total</td>
                            <td style="float: right;padding-right: 0px;"><button class="btn btn-warning yellow-btns-cart" >$'.$totalprice.'</button></td>
                            <td></td>
                        </tr>';

                    //     $e1 .=' <tr>
                    //     <td></td>
                    //     <td colspan="7" style="text-align:right"><a href="stock-dealer-registration.php"
                    //         style="color:#ecc712;text-decoration:none;font-size:14px;font-weight:bold" id="blink">*Register as
                    //         "Stock Dealer" to avail this Price.</a></td>

                    //   </tr>';
               
            }  
            $e1 .=' </tfoot>
                </table>';
            
        }else
        {
            $e1 ='<div class="col-md-12" style="text-align:center"><img src="'.base_url().'public/assets/img/empty-cart-yellow.png" /></div>';
           
        }
        echo $e1;
  }

}