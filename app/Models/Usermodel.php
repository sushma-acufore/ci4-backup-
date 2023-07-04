<?php 
namespace App\Models;
use CodeIgniter\Model;
use DB;
use CodeIgniter\Database\Query;
use PDO;
class Usermodel extends Model
{
	public function __construct()
	{

	}

	public function testodbc()
	{
		$user = "admin"; 
		$password = "the2eS9t";
		$database = "mtb";
		$server = "mtb.c2ehjrbp8dec.ca-central-1.rds.amazonaws.com,1432";
	    $conn_odbc = odbc_connect("Driver={ODBC Driver 17 for SQL Server};Server=$server;Database=$database;", $user, $password);
	    
	    $qry5 = "SELECT DISCOUNT,EP_DISC FROM [ARCUSTSTK] INNER JOIN [INVENTRY] ON [ARCUSTSTK].TREE_PATH = [INVENTRY].TREE_PATH WHERE [ARCUSTSTK].CUST_ID = 'TEST2' AND [INVENTRY].ID='TRL620D';";
	    $result5 = odbc_exec($conn_odbc,$qry5);
	    $num_rows2 = odbc_num_rows($result5);
        while($dt5 = odbc_fetch_array($result5))
        {
            $stock_discount = (float)$dt5['DISCOUNT'];
        }
        return $stock_discount;

	}


/*
	//set of records
	public static function getdata()
	{
		$db = db_connect();
		$query   = $db->query('SELECT * FROM fullname');
		$results = $query->getResultArray();
        return $results;
	}
	//single record
	public static function getsingledata()
	{	
		$db = db_connect();
        $query   = $db->query('SELECT * FROM fullname');
        $results = $query->getRowArray();
        return $results;
	}
	//insert record
	public static function insertdata($x)
	{	
		$db = db_connect();
       	// Prepare the Query
		$pQuery = $db->prepare(static function ($db) {
		    return $db->table('fullname')->insert([
		        'name'    => '',
		        'surname'   => '',
		        'email' => '',
		    ]);
		});

		// Collect the Data
		$name    = 'John Doe';
		$surname   = 'j.doe@example.com';
		$email = $x;

		// Run the Query
		$results = $pQuery->execute($name, $surname, $email);	
	}
	
	//update record
	public static function updatedata()
	{	
		$db = db_connect();
		$model= $db->table('fullname');
		$model->where('name', 'John Doe')->set('name', 'test')->update();
	}

	*/
}

    

?>