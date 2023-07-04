<?php 
namespace App\Models;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class Moreinfo extends Model
{	

	// MORE INFO PAGE QUERY
	public static function check_in_cart_wrt_user($pno,$cid)
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `product_cart` WHERE `product`= '".$pno."' AND `cid` = '".$cid."' ");
	    return $query;
	}

	// MORE INFO PAGE QUERY
	public static function getProducts_in_8Weeks($cid,$pno)
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `product_cart` WHERE `product`= '".$pno."' AND `cid` = '".$cid."' ");
	    $get_products_in_8_weeks = $query->getResultArray();
	    return $query;
	}
	// checking avail stock

	public static function checking_avail_stock($pno)
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = '" . $pno . "'");
	    $check_avail_stock = $query->getRowArray();
	    return $check_avail_stock;
	}

	public static function get_gp_report($pno)
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` ='".$pno."'");
	    $get_gp = $query->getRowArray();
	    return $get_gp;
	}

	public static function ProductCart($cid,$Part_Number)
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `product_cart` WHERE `product`='".$Part_Number."' AND `cid`='".$cid."'");
	    $getProduct = $query->getRowArray();
	    return $getProduct;
	}

	public function upate_product_cart($row_id,$lprice,$sp_price,$qty,$price,$totalprice,$curl)
	{
		$db = db_connect();
    $update_product=$db->table('product_cart')->where('id', $row_id)->set(["lprice" => $lprice, "sp_price" => $sp_price, "qty" => $qty, "price" => $price, "totalprice" => $totalprice, "currency" => $curl])->update();
    return $update_product;       
	}

	public function upate_product_discount_items($row_id,$disc_per_item,$total_discount_price)
	{
		$db = db_connect();
    $update_product=$db->table('product_cart_discount_items')->where('cart_id', $row_id)->set(["discount_price" => $disc_per_item, "total_discount_price" => $total_discount_price])->update();
    return $update_product;       
	}

	public function product_cart_discount_items($discount)
	{
		$db = db_connect();
    	$update_cart_discount =$db->table('product_cart_discount_items')->set(["total_discount_price" => $discount])->update();
    	return $update_cart_discount;
	}

	// insert product
	public function InsertToCartProduct($cid)
	{	
		// echo $cid;
		$db = db_connect();
		$product_cart_fetch = $db->query("SELECT * FROM `product_cart` WHERE `cid` = '".$cid."'");
	  $product_fetch = $product_cart_fetch->getRowArray();
	  return $product_fetch;
	}

	public function insertodbc($dic_name)
	{	
		$user = "admin"; 
    $password = "the2eS9t";
    $database = "mtb";
    $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

			$result_comp=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name'");    	
     	return $result_comp;
	}

	public function insert_prod_1($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$discount_8weeks_amount)
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
        'total_8weeksdiscount_amt' => ''
      ]);
   });
   $results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$discount_8weeks_amount,$discount_8weeks_amount);  
      return $results;  
	}

	public function odbc_discount($dic_name_8)
	{	
		$user = "admin"; 
    $password = "the2eS9t";
    $database = "mtb";
    $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

		$fetch_final_discount_8=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name_8'");   	
    return $fetch_final_discount_8;
	}



	public function insert_prod_2($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$discount_8weeks_amount)
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
        'total_8weeksdiscount_amt' => ''
      ]);
   });
   $results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$discount_8weeks_amount,$discount_8weeks_amount);  
      return $results;  
	}

	public function insert_product_cart_discount_items($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$discount_8weeks_amount)
	{
		$db = db_connect();
    $sqlq = $db->prepare(static function ($db) {
      return $db->table('product_cart_discount_items')->insert([
        'cart_id' => '',
        'cid'   => '',
        'product' => '',
        'discount_name' => '',
        'discount' => '',
        'discount_price' => '',
        'total_discount_price' => ''
      ]);
   });
   $results = $sqlq->execute($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$discount_8weeks_amount,$discount_8weeks_amount);  
      return $results;
	}

	public function insertocart($dic_name_ind)
	{	
		$user = "admin"; 
    $password = "the2eS9t";
    $database = "mtb";
    $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

		$fetch_final_discount_8=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name_ind'");;   	
    return $fetch_final_discount_8;
	}


	public function insert_prod_3($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus)
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
        'discount8weeks_status' => ''
      ]);
   });
   $results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus);  
      return $results;  
	}

	public function insert_product_cart_with_discount($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$discount)
	{
		 $db = db_connect();
      $sqlq = $db->prepare(static function ($db) {
      return $db->table('product_cart_discount_items')->insert([
        'cart_id' => '',
        'cid'   => '',
        'product' => '',
        'discount_name' => '',
        'discount' => '',
        'discount_price' => '',
        'total_discount_price' => '',
      ]);
   });
   $results = $sqlq->execute($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$discount,$discount);  
      return $results;
	}

	public function insert_prod_4($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$mstatus)
	{
		 $db = db_connect();
      $sqlq = $db->prepare(static function ($db) {
      return $db->table('product_cart')->insert([
        'cid' => '',
        'product'   => '',
        'description'   => '',
        'lprice' => '',
        'qty' => '',
        'price' => '',
        'totalprice' => '',
        'currency' => '',
        'sp_price' => '',
        'discount8weeks_status' => ''
      ]);
   });
   $results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$mstatus);  
      return $results;
	}

	

	// recommended items start here

	public function add_to_cart_recom($pno)
	{
		$db = db_connect();
	  	$query   = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` = '".$pno."' ");
	  	$sql_avil = $query->getRowArray();
	  	return $sql_avil;	
	}

	public function check_avail_stock_recom($pno)
	{
		$db = db_connect();
	  $query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = '" . $pno . "'");
	  $check_avl = $query->getRowArray();
	  return $check_avl;	
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

	public function check_new_gp_report_recomm()
	{	
		$db = db_connect();
	  	$check_gp_report = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` LIKE 'Discount%'");
	  	$chck_new_gp_report = $check_gp_report->getResultArray();
	  	return $chck_new_gp_report;
	}


	public function check_new_insert_product_cart_1($cid, $Part_Number, $Description, $lprice, $qty, $price, $totalprice, $curl, $sp_price, $discount_name_t, $discount_t, $mstatus, $discount_8weeks_amount)
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
        'discount_name' => '',
        'discount' => '',
        'discount8weeks_status' => '',
        'discount_8weeks_amount' => '',
        'total_8weeksdiscount_amt' => ''
      	]);
   	});
   	$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$discount_name_t,$discount_t,$mstatus,$discount_8weeks_amount,$discount_8weeks_amount); 
	}

	public function check_new_insert_product_cart_2($cid, $Part_Number, $Description, $lprice, $qty, $price, $totalprice, $curl, $sp_price, $discount_name_t, $mstatus, $discount_8weeks_amount)
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
	        'discount_name' => '',
	        'discount8weeks_status' => '',
	        'discount_8weeks_amount' => '',
	        'total_8weeksdiscount_amt' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$discount_name_t,$discount_t,$mstatus,$discount_8weeks_amount,$discount_8weeks_amount);  
      	return $results;
	}

	public function insert_recomm_odbc($cid,$pno)
	{
     	$user = "admin"; 
	    $password = "the2eS9t";
	    $database = "mtb";
	    $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
	    $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

		$result_comp=odbc_exec($conn_odbc,"SELECT APPLY,DISCOUNT FROM [ARCUSTSTK] 
            INNER JOIN [INVENTRY] ON [ARCUSTSTK].TREE_PATH = [INVENTRY].TREE_PATH 
            WHERE [ARCUSTSTK].CUST_ID = '".$cid."'
            AND [INVENTRY].ID='".$pno."'");    	
	     return $result_comp;
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

	public function check_product_by_cid($cid)
	{	
		$db = db_connect();
	  	$check_prod_by_cid = $db->query("SELECT * FROM `product_cart` WHERE `cid` = '".$cid."'");
	  	$check_prod_by_cid = $check_prod_by_cid->getResultArray();
	  	return $check_prod_by_cid;
	}

	public function check_discount_on_odbc_index_1($dic_name)
	{
		$user = "admin"; 
    $password = "the2eS9t";
    $database = "mtb";
  	$server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
  	$conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

  	$fetch_final_discount_8=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name'");   	
    	return $fetch_final_discount_8;
	}

	public function insert_product_cart_on_index_1($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount)
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

	public function check_discount_on_odbc_index_2($dic_name_8)
	{
		$user = "admin"; 
    $password = "the2eS9t";
    $database = "mtb";
  	$server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
  	$conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);

  	$fetch_final_discount_8=odbc_exec($conn_odbc,"select ID,TYPE from [mtb].[dbo].[INVENTRY] where [mtb].[dbo].[INVENTRY].ID='$dic_name_8'");   	
    	return $fetch_final_discount_8;
	}

	public function insert_product_cart_on_index_2($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$is_stock_dealer,$stock_dealer_discount)
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
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$disc_per_item,$is_stock_dealer,$stock_dealer_discount);
      	return $results;
	}

	public function insert_product_cart_on_index_3($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount)
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
      	$inserted_id = $db->insertID();
      	return $inserted_id;
	}

	public function insert_product_cart_discount_items_2($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart_discount_items')->insert(['cart_id' => '','cid' => '','product' => '', 'discount_name' => '','discount' => '','discount_price' => '','total_discount_price' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount);
      	return $results;
	}

	public function insert_product_cart_on_index_4($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$is_stock_dealer,$stock_dealer_discount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart')->insert([
	       	'cid' =>'', 'product' =>'',  'description' => '','lprice' =>'',  'qty' =>'',  'price' =>'',  'totalprice' =>'',  'currency' =>'', 'sp_price' =>'', 'discount' =>'', 'discount8weeks_status' =>'', 'is_stock_dealer' =>'', 'stock_dealer_discount' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount);
      	$inserted_id = $db->insertID();
      	return $inserted_id;
	}

	public function insert_product_cart_discount_items_3($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart_discount_items')->insert(['cart_id' => '','cid' => '','product' => '', 'discount_name' => '','discount' => '','discount_price' => '','total_discount_price' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount);
      	return $results;
	}

	public function insert_product_cart_on_index_5($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$mstatus,$is_stock_dealer,$stock_dealer_discount)
	{
		$db = db_connect();
    	$sqlq = $db->prepare(static function ($db) {
	    	return $db->table('product_cart')->insert([
	       	'cid' => '','product' => '', 'description' => '','lprice' => '', 'qty' => '', 'price' => '', 'totalprice' => '', 'currency' => '','sp_price' => '','discount8weeks_status' => '','is_stock_dealer' => '','stock_dealer_discount' => ''
	      	]);
   		});
   		$results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$mstatus,$is_stock_dealer,$stock_dealer_discount);
      	return $results;
	}


	// *****************************************billprint*****************************

	public function get_ebms_order_main($Auto_id)
	{
			$db = db_connect();
	    $query   = $db->query("SELECT array_data FROM `ebms_order_main` where AUTOID = '".$Auto_id."'");
	    $get_ebms_order_bill = $query->getRowArray();
	    return $get_ebms_order_bill;
	}

	// public function get_ebms_order_billing_details($Auto_id)
	// {
	// 		$db = db_connect();
	//     $query   = $db->query("SELECT * FROM `ebms_order_billing_details` where AUTOID= '".$Auto_id."'");
	//     $get_ebms_order_bill = $query->getRowArray();
	//     return $get_ebms_order_bill;
	// }



	// *****************************************billprint*****************************


	// *************************************getProduct**********************************

	public function get_product_details($pno)
	{
		$db = db_connect();
    $query   = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` = '".$pno."'");
    $get_ebms_order_bill = $query->getRowArray();
    return $get_ebms_order_bill;
	}


}