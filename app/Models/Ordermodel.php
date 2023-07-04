<?php 
namespace App\Models;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class Ordermodel extends Model
{
	public function __construct()
	{
	}

	public static function getproduct_cart_discount_items_count($rid)
	{
	    $db = db_connect();
		$count = $db->table('product_cart_discount_items')->getWhere(['cart_id' => $rid]);
       	return $count->getNumRows();
	}

	public static function getproduct_cart_discount_items($rid)
	{
		$db = db_connect();
		$query   = $db->query("select * from product_cart_discount_items where cart_id= '".$rid."'");
	    $results = $query->getResultArray();
	    return $results;   
	}


	public static function geteaglecust_eid($eid)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `eagle_customer` WHERE EID = '".$eid."'");
	    $results = $query->getResultArray();
	    return $results;
	}

	public function getSearchedProducts($search)
	{
	    $db = db_connect();
	    $query   = $db->query("SELECT * FROM `gp_report` WHERE status='Active' and `Part_Number` like '".$search."%' ORDER BY id ASC LIMIT 10");
	    $searched_result = $query->getResultArray();
	    return $searched_result;
	}

	public function sql_avl($Part_Number)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = 
	    	'".$Part_Number."' ");
	    $sql_avil = $query->getResultArray();
	    return $sql_avil;
	}



	public static function getDescription($pno)
	{
		$db = db_connect();
	    $query   = $db->query("select Description FROM `gp_report` WHERE `Part_Number` = '".$pno."'");
	    $results = $query->getRowArray();
	    return $results;
	}

	public static function getStkDiscount($pno,$cid)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `product_cart` WHERE `product`= '".$pno."' AND `cid` = '".$cid."'");
	    $results = $query->getRowArray();
	    return $results;
	}

	public static function getcompid($part_no)
	{	
	$user = "admin"; 
    $password = "the2eS9t";
    $database = "mtb";
    $server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
    $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);
    $qry_comp = "SELECT COMP_ID FROM [INVENACC] WHERE [INVENACC].COMP_ID!='' and [INVENACC].ID = '".$part_no."';";
    $result_comp = odbc_exec($conn_odbc,$qry_comp);
    return $result_comp;
	}

	public static function getgp_comp($COMP_ID)
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` = '".$COMP_ID."' ");
	    $sql_avil = $query->getResultArray();
	    return $sql_avil;
	}

	public static function addToCartProduct($cid)
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `product_cart` WHERE `cid` = '".$cid."'");
	    $addToCartPro = $query->getRowArray();
	    return $addToCartPro;
	}

	public function updateProductCart($row_id,$lprice,$qty,$price,$totalprice,$curl,$total_8weeksdiscount_amt,$cid,$Part_Number)
	{
	$db = db_connect();
		$model= $db->table('product_cart');
		$model->where('id', $row_id)->
		set('lprice',$lprice,
			'qty',$qty,
			'$price', $price,
			'totalprice',$totalprice, 
			'curl', $curl,
			'total_8weeksdiscount_amt', $total_8weeksdiscount_amt,
			'cid', $cid,
			'Part_Number', $Part_Number)->update();
	}

	public static function updateProduct($cid)
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `product_cart` WHERE `cid` = '".$cid."' ");
	    $updateproduct = $query->getRowArray();
	    return $updateproduct;
	}

	public static function fetch_gp_report()
	{	
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` LIKE 'Discount%'");
	    $fetch_gp = $query->getRowArray();
	    return $fetch_gp;
	}



	/******************************cart start*****************************************/
	public static function getproduct_count($cid)
	{
		$db = db_connect();
		$query   = $db->query("select count(*) as count from product_cart where cid='$cid'");
	    $results = $query->getRowArray();
	    return $results;   
	}

	public function getproduct_cid($cid)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `product_cart` where `cid`= '".$cid."'");
	    $results = $query->getResultArray();
	    return $results;   
	}
	public function geteagle_available_stock($product)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = '" . $product . "'");
	    $results = $query->getRowArray();
	    return $results;   
	}
	public function getproduct_cart($cid)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `product_cart` where `cid`= '".$cid."'");
	    $results = $query->getResultArray();
	    return $results;   
	}

	public function getproduct_cart_countAll($cid)
	{
		//$db = db_connect();
		// $builder   = $db->table('product_cart');
		// $all_rows = $builder->countAll();
		// return $all_rows;   
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
		$qry5 = "SELECT * FROM [ARSHIP] WHERE ID = '".$cid."'";
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
		$qry_more = "SELECT * FROM [ARCUST] WHERE ID = '".$ship_id."'";
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
		$qry5 = "SELECT * FROM [ARCUST] WHERE ID = '".$ship_id."'";
            $result5 = odbc_exec($conn_odbc,$qry5);
	    return $result5;   
	}

	
	public function delete_product_cid($id)
	{
		$db = db_connect();
		$builder = $db->table('product_cart');
		$builder->where('cid', $id);
		$result = $builder->delete();
		return $result;
	}
	public function delete_product_id($id)
	{
		$db = db_connect();
		$builder = $db->table('product_cart');
		$builder->where('id', $id);
		$result = $builder->delete();
		return $result;
	}

	public function product_cart_id($cid)
	{
		//$db = db_connect();
		// $builder   = $db->table('product_cart');
		// $all_rows = $builder->countAll();
		// return $all_rows;   
		$db = db_connect();
		$count = $db->table('product_cart')->getWhere(['cid' => $cid]);
       	return $count->getNumRows();
	}

	public function getproduct_by_rid($rid)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `product_cart` where `id`= '".$rid."'");
	    $results = $query->getResultArray();
	    return $results;
	}
	public function getgp_report($pno)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` = '".$pno."' ");
	    $results = $query->getRowArray();
	    return $results;
	}
	public function update_product_cart($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid)
	{
		$db = db_connect();
		$model= $db->table('product_cart');
		$model->where('id', $rid)->set(['lprice' => $lprice, 'qty' => $qty, 'price' => $price, 'totalprice' => $totalprice, 'total_8weeksdiscount_amt' => $total_8weeksdiscount_amt])->update();
	}
	public function update_product_cart1($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid)
	{
		$db = db_connect();
		$model= $db->table('product_cart');
		$model->where('id', $rid)->set(['lprice' => $lprice, 'qty' => $qty, 'price' => $price, 'totalprice' => $totalprice, 'total_8weeksdiscount_amt' => $total_8weeksdiscount_amt])->update();
	}
	public function update_product_cart2($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid)
	{
		$db = db_connect();
		$model= $db->table('product_cart');
		$model->where('id', $rid)->set(['lprice' => $lprice, 'qty' => $qty, 'price' => $price, 'totalprice' => $totalprice, 'total_8weeksdiscount_amt' => $total_8weeksdiscount_amt])->update();
	}
/******************************cart end*****************************************/

/******************************preview start*****************************************/

public static function getproduct_for_preview($cid)
{
	$db = db_connect();
    $query   = $db->query("SELECT * FROM `product_cart` where `cid`= '".$cid."'");
    $results = $query->getResultArray();
    return $results;
}
public static function geteagle_available_stock_for_preview($product)
{
	$db = db_connect();
    $query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = '" . $product . "'");
    $results = $query->getRowArray();
    return $results;
}

public function insert_ebms_order_main($AUTOID,$INVOICE,$json_data1,$totalprice,$curr_date,$artostr)
{
        $db = db_connect();
	   	// Prepare the Query
		$pQuery = $db->prepare(static function ($db) { return $db->table('ebms_order_main')->insert([ 'AUTOID' => '','INVOICE' => '','cid' => '', 'totalprice' => '', 'date_time' => '', 'array_data' => '']);});
		// Run the Query
		$results = $pQuery->execute($AUTOID,$INVOICE,$json_data1,$totalprice,$curr_date,$artostr);	
		return $results;
		 /*$sql_main = " INSERT INTO `ebms_order_main`(`AUTOID`,`INVOICE`,`cid`, `totalprice`, `date_time`, `array_data`) VALUES ('$AUTOID','$INVOICE','".$json_data1['ID']."','$totalprice','$curr_date','$artostr')";
                    mysqli_query($conn,$sql_main);*/
}


public function insert_ebms_order_billing_details($AUTOID,$INVOICE,$json_data1,$C_NAME,$C_ADDRESS1,$C_CITY,$C_STATE,$C_COUNTRY,$C_ZIP,$SALESMAN,$SALESMAN_Field,$PO_NO,$SHIP_DATE,$SHIP_VIA,$TERMS,$TAX,$TOTAL_SO,$GRACE,$CHARGE,$DISCOUN,$curr_date)
{
        $db = db_connect();
	   	// Prepare the Query
		$pQuery = $db->prepare(static function ($db) { return $db->table('ebms_order_billing_details')->insert(['AUTOID' => '','INVOICE' => '','cid' => '', 'C_NAME' => '', 'C_ADDRESS1' => '', 'C_CITY' => '','C_STATE' => '', 'C_COUNTRY' => '', 'C_ZIP' => '','SALESMAN' => '', 'SALESMAN_Field' => '', 'PO_NO' => '','SHIP_DATE' => '', 'SHIP_VIA' => '', 'TERMS' => '','TAX' => '', 'TOTAL_SO' => '','GRACE' => '', 'CHARGE' => '','DISCOUN' => '','created_on' => '' ]);});
		// Run the Query
		$results = $pQuery->execute($AUTOID,$INVOICE,$json_data1,$C_NAME,$C_ADDRESS1,$C_CITY,$C_STATE,$C_COUNTRY,$C_ZIP,$SALESMAN,$SALESMAN_Field,$PO_NO,$SHIP_DATE,$SHIP_VIA,$TERMS,$TAX,$TOTAL_SO,$GRACE,$CHARGE,$DISCOUN,$curr_date);	
		return $results;
}

public function insert_preview_order($AUTOID,$INVOICE,$json_data1,$product,$description,$lprice,$qty,$sp_price,$price,$discount_name,$discount,$totalprice,$currency,$discount8weeks_status,$artostr)
{
        $db = db_connect();
	   	// Prepare the Query
		$pQuery = $db->prepare(static function ($db) { return $db->table('preview_order')->insert(['AUTOID' => '','INVOICE' => '','cid' => '', 'product' => '', 'description' => '', 'lprice' => '', 'qty' => '', 'sp_price' => '', 'price' => '', 'discount_name' => '', 'discount' => '', 'totalprice' => '', 'currency' => '', 'discount8weeks_status' => '', 'array_data' => '']);});
		// Run the Query
		$results = $pQuery->execute($AUTOID,$INVOICE,$json_data1,$product,$description,$lprice,$qty,$sp_price,$price,$discount_name,$discount,$totalprice,$currency,$discount8weeks_status,$artostr);	
		return $results;
}

public function insert_ebms_order_child($AUTOID,$INVOICE,$json_data1,$product,$description,$lprice,$qty,$sp_price,$price,$discount_name,$discount,$totalprice,$currency,$discount8weeks_status,$discount_8weeks_amount,$total_8weeksdiscount_amt)
{
        $db = db_connect();
	   	// Prepare the Query
		$pQuery = $db->prepare(static function ($db) { return $db->table('ebms_order_child')->insert(['AUTOID' => '','INVOICE' => '', 'cid' => '', 'product' => '', 'description' => '', 'lprice' => '', 'qty' => '', 'sp_price' => '', 'price' => '', 'discount_name' => '', 'discount' => '', 'totalprice' => '', 'currency' => '', 'discount8weeks_status' => '','discount_8weeks_amount' => '','total_8weeksdiscount_amt' => '']);});
		// Run the Query
		$results = $pQuery->execute($AUTOID,$INVOICE,$json_data1,$product,$description,$lprice,$qty,$sp_price,$price,$discount_name,$discount,$totalprice,$currency,$discount8weeks_status,$discount_8weeks_amount,$total_8weeksdiscount_amt);	
		return $results;

}
	
/******************************preview end*****************************************/

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


public static function check_product_cart_index($cid)
{
    $db = db_connect();
    $query   = $db->query("SELECT * FROM `product_cart` where `cid`= '".$cid."'");
    $results = $query->getResultArray();
    return $results;
}

public static function check_eagle_available_stock($product)
{
		$db = db_connect();
    $query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = '" . $product . "'");
    $results = $query->getRowArray();
    return $results;
}


public function check_product_in_8weeks_index($pno,$cid)
{
 	$db = db_connect();
  $query   = $db->query("SELECT * FROM `product_cart` WHERE `product`= '".$pno."' AND `cid` = '".$cid."' ");
  $results = $query->getResultArray();
  if($results>0)
	{
	    $status2 = 0;
	    $stock_discount = 0;
	}
	return $results;
}


// ***********************************update cart index****************//

	public static function update_index_cart_check_cid($rid)
	{
		$db = db_connect();
  	$query   = $db->query("SELECT * FROM `product_cart` WHERE `id` = '".$rid."' ");
  	$results = $query->getResultArray();
  	return $results;
	}

	public static function fetch_list_price($pno)
	{
		$db = db_connect();
  	$query = $db->query("SELECT * FROM `gp_report` WHERE `Part_Number` = '".$pno."' ");
  	$results = $query->getRowArray();
  	return $results;
	}

	public function update_product_cart_index($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid)
	{
		$db = db_connect();
		$model= $db->table('product_cart');
		$model->where('id', $rid)->set(['lprice' => $lprice, 'qty' => $qty, 'price' => $price, 'totalprice' => $totalprice, 'total_8weeksdiscount_amt' => $total_8weeksdiscount_amt])->update();
	}

	public function update_product_cart_index_2($lprice,$qty,$price,$totalprice,$total_8weeksdiscount_amt,$rid)
	{
		$db = db_connect();
		$model= $db->table('product_cart');
		$model->where('id', $rid)->set(['lprice' => $lprice, 'qty' => $qty, 'price' => $price, 'totalprice' => $totalprice, 'total_8weeksdiscount_amt' => $total_8weeksdiscount_amt])->update();
	}

// ***********************************update cart index****************//


// ***********************************delete cart index****************//

public function delete_cart_index($id)
{
	$db = db_connect();
  $query   = $db->query("DELETE FROM `product_cart` WHERE `id` = '".$id."' ");
  return $query;		
}

public function delete_cart_index_2($cid)
{
	$db = db_connect();
  $query   = $db->query("select * from `product_cart` where cid='$cid'");
  return $query;		
}


// ***********************************delete cart index****************//


// ***********************************stock register****************//

public function insert_stock_register($part_number,$firstname,$cid,$email,$intended_stocking_quantity)
{	
	$db = db_connect();
	// Prepare the Query
	$pQuery = $db->prepare(static function ($db) {
	    return $db->table('stock_dealer_request')->insert([
	      'part_number' => '', 'first_name' => '', 'customer_id' => '', 'email' => '',
	      'intended_stocking_quantity' => ''
	    ]);
	});

	// Run the Query
	$results = $pQuery->execute($part_number,$firstname,$cid,$email,$intended_stocking_quantity);	
	return $results;
}

// ***********************************stock register****************//

	

}	



?>