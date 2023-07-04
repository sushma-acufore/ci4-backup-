<?php 
namespace App\Models;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class MyordersView extends Model
{	
	// order view function 
	public static function get_ebms_bill_main($Auto_id)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `ebms_order_main` where `AUTOID`='$Auto_id'");
	    $check_items = $query->getResultArray();
	    return $check_items;
	}

	public static function get_ebms_bill_child($Auto_id)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `ebms_order_child` WHERE `AUTOID` = '$Auto_id'");
	    $result_t = $query->getResultArray();
	    return $result_t;
	}

	public static function get_ebms_order_billing_details($Auto_id)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `ebms_order_billing_details` where `AUTOID` = '$Auto_id'");
	    $resultn = $query->getRowArray();
	    return $resultn;
	}
	
	public static function get_ebms_order_discount_items($Auto_id)
	{
		$db = db_connect();
		$query   = $db->query("select * from ebms_order_discount_items where ebms_child_id='$rid'");
	    $check_items = $query->getResultArray();
	    return $check_items;
	}


	public static function getproduct_cart_discount_items($rid)
	{
		$db = db_connect();
		$query   = $db->query("select * from ebms_order_discount_items where ebms_child_id= '".$rid."'");
	    $results = $query->getResultArray();
	    return $results;   
	}
	public static function getproduct_cart_discount_items_count($rid)
	{
	    $db = db_connect();
		$count = $db->table('ebms_order_discount_items')->getWhere(['ebms_child_id' => $rid]);
       	return $count->getNumRows();
	}


}