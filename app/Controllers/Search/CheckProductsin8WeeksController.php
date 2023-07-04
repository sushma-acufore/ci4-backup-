<?php 
namespace App\Controllers\Search;
use App\Models\Ordermodel;
use App\Models\Moreinfo;
use CodeIgniter\Controller;

class CheckProductsin8WeeksController extends BaseController
{
	protected $ordermodel;
    public function __construct()
    {
        \Config\Services::session();
        $this->ordermodel = new Ordermodel();
        $this->moreinfo = new Moreinfo();
    }

    public function check_pro_in_8weeks()
    {
        $pno = $_POST['pno'];
        $cid = $_POST['cid'];
        $pno = trim($pno);
        $e='';
        $status2=0;
        $stock_discount = 0;
        $apply_discount=0;

        $db = db_connect();
        $query   = $db->query("SELECT * FROM `product_cart` WHERE `product`= '".$pno."' AND `cid` = '".$cid."'");
        $results = $query->getNumRows();
       
        if($results>0){
            $status2 = 0;
            $stock_discount = 0;
            $apply_discount=0;
        }else
        {
            $user = "admin"; 
            $password = "the2eS9t";
            $database = "mtb";
            $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
            $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

            $qry5 = "SELECT APPLY,DISCOUNT FROM [ARCUSTSTK] 
            INNER JOIN [INVENTRY] ON [ARCUSTSTK].TREE_PATH = [INVENTRY].TREE_PATH 
            WHERE [ARCUSTSTK].CUST_ID = '".$cid."'
            AND [INVENTRY].ID='".$pno."';";
            $result5 = odbc_exec($conn_odbc,$qry5);
            while($dt5 = odbc_fetch_array($result5))
            {
                $stock_discount = (float)$dt5['DISCOUNT'];
                $apply_discount = (float)$dt5['APPLY'];
                
            }

             //to fetch EP_DISC
            $qry_disc = "SELECT EP_DISC FROM [INVENTRY] where [INVENTRY].ID='".$pno."';";
            $result_disc= odbc_exec($conn_odbc,$qry_disc);
            $num_rows_disc= odbc_num_rows($result_disc);
            while($dt_disc = odbc_fetch_array($result_disc))
                {
                    $status2 = $dt_disc['EP_DISC'];
                }
        }

        echo $status2."||".$stock_discount."||".$apply_discount;
    }

}
