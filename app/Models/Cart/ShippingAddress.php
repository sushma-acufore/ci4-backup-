<?php 
namespace App\Models\Cart;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class ShippingAddress extends Model
{
	public function getproduct_cart_countAll($cid)
	{
		$db = db_connect();
		$count = $db->table('product_cart')->getWhere(['cid' => $cid]);
       	return $count->getNumRows();
	}

	public function getARSHIP($cid)
	{
		$user = "admin"; 
        $password = "the2eS9t";
        $database = "mtb";
        $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
        $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);
		$qry5 = "SELECT * FROM [ARSHIP] WHERE ID = '".$cid."' order by RECNO5 asc";
        $result5 = odbc_exec($conn_odbc,$qry5);
	    return $result5;   
	}

	public function getCUST_defautaddr($cid)
	{
		$user = "admin"; 
        $password = "the2eS9t";
        $database = "mtb";
        $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
        $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);
		$qry5 = "SELECT * FROM [ARCUST] WHERE ID = '".$cid."' order by RECNO5 asc";
        $result5 = odbc_exec($conn_odbc,$qry5);
	    return $result5;   
	}


	public function getARCUST($ship_id)
	{
		$user = "admin"; 
        $password = "the2eS9t";
        $database = "mtb";
        $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
        $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);
		$qry_more = "SELECT * FROM [ARCUST] WHERE ID = '".$ship_id."' order by RECNO5 asc";
        $result_more = odbc_exec($conn_odbc,$qry_more);
        $fetch_more=odbc_fetch_array($result_more);
	    return $fetch_more;   
	}

	public function getARCUST_info($ship_id)
	{
		$user = "admin"; 
        $password = "the2eS9t";
        $database = "mtb";
        $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
        $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);
		$qry5 = "SELECT * FROM [ARCUST] WHERE ID = '".$ship_id."' order by RECNO5 asc";
            $result5 = odbc_exec($conn_odbc,$qry5);
	    return $result5;   
	}
}