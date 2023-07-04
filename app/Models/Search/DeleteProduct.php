<?php 
namespace App\Models\Search;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class DeleteProduct extends Model
{
	public function delete_cart_index($id)
	{
	  $db = db_connect();
	  $query   = $db->query("DELETE FROM `product_cart` WHERE `id` = '".$id."' ");
	  $query2   = $db->query("DELETE FROM `product_cart_discount_items` WHERE `cart_id` = '".$id."' ");
	  return $query2;		
	}

	public function delete_cart_index_2($cid)
	{
	  $db = db_connect();
	  $query   = $db->query("select * from `product_cart` where cid='$cid'");
	  return $query;		
	}

}