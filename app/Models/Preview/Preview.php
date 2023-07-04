<?php 
namespace App\Models\Preview;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class Preview extends Model
{

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

	public function get_ebms_order_billing_details($Auto_id)
	{
		$db = db_connect();
    $query   = $db->query("SELECT * FROM `ebms_order_billing_details` where AUTOID= '".$Auto_id."'");
    $get_ebms_order_bill = $query->getRowArray();
    return $get_ebms_order_bill;
	}

	public function get_ebms_order_main_details($Auto_id)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `ebms_order_main` where AUTOID= '".$Auto_id."'");
		$get_ebms_order_bill = $query->getRowArray();
		return $get_ebms_order_bill;
	}

	public function getproduct_cid($cid)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `product_cart` where `cid`= '".$cid."'");
	    $results = $query->getNumRows();
	    return $query;   
	}

	public function insert_ebms_order_main($AUTOID,$INVOICE,$cid,$totalprice,$curr_date,$artostr)
	{
	        $db = db_connect();
			$builder = $db->table('ebms_order_main');
			$data = [
				'AUTOID' => $AUTOID,
				'INVOICE'   => $INVOICE,
				'cid' => $cid,
				'totalprice' => $totalprice,
				'date_time' => $curr_date,
				'array_data' => $artostr
			];
			$builder->insert($data);
			$insert_id=$db->insertID();
			return $insert_id;
		
	}

	public function insert_ebms_order_billing_details($AUTOID,$INVOICE,$cid,$C_NAME,$C_ADDRESS1,$C_CITY,$C_STATE,$C_COUNTRY,$C_ZIP,$SALESMAN,$SALESMAN_Field,$PO_NO,$SHIP_DATE,$SHIP_VIA,$TERMS,$TAX,$TOTAL_SO,$GRACE,$CHARGE,$DISCOUN,$curr_date,$billto_ADDRESS1,$billto_ADDRESS2,$billto_CITY,$billto_COUNTRY,$billto_STATE,$billto_ZIP)
	{
        $db = db_connect();
		$builder = $db->table('ebms_order_billing_details');
			$data = [
				'AUTOID' => $AUTOID,
				'INVOICE'   => $INVOICE,
				'cid' => $cid,
				'C_NAME' => $C_NAME,
				'C_ADDRESS1' => $C_ADDRESS1,
				'C_CITY' => $C_CITY,
				'C_STATE' => $C_STATE,
				'C_COUNTRY' => $C_COUNTRY,
				'C_ZIP' => $C_ZIP,
				'SALESMAN' => $SALESMAN,
				'SALESMAN_Field' => $SALESMAN_Field,
				'PO_NO' => $PO_NO,
				'SHIP_DATE' => $SHIP_DATE,
				'SHIP_VIA' => $SHIP_VIA,
				'TERMS' => $TERMS,
				'TAX' => $TAX,
				'TOTAL_SO' => $TOTAL_SO,
				'GRACE' => $GRACE,
				'CHARGE' => $CHARGE,
				'DISCOUN' => $DISCOUN,
				'created_on' => $curr_date,
				'BILLEDTO_ADDRESS1' => $billto_ADDRESS1,
				'BILLEDTO_CITY' => $billto_CITY,
				'BILLEDTO_STATE' => $billto_STATE,
				'BILLEDTO_COUNTRY' => $billto_COUNTRY,
				'BILLEDTO_ZIP' => $billto_ZIP
			];
			$builder->insert($data);
			$insert_id=$db->insertID();
			return $insert_id;
	}


	public function insert_ebms_order_child($AUTOID,$INVOICE,$cid,$product,$description,$lprice,$qty,$sp_price,$price,$discount_name,$discount,$totalprice,$currency,$discount8weeks_status,$discount_8weeks_amount,$total_8weeksdiscount_amt)
	{
	    $db = db_connect();
		$builder = $db->table('ebms_order_child');
		$data = [
			'AUTOID' => $AUTOID,
			'INVOICE'   => $INVOICE,
			'cid' => $cid,
			'product' => $product,
			'description' => $description,
			'lprice' => $lprice,
			'qty' => $qty,
			'sp_price' => $sp_price,
			'price' => $price,
			'discount_name' => $discount_name,
			'discount' => $discount,
			'totalprice' => $totalprice,
			'currency' => $currency,
			'discount8weeks_status' => $discount8weeks_status,
			'discount_8weeks_amount' => $discount_8weeks_amount,
			'total_8weeksdiscount_amt' => $total_8weeksdiscount_amt
		];
		$builder->insert($data);
		$insert_id=$db->insertID();
		return $insert_id;
	}

	public function insert_ebms_order_discount_items($ebms_child_id,$AUTOID,$INVOICE,$cid,$product,$discount_name,$discount,$discount_price,$total_discount_price){
		$db = db_connect();
		$builder = $db->table('ebms_order_discount_items');
		$data = [
			'ebms_child_id' => $ebms_child_id,
			'AUTOID'   => $AUTOID,
			'INVOICE'   => $INVOICE,
			'cid' => $cid,
			'product' => $product,
			'discount_name' => $discount_name,
			'discount' => $discount,
			'discount_price' => $discount_price,
			'total_discount_price' => $total_discount_price
		];
		$builder->insert($data);
		$insert_id=$db->insertID();
		return $insert_id;
	}

	public function delete_product_cid_preview($cid)
	{
		$db = db_connect();
		$builder = $db->table('product_cart');
		$builder->where('cid', $cid);
		$result = $builder->delete();
		
		$builder2 = $db->table('product_cart_discount_items');
		$builder2->where('cid', $cid);
		$result2 = $builder2->delete();
		return $result;
	}

}