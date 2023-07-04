<?php 
namespace App\Models\Search;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class UpdateCart extends Model
{
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
}