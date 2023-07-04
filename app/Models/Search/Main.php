<?php 
namespace App\Models\Search;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class Main extends Model
{
	public function check_product_recommended_items($part_no)
	{
		$user = "admin"; 
    $password = "the2eS9t";
    $database = "mtb";
    $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

		$qry_comp = "SELECT COMP_ID FROM [INVENACC] WHERE [INVENACC].ID = '".$part_no."';";
     
   	$result_comp = odbc_exec($conn_odbc,$qry_comp);
   	return $result_comp;
	}

	public function getproduct_cart_countAll($cid)
	{
		$db = db_connect();
		$count = $db->table('product_cart')->getWhere(['cid' => $cid]);
       	return $count->getNumRows();
	}
}