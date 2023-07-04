<?php 
namespace App\Models\Cart;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class SaveCartAddress extends Model
{
	
	public function insert_shipping_address_request($cid,$first_name,$last_name,$po_number,$phone_no,$email,$company_name,$address_1,$address_2,$city,$state,$country,$pin_code,$note){
		$flag=0;
		$db = db_connect();
		$builder = $db->table('shipping_address_request');
		$data = [
			'cid'    => $cid,
			'first_name'   => $first_name,
			'last_name' => $last_name,
			'po_number' => $po_number,
			'phone_no' => $phone_no,
			'email' => $email,
			'company_name' => $company_name,
			'address_1' => $address_1,
			'address_2' => $address_2,
			'city' => $city,
			'state' => $state,
			'country' => $country,
			'pin_code' => $pin_code,
			'note' => $note
		];
		$builder->insert($data);
		$insert_id=$db->insertID();
		
		if($insert_id>0){
			$flag=1;
		}
		else 
		{
			$flag=0;
		}
		return $flag;
	}

	public function insert_shipping_address_request2($cid,$first_name,$last_name,$phone_no,$email,$company_name,$address1,$address_2,$city,$state,$country,$pin_code,$note,$po_number)
	{

		$db = db_connect();
		   	// Prepare the Query
			$pQuery = $db->prepare(static function ($db) {
			    return $db->table('shipping_address_request')->insert([
			        'cid'    => '',
			        'first_name'   => '',
			        'last_name' => '',
			        'po_number' => '',
			        'phone_no' => '',
			        'email' => '',
			        'company_name' => '',
			        'address_1' => '',
			        'address_2' => '',
			        'city' => '',
			        'state' => '',
			        'country' => '',
			        'pin_code' => '',
			        'note' => '',
			    ]);
			});

			// Run the Query
			$results = $pQuery->execute($cid,$first_name,$last_name,$po_number,$phone_no,$email,$company_name,$address_1,$address_2,$city,$state,$country,$pin_code,$note);	
			return $results;
	}

	public function getproduct_cart($cid)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `product_cart` where `cid`= '".$cid."'");
	    $results = $query->getResultArray();
	    return $results;   
	}
	public function getproduct_cart_count($cid)
	{
		$db = db_connect();
		$count = $db->table('product_cart')->getWhere(['cid' => $cid]);
       	return $count->getNumRows();  
	}

	public function geteagle_available_stock($product)
	{
		$db = db_connect();
		$query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = '" . $product . "'");
	    $results = $query->getRowArray();
	    return $results;   
	}
}