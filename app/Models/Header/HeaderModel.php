<?php 
namespace App\Models\Header;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class HeaderModel extends Model
{
	public function getproduct_by_cid($cid)
	{
	    $db = db_connect();
	    $query   = $db->query("SELECT * FROM `product_cart` where `cid`= '".$cid."'");
	    $results = $query->getResultArray();
	    return $results;
	}

	public function getTotal_cid($cid)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT SUM(totalprice) FROM `product_cart` where `cid` = '".$cid."'");
	    $results = $query->getRowArray();
	    return $results;
	}

	public static function getebms_order_main($eid)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `ebms_order_main` where `cid`= '".$eid."' order by id desc");
	    $results = $query->getResultArray();
	    return $results;
	}

	public static function getgetTotal($cid)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT SUM(totalprice) FROM `ebms_order_main` where `cid` = '".$cid."'");
	    $results = $query->getRowArray();
	    return $results;
	}

	public static function getLoggedInUser($cid)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `eagle_customer` WHERE EID = '".$cid."'");
	    $results = $query->getRowArray();
	    return $results;
	}

	public static function getebms_order($cid)
	{
		$db = db_connect();
	    $query= $db->query("select * from ebms_order_main where cid='$cid' order by id desc"); 
	    $check_items = $query->getResultArray();
	    return $check_items;
	}

	public static function getebms_order1($AUTOID ,$cid)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `ebms_order_billing_details` WHERE `AUTOID` = '".$AUTOID."' and cid='$cid' ");
	  $result1 = $query->getRowArray();
	   return $result1;
	}

	public static function getebms_order2($AUTOID ,$cid)
	{
		$db = db_connect();
		$count = $db->table('ebms_order_child')->getWhere(['cid' => $cid, 'AUTOID' => $AUTOID]);
	   	return $count->getNumRows();
	}

	public static function getebms_order2a($AUTOID ,$cid)
	{
		$db = db_connect();
		$query   = $db->query("select count(*) as count, date_time from ebms_order_child where AUTOID='$AUTOID' and cid='$cid'");
	    $check_items = $query->getRowArray();
	    return $check_items;
	}

}