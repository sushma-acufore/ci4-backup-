<?php 
namespace App\Models\Cart;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class SaveCartAddress extends Model
{
	public function insert_shipping_address_request($cid,$first_name,$last_name,$phone_no,$email,$company_name,$address1,$address_2,$city,$state,$country,$pin_code)
	{
      	$db = db_connect();
		   	// Prepare the Query
			$pQuery = $db->prepare(static function ($db) {
			    return $db->table('shipping_address_request')->insert([
			        'cid'    => '',
			        'first_name'   => '',
			        'last_name' => '',
			        'phone_no' => '',
			        'email' => '',
			        'company_name' => '',
			        'address_1' => '',
			        'address_2' => '',
			        'city' => '',
			        'state' => '',
			        'country' => '',
			        'pin_code' => '',
			    ]);
			});

			// Run the Query
			$results = $pQuery->execute($cid,$first_name,$last_name,$phone_no,$email,$company_name,$address1,$address_2,$city,$state,$country,$pin_code);	
			return $results;
	}

	public function getproduct_cart($cid)
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
}