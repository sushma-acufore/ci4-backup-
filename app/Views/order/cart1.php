<?php 
include_once('header.php'); 
 
\Config\Services::session();
use App\Models\Ordermodel;
$ordmodel = new Ordermodel();
?>

<?php

if(isset($_SESSION['po_by_customer'])){
  $_SESSION['po_by_customer']='';
}
$cid=$_SESSION['user']['ebms_id'];

$result = Ordermodel::getproduct_count($cid);

$count = $result['count'];
// $select_items=mysqli_query($conn, "select count(*) from product_cart where cid='$cid'");
// $count=mysqli_num_rows($select_items);

?>
<style>
.btn.disabled, .btn:disabled, fieldset:disabled .btn {
    color: #0A4276!important;
    cursor: default!important;
    background-color: #ecc712!important;
    border-radius: 22px!important;
    /* font-weight: 600; */
    padding: 5px 38px 5px!important;
    border: none!important;
}
</style>
  <!-- serach box -->
  <div class="container cart-page-container">
    <div class="col-lg-12">
<!--
      <div class="row">
        <div class="col-md-12 col-lg-12">
          <div class="col-md-12">
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-md-12 col-sm-12">
                <button type="button" class="btn your-cart-btn"><a href="">Your Cart</a></button>
                <span class="cart-btn-email">Email: <?php if (isset($_SESSION['E_EMAIL'])) { echo $_SESSION['E_EMAIL']; } ?></span>
              </div>
            </div>
          </div>
          <div class="col-md-6">

          </div>
        </div>
      </div>
    -->
    
    <div class="row">
    <div class="col-md-12 col-sm-12">
    <button type="button" class="your-cart-btn" >Your Cart</button>
    <a href="<?php echo base_url(); ?>" id="add_product_top" style="display:none"><button style="cursor:pointer!important"class="your-cart-btn" type="button"
                 >Add Product</button></a>
    <span class="cart-btn-email" style="float:right;margin-right: 3px">Email: <?php if (isset($_SESSION['E_EMAIL'])) { echo $_SESSION['E_EMAIL']; } ?></span>
    </div>
      </div>
    
      <div class="row" style="margin:3px;margin-bottom:30px;">
        <div class="col-md-12 cart-items-div">
        
          <div class="table-responsive" id="cart_body">
            
          </div>
          
          <div class="row shipping-address-cont">
            
            <div class="col-md-6" >
              <div class="col-md-12" id="shipp_address">

              </div>

             <div class="col-md-12 new-addr-div" style="display:none">
                <p class="shipp-address-leb">New Shipping Address :</p>
                
                <form method="post" id="new_address_form" name="new_address_form">
                <div class="new-add-form-details">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>First Name:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                        <input type="hidden" class="form-control form-control-sm" name="cid" value="<?php echo $_SESSION['user']['ebms_id'];?>">
                        
                          <input type="text" class="form-control form-control-sm" name="first_name" id="first_name" required>
                        
                        </div>
                        
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Last Name:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="text" class="form-control form-control-sm" name="last_name" id="last_name" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Phone No:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="tel" class="form-control form-control-sm" name="phone_no" id="phone_no" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Email:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="email" class="form-control form-control-sm" name="email" id="email" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Company Name:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="text" class="form-control form-control-sm" name="company_name" id="company_name" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Address 1:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="text" class="form-control form-control-sm" name="address_1" id="address_1" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Address 2:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="text" class="form-control form-control-sm" name="address_2" id="address_2">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>City:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="text" class="form-control form-control-sm" name="city" id="city">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>State:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="text" class="form-control form-control-sm" name="state" id="state" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Country:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="text" class="form-control form-control-sm" name="country" id="country" required>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-4">
                          <label>Pincode:</label>
                        </div>
                        <div class="col-md-8" style="margin: 2px 0px;">
                          <input type="text" class="form-control form-control-sm" name="pin_code" id="pin_code" required>
                        </div>
                      </div>
                    </div>
                  
                </div>
                 <button type="button" class="btn shipp-send-reqst-btn" name="submit" onclick="send_request_new_address()">Send Request</button>

                  </form>

                </div>        
               
              </div>

              <!-- PO Entry--->
              <div class="col-md-6">
                <?php 
                    $po_by_customer='';
                    if(isset($_SESSION['po_by_customer'])){
                      $po_by_customer=$_SESSION['po_by_customer'];
                    }
                ?>
                <div class="col-md-12" id="po_by_customer_div" style="display:none">
                  <p class="shipp-address-leb">PO Number :</p>
                  <input class="form-control" onchange="set_session_po()" id="po_by_customer" 
                  style="width:auto!important;border-radius:27px;" 
                  type="text" name="po_no" value="<?= $po_by_customer ?>"/>
                </div>

              </div>
            </div>

            <div class="col-md-6 existing_addr" id='shipp_info'>
              
            </div>


          <div class="row shipping-address-cont cart_footer">
             <!-- buttons will go here  -->
             <div class="shipp-address-buttons">
              <div class="col-md-12">
                <div style="margin-top: 30px;">
                  <button class="btn shipp-cancel-btn me-md-2" type="button"
                  onclick="clear_cart_item('<?= $_SESSION['E_EID']?>');">Cancel
                      Order</button>

                  <!-- Button trigger modal -->
                  <form method="post" action="<?php echo base_url(); ?>order/previeworder" id="myForm" style="float:right">
                    <button type="button" class="btn shipp-preview-btn" onclick="send_order()">
                    Preview Order
                    </button>
                  </form>
              
                  <!-- Modal -->
                  <div class="modal fade default_modals" id="exampleModal" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                      <div class="modal-content modal-box-design modal_style">
                          <div class="row">
                            <div class="col-md-12 col-md-offset-3">
                            <img src="<?php echo base_url(); ?>public/assets/img/baumalight-logo2.png">
                            </div>
                            </div>
                        <div class="modal-body text-center">
                          <p id='par_id' style="font-size:17px;">Please Confirm shipping address.</p>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn popup-btn-yes" data-bs-dismiss="modal">Yes</button>
                        </div>
                      </div>
                    </div>
                  </div>
                
                </div>
              </div>
            </div>
            <!-- buttons will go here  -->


          </div>
        </div>
       
      </div>


    </div>
  </div>
  <div id="hi"> </div>
  <div id="user_session"> </div>

  <div class="modal fade default_modals" id="send_req" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content modal-box-design modal_style">
        <div class="modal-body text-center">
          <p id='par_id' style="font-size:15px;">Your request for adding new shipping address has been successfully sent to Baumalight team and
          it will be confirmed via registered email. Also, if validated, the order will be sent to the
          same new address that was asked to be added.<br />
          Thank you,</p>
        </div>
        <div class="modal-footer" style="justify-content: center;">
          <a href="<?php echo base_url(); ?>"><button type="button" class="btn popup-btn-yes">Okay</button></a>


        </div>
      </div>
    </div>
  </div>


