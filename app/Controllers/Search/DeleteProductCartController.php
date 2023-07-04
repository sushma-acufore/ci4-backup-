<?php 
namespace App\Controllers\Search;
use App\Models\Search\DeleteProduct;
use CodeIgniter\Controller;

class DeleteProductCartController extends BaseController
{
	protected $ordermodel;
    public function __construct()
    {
        \Config\Services::session();
        $this->deleteproduct = new DeleteProduct();
    }

    public function delete_cart_item()
    {
        $id = $_POST['id'];
        $cid = $_SESSION['E_EID'];
        $e = '';
        $sql = $this->deleteproduct->delete_cart_index($id);

        $query = $this->deleteproduct->delete_cart_index_2($cid);
        $num=$query->getNumRows();
        if($num<=0){
            $_SESSION['po_by_customer']='';
        }
    }


}