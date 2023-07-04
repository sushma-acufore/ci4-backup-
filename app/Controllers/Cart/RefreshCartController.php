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
                $num_disc_items = $this->refreshcart->getproduct_cart_discount_items_count($rid);
                $fetch_disc_items = $this->refreshcart->getproduct_cart_discount_items($rid);

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
                $discount8weeks_status = $row1['discount8weeks_status'];
                $discount = $row1['discount'];
                $totalprice = $row1['totalprice'];
                $currency = $row1['currency'];

                $sp_price = number_format($sp_price,2);
                $lprice = number_format($lprice,2);
                $price = number_format($price,2);
                $totalprice = number_format($totalprice,2);

                $discount_8weeks_amount = $row1['discount_8weeks_amount'];
                $discount_8weeks_amount = number_format($discount_8weeks_amount,2);
                
                $total_8weeksdiscount_amt = $row1['total_8weeksdiscount_amt'];
                $total_8weeksdiscount_amt = number_format($total_8weeksdiscount_amt,2);

                $is_stock_dealer = $row1['is_stock_dealer'];
                $stock_dealer_discount = $row1['stock_dealer_discount'];


                $row_avl = $this->refreshcart->geteagle_available_stock($product);
                $avl_stock =0;
                $serial_no_count = 0;
                if(!empty($row_avl))
                {
                    $avl_stock=$row_avl['S_AVAIL'];
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
                            $e1 .= '<td class="align-right">$'.$totalprice.'</td>';
                        }else
                        {
                            $e1 .= '<td class="align-right"><button type="button" class="cart-table-btn-dealer-price" onclick=\'stock_dealer_alert("'.$product.'","'.$row1['sp_price'].'","'.$row1['stock_dealer_discount'].'","cart")\' >Click&nbsp;Here</button></td>';
                            $e1 .= '<td class="align-right">$'.$totalprice.'</td>';
                        }

                        $e1 .='<td><a onclick=\'delete_cart_item("'.$rid.'")\'><img class="search-cart-trash" src="'.base_url().'public/assets/img/Trash.png" /></a></td>
                    </tr>'; 
                    if($num_disc_items>0)
                    {
                        foreach ($fetch_disc_items as $fetch_disc_item_row) 
                        {
                            $discount_item_name=$fetch_disc_item_row['discount_name'];
                            $full_discount_item_name=$fetch_disc_item_row['discount_name'];
                            if(strlen($fetch_disc_item_row['discount_name'])>15)
                            {
                                $discount_item_name = substr($fetch_disc_item_row['discount_name'], 0, 15)."...";
                            }
                             $total_discount_amt=$fetch_disc_item_row['discount_price']*$qty;

                             $e1 .='<tr class="table-default">
                                        <td data-toggle="tooltip" title="'.''.$full_discount_item_name.''.'">'.$full_discount_item_name.'</td>
                                        <td data-toggle="tooltip" title="'.''.$full_discount_item_name.''.'">'.$full_discount_item_name.'</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>';
                                        $e1 .= '<td class="align-right">-&nbsp;$'.number_format($total_discount_amt,2).'</td>';
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
            $row1 = $this->refreshcart->getproduct_cart_sum($cid);
            $row2 = $this->refreshcart->getproduct_cart_total_discount_price($cid);
            $total_discount_price=0;
            if(!empty($row2))
            {
                $total_discount_price = $row2['total_discount_price'];
            }

            if(!empty($row1))
            {   
                $totalprice=$row1['totalprice'];
                $totalprice =$totalprice-$total_discount_price;
                $totalprice = number_format($totalprice,2);
                $e1 .=' <tr>
                     <td colspan="2" style="text-align:left;font-weight: bolder;padding-left: 0px;"><a href="index" id="add_product_top">
                     <button style="cursor:pointer!important"class="add_more_btn" type="button"
                >Add More Product</button></a></td>
                <td colspan="5" style="text-align: end;font-weight: bolder;">Total</td>
                <td style="float: right;padding-right: 0px;"><button class="btn btn-warning yellow-btns-cart" >$'.$totalprice.'</button></td>
                <td></td>
            </tr>';
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