<?php 
namespace App\Models\Moreinfo;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class AddRecommendedProduct extends Model
{
	public function add_to_cart_recom($pno)
	{
		$db = db_connect();
	  	$query   = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` = '".$pno."' ");
	  	$sql_avil = $query->getRowArray();
	  	return $sql_avil;	
	}

	public function check_product_cart_recomm($Part_Number,$cid)
	{	
		$db = db_connect();
	  $check_prod_recomm   = $db->query("SELECT * FROM `product_cart` WHERE `product`= '".$Part_Number."' AND `cid` = '".$cid."'");
	  $chck_pro_recomm = $check_prod_recomm->getRowArray();

	  return $chck_pro_recomm;
	}

	public function check_product_cart_recomm_num($Part_Number,$cid)
	{	
		$db = db_connect();
		$count = $db->table('product_cart')->getWhere(['product' => $Part_Number, 'cid' => $cid]);
       	return $count->getNumRows();
	}

	public function check_product_cid($cid)
	{	
		$db = db_connect();
	  	$check_prod_cid = $db->query("SELECT * FROM `product_cart` WHERE `cid` = '".$cid."'");
	  	$check_product_cid = $check_prod_cid->getResultArray();
	  	return $check_product_cid;
	}

	public function update_product_cart_recomm($row_id,$cid,$lprice,$qty,$price,$totalprice,$curl,$sp_price)
	{
		$db = db_connect();
    	$update_product=$db->table('product_cart')->where('id', $row_id)->set(["cid" => $cid,"lprice" => $lprice, "sp_price" => $sp_price, "qty" => $qty, "price" => $price, "totalprice" => $totalprice, "currency" => $curl])->update();
    	return $update_product;  
	}

	public function update_product_discount_items_recomm($row_id,$disc_per_item,$total_discount_price,$cid)
	{
		$db = db_connect();
    	$update_product=$db->table('product_cart_discount_items')->where('cart_id', $row_id)->set(["discount_price" => $disc_per_item,"total_discount_price" => $total_discount_price])->update();
    	return $update_product;  
	}

	public function check_new_product_cart_recomm($cid)
	{
		$db = db_connect();
	  	$check_new_prod_cid = $db->query("SELECT * FROM `product_cart` WHERE `cid` = '".$cid."' ");
	  	$check_new_prod_cid = $check_new_prod_cid->getResultArray();
	  	return $check_new_prod_cid;
	}

	public function more_info_odbc_discount($dic_name)
	{	
		$user = "admin"; 
	    $password = "the2eS9t";
	    $database = "mtb";
    	$server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    	$conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

		$fetch_final_discount_8=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name'");   	
    	return $fetch_final_discount_8;
	}

	public function more_info_recomm_odbc_discount($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount)
	{	
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart')->insert([
	        'cid' => '',
	        'product'   => '',
	        'description' => '',
	        'lprice' => '',
	        'qty' => '',
	        'price' => '',
	        'totalprice' => '',
	        'currency' => '',
	        'sp_price' => '',
	        'discount' => '',
	        'discount8weeks_status' => '',
	        'discount_8weeks_amount' => '',
	        'total_8weeksdiscount_amt' => '',
	        'is_stock_dealer' => '',
	        'stock_dealer_discount' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount);  
      	return $results;
	}

	public function more_info_odbc_discount_2($dic_name_8)
	{	
		$user = "admin"; 
	    $password = "the2eS9t";
	    $database = "mtb";
    	$server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    	$conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

		$fetch_final_discount_8=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name_8'");   	
    	return $fetch_final_discount_8;
	}

	public function more_info_recomm_odbc_discount_2($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart')->insert([
	        'cid' => '',
	        'product'   => '',
	        'description' => '',
	        'lprice' => '',
	        'qty' => '',
	        'price' => '',
	        'totalprice' => '',
	        'currency' => '',
	        'sp_price' => '',
	        'discount' => '',
	        'discount8weeks_status' => '',
	        'discount_8weeks_amount' => '',
	        'is_stock_dealer' => '',
	        'stock_dealer_discount' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount);
      	return $results;
	}

	public function more_info_product_cart_recomm_discount($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart_discount_items')->insert([
	        'cart_id' => '',
	        'cid' => '',
	        'product' => '',
	        'discount_name' => '',
	        'discount' => '',
	        'discount_price' => '',
	        'total_discount_price' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount);
      	return $results;
	}

	public function more_info_odbc_discount_3($dic_name_8)
	{	
		$user = "admin"; 
	    $password = "the2eS9t";
	    $database = "mtb";
    	$server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    	$conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

		$fetch_final_discount_8=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name_8'");   	
    	return $fetch_final_discount_8;
	}

	public function more_info_product_cart_recomm_2($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart')->insert([
	       'cid' => '',
	        'product'   => '',
	        'description' => '',
	        'lprice' => '',
	        'qty' => '',
	        'price' => '',
	        'totalprice' => '',
	        'currency' => '',
	        'sp_price' => '',
	        'discount' => '',
	        'discount8weeks_status' => '',
	        'discount_8weeks_amount' => '',
	        'total_8weeksdiscount_amt' => '',
	        'is_stock_dealer' => '',
	        'stock_dealer_discount' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount);
      	return $results;
	}

	public function more_info_product_cart_recomm_discount_2($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart_discount_items')->insert([
	        'cart_id' => '',
	        'cid' => '',
	        'product' => '',
	        'discount_name' => '',
	        'discount' => '',
	        'discount_price' => '',
	        'total_discount_price' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount);
      	return $results;
	}

	public function more_info_odbc_discount_4($dic_name_ind)
	{	
			$user = "admin"; 
	    $password = "the2eS9t";
	    $database = "mtb";
    	$server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    	$conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

		$fetch_final_discount_8=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name_ind'");   	
    	return $fetch_final_discount_8;
	}

	public function more_info_product_cart_recomm_3($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$is_stock_dealer,$stock_dealer_discount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart')->insert([
	       	'cid' => '',
	        'product'   => '',
	        'description' => '',
	        'lprice' => '',
	        'qty' => '',
	        'price' => '',
	        'totalprice' => '',
	        'currency' => '',
	        'sp_price' => '',
	        'discount' => '',
	        'discount8weeks_status' => '',
	       	'is_stock_dealer' => '',
	        'stock_dealer_discount' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount);
      	return $results;
	}

	public function more_info_product_cart_recomm_discount_3($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$total_discount_price)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart_discount_items')->insert([
	        'cart_id' => '',
	        'cid' => '',
	        'product' => '',
	        'discount_name' => '',
	        'discount' => '',
	        'discount_price' => '',
	        'total_discount_price' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount);
      	return $results;
	}

	public function more_info_product_cart_recomm_4($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$mstatus,$is_stock_dealer,$stock_dealer_discount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart')->insert([
	       	'cid' => '',
	        'product'   => '',
	        'description' => '',
	        'lprice' => '',
	        'qty' => '',
	        'price' => '',
	        'totalprice' => '',
	        'currency' => '',
	        'sp_price' => '',
	        'discount8weeks_status' => '',
	       	'is_stock_dealer' => '',
	        'stock_dealer_discount' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$mstatus,$is_stock_dealer,$stock_dealer_discount);
      	return $results;
	}

}	