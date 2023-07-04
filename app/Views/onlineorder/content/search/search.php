<?php include ( APPPATH . 'views/onlineorder/components/header.php' ); 
if(isset($_SESSION['po_by_customer'])){
  unset($_SESSION['po_by_customer']);
}
if(isset($_SESSION['ship_addr'])){
  unset($_SESSION['ship_addr']);
}
?>

  <!-- serach box -->
  <div class="container my-1 search-container">
    <div class="row">
      <div class="col-12">
        <form>
          <p class="placeholder-glow" id="placeholder-glow">
            <input type="text" class="rounded-pill placeholder yellow" placeholder="SEARCH PRODUCT" required name="pid" id="pid" onkeyup="search_part_number();" autocomplete="off">
            <button class="serach-button" type="button" onclick="search_part_number();"><img src="<?php echo base_url('public/assets/img/search-icon.png'); ?>" alt="" style="width:30px;"></button>
            </p>
            <!-- if asked add this filters  -->
            <input type="hidden" name="" class="form-control card" placeholder="Filter Using Description...." required id="pd1" onkeyup="search_part_number();">
            <input type="hidden" name="" class="form-control card" placeholder="Description 2...." required id="pd2" onkeyup="search_part_number();">
        </form>
      </div>
    </div>
  </div>
  <!-- serach box -->

  <div class="container">
    <div class='row'>
      <div class="w-50 ml-0 mr-0 mx-auto text-center">
        <div class="alert" id="out_of_stock_alert_id" role="alert" style="display:none; background: #ecc712;border-radius: 25px;font-size: 20px;text-align: center;font-weight: 900;" >OUT OF STOCK</div>
        </div>
    </div>
  </div>
  <!-- results of serached items-->
  <div class="container result-of-search-container" id='pidres'>
      
  </div>
  <!-- results of serached items end -->

  <!-- your cart button start -->
  <div class="container result-of-search-container" id="cart_body_title" style="display: none;">
      <div class="row">
          <div class="col-lg-6 text-left" style="padding-top:10px">
              <!--<button class="search-page-btn-your-cart">Cart View</button>-->
              <h4 class="FlightManager_title__2PfRE u-h1" style="color: #ecc712;text-align: left;font-size: 20px;font-weight: 700;"><u>PRODUCTS ADDED IN YOUR CART</u></h4>
              
          </div>
      </div>
  </div>
  <!-- your cart button end -->

  <!-- item to cart start -->
  <div class="container result-of-search-container" id="cart_body">
      
  </div>
  <!-- item cart end -->

  <!-- your cart button start -->
  <div class="container result-of-search-container" id="cart_body_title1" style="display: none;">
      <div class="row">
          <div class="col-md-12" style="margin:0px">
              <a href="cart"><button class="cart-table-btn-dealer-price" >Go to Cart</button><a>
          </div>
      </div>
  </div>
  <!-- your cart button end -->
 
  <!-- Modal -->
    <div class="modal fade default_modals" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-box-design modal_style">
                        <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                        <img src="<?php base_url() ?>public/assets/img/baumalight-logo2.png">
                        </div>
                        </div>   
                <div class="modal-body">
                  <p id='par_id'>Do you want to choose 8 weeks delivery for 8% discount on this product?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn popup-btn-okay popup-btn-yes" onclick="model_cnf_yes()" data-bs-dismiss="modal">Yes</button>
                  <button type="button" class="btn popup-btn-okay popup-btn-yes" onclick="model_cnf_cancel()" data-bs-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div>
        </div>
    </div>
  <!-- pop up -->


<!-- confirm order and place Modal -->
<div class="modal fade default_modals" id="recommended_items_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-box-design modal_style">
      <div class="row">
        <div class="col-md-12 col-md-offset-3">
          <img src="<?php base_url() ?>public/assets/img/baumalight-logo2.png">
        </div>
      </div>   
      <div class="modal-body">
        <p id='par_id' style="text-align:justify">There are other items usually bought together with this item. Would you like to check them out?</p>
      </div>
      <input type="hidden" value="" id="recommended_items_modal_text"/>
      <div class="modal-footer">
        <button type="button" class="btn popup-btn-yes" onclick="check_recommended_items_yes()" data-bs-dismiss="modal">Yes</button>
        <button type="button" class="btn popup-btn-yes" data-bs-dismiss="modal" >No</button>
      </div>
    </div>
  </div>
</div>
  <!-- pop up -->


<!-- Modal -->
<div class="modal fade default_modals" id="price_alert_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-box-design modal_style">
      <div class="row">
        <div class="col-md-12 col-md-offset-3">
          <img src="<?php base_url() ?>public/assets/img/baumalight-logo2.png">
        </div>
      </div>   
      <div class="modal-body">
        <p id='par_id'>Price is not set for this Part Number. Contact Baumalight for more information.</p>  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn popup-btn-okay popup-btn-yes" data-bs-dismiss="modal">Ok</button>
      </div>
    </div>
  </div>
</div>
<!-- pop up -->

<!-- backup after modal -->
<input type="hidden" id="prod_8weeks">
<input type="hidden" id="stk_discount">
<input type="hidden" id="apply_discount">
<input type="hidden" id="pno">
<input type="hidden" id="Mcurl">
<input type="hidden" id="Mcntry">
<input type="hidden" id="model_confirm_state" value="">
<input type="hidden" id="mqty">
<input type="hidden" id="avail_stck" value="">


<!-- index related js files -->
<?php include_once('public/assets/js/index/search_part_number.js'); ?>
<?php include_once('public/assets/js/index/add_to_cart.js'); ?>
<?php include_once('public/assets/js/index/cart_footer.js'); ?>
<?php include_once('public/assets/js/index/delete_modal.js'); ?>
<?php include_once('public/assets/js/index/recommended_items.js'); ?>
<?php include_once('public/assets/js/index/change_currency.js'); ?>

<?php include ( APPPATH . 'views/onlineorder/components/footer.php' ); ?>
