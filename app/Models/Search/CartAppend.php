<?php 
namespace App\Models\Search;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class CartAppend extends Model
{
	public static function check_product_cart_index($cid)
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

	public static function check_eagle_available_stock($product)
	{
		$db = db_connect();
    $query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = '" . $product . "'");
    $results = $query->getRowArray();
    return $results;
	}


}