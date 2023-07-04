<?php 
namespace App\Controllers\Cart;
use App\Models\Cart\Cart;
use CodeIgniter\Controller;

class CartController extends BaseController
{
	protected $Cart;
  public function __construct()
  {
    \Config\Services::session();
    $this->cart = new Cart();
  }

  public function cart()
  {
    echo view('onlineorder/content/cart/cart');
  }

  public function check_items_incart()
  {
      $cid=$_SESSION['user']['ebms_id'];
      $count = $this->cart->getproduct_cart_countAll($cid);
      echo json_encode($count);
  }

  public function clear_cart_item()
  {
    $_SESSION['po_by_customer']='';
    $id = $_POST['id'];
    $e = '';
    $result1 = $this->cart->delete_product_cid($id);
  }

  public function delete_cart_item()
    {
      $id = $_POST['id'];
      $cid = $_SESSION['E_EID'];

      $e = '';
      $result1 = $this->cart->delete_product_id($id);
      $num = $this->cart->product_cart_id($cid);
     
      if($num<=0)
      {
          $_SESSION['po_by_customer']='';
      }
      echo $result1;
    }


}