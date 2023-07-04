<?php 
namespace App\Controllers\Search;
use App\Models\Search\Main;
use CodeIgniter\Controller;

class MainController extends BaseController
{
	protected $main;
    public function __construct()
    {
        \Config\Services::session();
        $this->main = new Main();
    }

    public function create_session_currency()
    {
        $_SESSION['custom_currency'] = $_POST['a'];
    }

    public function check_recomm_product()
    {
        $res=0;
        $part_no=trim($_POST['part_no']);

        $result5 =  $this->main->check_product_recommended_items($part_no);
        $num_rows=odbc_num_rows($result5);
        if($num_rows>0){
            $res=1;
        }else{
            $res=0;
        }
 
     echo json_encode($res);
    }  

    public function check_items_incart()
    {
        $cid=$_SESSION['user']['ebms_id'];
        $count = $this->main->getproduct_cart_countAll($cid);
        // $query=mysqli_query($conn,"select * from product_cart where cid='$cid'");
        // $count=mysqli_num_rows($query);
        echo json_encode($count);
    }

}