<!-- serach box -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js" integrity="sha512-dTu0vJs5ndrd3kPwnYixvOCsvef5SGYW/zSSK4bcjRBcZHzqThq7pt7PmCv55yb8iBvni0TSeIDV8RYKjZL36A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js" ></script>
 
<!--cdn for toastr-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" ></script>
  

<?php include_once('public/assets/js/cart/cancel_order.js'); ?>
<?php include_once('public/assets/js/cart/cart.js'); ?>
<?php include_once('public/assets/js/cart/cart_append.js'); ?>
<?php include_once('public/assets/js/cart/cart_append_load.js'); ?>
<?php include_once('public/assets/js/cart/cart_footer.js'); ?>
<?php include_once('public/assets/js/cart/cart_footer_load.js'); ?>
<?php include_once('public/assets/js/cart/change_input_quantity_cart.js'); ?>
<?php include_once('public/assets/js/cart/change_quantity_in_cart.js'); ?>
<?php include_once('public/assets/js/cart/delete_cart_item.js'); ?>
<?php include_once('public/assets/js/cart/get_ship_address_load.js'); ?>
<?php include_once('public/assets/js/cart/send_order.js'); ?>
<?php include_once('public/assets/js/cart/send_request_new_address.js'); ?>
<?php include_once('public/assets/js/cart/set_session_po.js'); ?>
<?php include_once('public/assets/js/cart/shippingAddress.js'); ?>

<?php include_once('footer.php'); ?>