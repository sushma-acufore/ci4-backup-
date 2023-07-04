<?php 
namespace App\Models\Cart;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class Cart extends Model
{
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

	public function delete_product_cid($id)
	{
		$db = db_connect();
		$builder = $db->table('product_cart');
		$builder->where('cid', $id);
		$result = $builder->delete();

		$builder2 = $db->table('product_cart_discount_items');
		$builder2->where('cid', $id);
		$result2 = $builder2->delete();
		return $result;

		
	}
	public function delete_product_cart_discount_items($id)
	{
		$db = db_connect();
		$builder = $db->table('product_cart_discount_items');
		$builder->where('cid', $id);
		$result = $builder->delete();
		return $result;
	}
	public function delete_product_cart_discount_items_cid($id)
	{
		$db = db_connect();
		$builder = $db->table('product_cart_discount_items');
		$builder->where('cart_id', $id);
		$result = $builder->delete();
		return $result;
	}

	public function delete_product_id($id)
	{
		$db = db_connect();
		$builder = $db->table('product_cart');
		$builder->where('id', $id);
		$result = $builder->delete();

		$builder2 = $db->table('product_cart_discount_items');
		$builder2->where('cart_id', $id);
		$result2 = $builder2->delete();

		return $result;
	}

	public function product_cart_id($cid)
	{  
		$db = db_connect();
		$count = $db->table('product_cart')->getWhere(['cid' => $cid]);
       	return $count->getNumRows();
	}
}
