<?php 
namespace App\Models\Cart;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class UpdateCartItems extends Model
{
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

	public function update_product_cart($lprice,$qty,$price,$totalprice,$rid,$sp_price)
	{
		$db = db_connect();
		$model= $db->table('product_cart');
		$model->where('id', $rid)->set(['sp_price' => $sp_price,'lprice' => $lprice, 'qty' => $qty, 'price' => $price, 'totalprice' => $totalprice])->update();
	}
	public function update_product_cart_discount_items($disc_per_item,$total_discount_price,$rid)
	{
		$db = db_connect();
		$model= $db->table('product_cart_discount_items');
		$model->where('cart_id', $rid)->set(['discount_price' => $disc_per_item,'total_discount_price' => $total_discount_price])->update();
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
}