<?php include_once('header.php'); 

\Config\Services::session();
use App\Models\Ordermodel;
$ordmodel = new Ordermodel();
?>

<!-- my orders table start here-->
<div class="container myorder-container">
  <div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4">
      <button type="button" class="my-orders-btn-my-orders">My Orders</button>
    </div>
  </div>

  <div class="row" id='get_order'>
    
  </div>
</div>
<!-- my orders table ends here -->


<?php include_once('public/assets/js/myorders/call_order.js'); ?>
 
<?php include_once('footer.php'); ?>