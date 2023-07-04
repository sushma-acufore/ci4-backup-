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
	public function getproduct_cart_sum($cid)
	{
		$db = db_connect();
		$query   = $db->query("SELECT sum(totalprice) as totalprice FROM `product_cart` where `cid`= '".$cid."'");
	    $results = $query->getRowArray();
	    return $results;   
	}
	public function getproduct_cart_total_discount_price($cid)
	{
		$db = db_connect();
		$query   = $db->query("SELECT sum(total_discount_price) as total_discount_price FROM `product_cart_discount_items` where `cid`= '".$cid."'");
	    $results = $query->getRowArray();
	    return $results;   
	}
	public function getproduct_cart_discount_items($rid)
	{
		$db = db_connect();
		$query   = $db->query("select * from product_cart_discount_items where cart_id= '".$rid."'");
	    $results = $query->getResultArray();
	    return $results;   
	}
	public function getproduct_cart_discount_items_count($rid)
	{
	    $db = db_connect();
		$count = $db->table('product_cart_discount_items')->getWhere(['cart_id' => $rid]);
       	return $count->getNumRows();
	}
}