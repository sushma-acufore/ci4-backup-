<?php 
namespace App\Controllers\Cart;
use App\Models\SavePreviewDetails;
use CodeIgniter\Controller;

class SavePreviewDetailsController extends BaseController
{
	protected $SavePreviewDetails;
	public function __construct()
	{
	    \Config\Services::session();
        $this->save_preview_details = new SavePreviewDetails();
	}

	public function save_preview_details()
    {
        echo "here";
    }
}