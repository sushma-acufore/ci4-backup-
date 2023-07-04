<?php 
namespace App\Controllers\Moreinfo;
use App\Models\Ordermodel;
use App\Models\Moreinfo;
use CodeIgniter\Controller;

class MoreInfoController extends BaseController
{
	protected $Moreinfo;
	public function __construct()
  {
      \Config\Services::session();
      $this->ordermodel = new Ordermodel();
      $this->moreinfo = new Moreinfo();
  }

  // more info page check pro8 weeks
  public function check_pro_8Weeks()
  {

    $pno=$part_no=$_POST['pno'];
    $cid=$_SESSION['E_EID'];
    $status2 = 0;
    $qry = $this->moreinfo->getProducts_in_8Weeks($cid,$pno);
    $num_rows1=$qry->getNumRows();
    if($num_rows1>0)
    {
        $status2 = 1;
    }
    else{
        $status2 = 0;
    }
    echo json_encode($status2);
  }

   

  

}