<?php 
namespace App\Models\Search;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class AddToCart extends Model
{	
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
	    $getProduct = $query->getNumRows();
	    return $query;
	}

	public function check_product_by_cid($cid)
	{	
		$db = db_connect();
	  	$check_prod_by_cid = $db->query("SELECT * FROM `product_cart` WHERE `cid` = '".$cid."'");
	  	//$check_prod_by_cid = $check_prod_by_cid->getNumRows();
	  	return $check_prod_by_cid;
	}

	public function upate_product_cart($row_id,$lprice,$sp_price,$qty,$price,$totalprice,$curl)
	{
		$db = db_connect();
    $update_product=$db->table('product_cart')->where('id', $row_id)->set(["lprice" => $lprice, "sp_price" => $sp_price, "qty" => $qty, "price" => $price, "totalprice" => $totalprice, "currency" => $curl])->update();
    return $update_product;       
	}

	public function upate_product_discount_items($row_id,$disc_per_item,$total_discount_price)
	{
		return $row_id;
		// $db = db_connect();
    	// $update_product=$db->table('product_cart_discount_items')->where('cart_id', $row_id)->set(["discount_price" => $disc_per_item, "total_discount_price" => $total_discount_price])->update();
    	// return $update_product;       
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

	public function insert_product_cart_on_index_1($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount)
	{
		$db = db_connect(); 
		$builder = $db->table('product_cart');
		$data = [
			'cid' => $cid,
			'product'   => $Part_Number,
			'description' => $Description,
			'lprice' => $lprice,
			'qty' => $qty,
			'price' => $price,
			'totalprice' => $totalprice,
			'currency' => $curl,
			'sp_price' => $sp_price,
			'discount' => $TYPE,
			'discount8weeks_status' => $mstatus,
			'discount_8weeks_amount' => $disc_per_item,
			'total_8weeksdiscount_amt' => $discount_8weeks_amount,
			'is_stock_dealer' => $is_stock_dealer,
			'stock_dealer_discount' => $stock_dealer_discount
				
		];
		$builder->insert($data);
		$insert_id=$db->insertID();
		return $insert_id;

	}

	
	public function insert_product_cart_on_index_2($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount)
	{
	$db = db_connect(); 
	$builder = $db->table('product_cart');
	$data = [
		'cid' => $cid,
		'product'   => $Part_Number,
		'description' => $Description,
		'lprice' => $lprice,
		'qty' => $qty,
		'price' => $price,
		'totalprice' => $totalprice,
		'currency' => $curl,
		'sp_price' => $sp_price,
		'discount' => $TYPE,
		'discount8weeks_status' => $mstatus,
		'discount_8weeks_amount' => $disc_per_item,
		'total_8weeksdiscount_amt' => $discount_8weeks_amount,
		'is_stock_dealer' => $is_stock_dealer,
		'stock_dealer_discount' => $stock_dealer_discount		
	];
	$builder->insert($data);
	$insert_id=$db->insertID();
	return $insert_id;
   		// $results = $sqlq->execute($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$disc_per_item,$is_stock_dealer,$stock_dealer_discount);
      	
	}

	public function insert_product_cart_discount_items($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount)
	{
	$db = db_connect();
	$builder = $db->table('product_cart_discount_items');
	$data_disc = [
		'cart_id' => $cart_id,
		'cid'   => $cid,
		'product' => $Part_Number,
		'discount_name' => $discount_name_fin,
		'discount' => $TYPE,
		'discount_price' => $disc_per_item,
		'total_discount_price' => $discount_8weeks_amount
	];

	$builder->insert($data_disc);
	$insert_id=$db->insertID();
	return $insert_id;
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

	public function insert_product_cart_on_index_3($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$disc_per_item,$discount_8weeks_amount,$is_stock_dealer,$stock_dealer_discount)
	{
		  $db = db_connect(); 
		  $builder = $db->table('product_cart');
		  $data = [
			  'cid' => $cid,
			  'product'   => $Part_Number,
			  'description' => $Description,
			  'lprice' => $lprice,
			  'qty' => $qty,
			  'price' => $price,
			  'totalprice' => $totalprice,
			  'currency' => $curl,
			  'sp_price' => $sp_price,
			  'discount' => $TYPE,
			  'discount8weeks_status' => $mstatus,
			  'discount_8weeks_amount' => $disc_per_item,
			  'total_8weeksdiscount_amt' => $discount_8weeks_amount,
			  'is_stock_dealer' => $is_stock_dealer,
			  'stock_dealer_discount' => $stock_dealer_discount		
		  ];
		  $builder->insert($data);
		  $insert_id=$db->insertID();
		  return $insert_id;

	}

	public function insert_product_cart_discount_items_2($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount)
	{
		  $db = db_connect();
		  $builder = $db->table('product_cart_discount_items');
		  $data_disc = [
			  'cart_id' => $cart_id,
			  'cid'   => $cid,
			  'product' => $Part_Number,
			  'discount_name' => $discount_name_fin,
			  'discount' => $TYPE,
			  'discount_price' => $disc_per_item,
			  'total_discount_price' => $discount_8weeks_amount
		  ];
	  
		  $builder->insert($data_disc);
		  $insert_id=$db->insertID();
		  return $insert_id;

	}

	public function insert_product_cart_on_index_4($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$TYPE,$mstatus,$is_stock_dealer,$stock_dealer_discount)
	{
		  $db = db_connect();
		  $builder = $db->table('product_cart');
		  $data_disc = [
			'cid' =>$cid, 
			'product' =>$Part_Number,  
			'description' => $Description,
			'lprice' =>$lprice,  
			'qty' =>$qty,  
			'price' =>$price,  
			'totalprice' =>$totalprice,  
			'currency' =>$curl, 
			'sp_price' =>$sp_price, 
			'discount' =>$TYPE, 
			'discount8weeks_status' =>$mstatus, 
			'is_stock_dealer' =>$is_stock_dealer, 
			'stock_dealer_discount' => $stock_dealer_discount
		  ];
		  $builder->insert($data_disc);
		  $insert_id=$db->insertID();
		  return $insert_id;
	}

	public function insert_product_cart_discount_items_3($cart_id,$cid,$Part_Number,$discount_name_fin,$TYPE,$disc_per_item,$discount_8weeks_amount)
	{
		  $db = db_connect();
		  $builder = $db->table('product_cart_discount_items');
		  $data_disc = [
			  'cart_id' => $cart_id,
			  'cid'   => $cid,
			  'product' => $Part_Number,
			  'discount_name' => $discount_name_fin,
			  'discount' => $TYPE,
			  'discount_price' => $disc_per_item,
			  'total_discount_price' => $discount_8weeks_amount
		  ];
	  
		  $builder->insert($data_disc);
		  $insert_id=$db->insertID();
		  return $insert_id;

	}

	public function insert_product_cart_on_index_5($cid,$Part_Number,$Description,$lprice,$qty,$price,$totalprice,$curl,$sp_price,$mstatus,$is_stock_dealer,$stock_dealer_discount)
	{
		  $db = db_connect();
		  $builder = $db->table('product_cart');
		  $data_disc = [
			'cid' =>$cid, 
			'product' =>$Part_Number,  
			'description' => $Description,
			'lprice' =>$lprice,  
			'qty' =>$qty,  
			'price' =>$price,  
			'totalprice' =>$totalprice,  
			'currency' =>$curl, 
			'sp_price' =>$sp_price, 
			'discount8weeks_status' =>$mstatus, 
			'is_stock_dealer' =>$is_stock_dealer, 
			'stock_dealer_discount' => $stock_dealer_discount
		  ];
		  $builder->insert($data_disc);
		  $insert_id=$db->insertID();
		  return $insert_id;
	}







}