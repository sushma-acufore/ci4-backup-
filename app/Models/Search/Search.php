<?php 
namespace App\Models\Search;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;

class Search extends Model
{
	public function getSearchedProducts($search)
	{
	    $db = db_connect();
	    $query   = $db->query("SELECT * FROM `gp_report` WHERE status='Active' and `Part_Number` like '".$search."%' ORDER BY id ASC LIMIT 10");
	    $searched_result = $query->getResultArray();
	    return $searched_result;
	}

	public function sql_avl($Part_Number)
	{
		$db = db_connect();
	    $query   = $db->query("SELECT * FROM `eagle_available_stock` where `Part_Number` = 
	    	'".$Part_Number."' ");
	    $sql_avil = $query->getResultArray();
	    return $sql_avil;
	}

}