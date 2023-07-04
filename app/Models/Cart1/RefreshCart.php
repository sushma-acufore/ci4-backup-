<?php 
namespace App\Models\Cart;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class RefreshCart extends Model
{
	public function getproduct_cid($cid)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `product_cart` where `cid`= '".$cid."'");
	    $results = $query->getResultArray();
	    return $results;   
	}

	public static function product_cart_discount_items($rid)
	{
    $db = db_connect();
    $query   = $db->query("select * from product_cart_discount_items where cart_id= '".$rid."'");
    $results = $query->getNumRows();
    return $query;
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
}