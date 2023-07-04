<?php include_once('header.php'); ?>

<?php

$from_cart_icon=0;
if (isset($_POST['from_cart_icon'])) {
  $from_cart_icon=$_POST['from_cart_icon'];
}

?>


<?php

$def_qty=0;
if($_POST['avl_stock']>0){
  $def_qty=1;
}
?>
<!-- scripts for carousel -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<style>
.scrollBar{
  //width:0px!important;
}
</style>

<!-- serach box -->
<div class="container-fluid more-info-container">
  <div class="more-info-row">
    <div class="col-md-12 ">
      <h4  style="color: #ecc712;text-align: left;font-size: 20px;font-weight: 700;padding-top:12px;"><u>PRODUCT INFORMATION & PRICE BREAKUP</u></h4>
        <div class="row">
          <div class="col-lg-7 col-md-6 col-xs-12" style="background-color:#fff;border-radius: 15px;height: 400px;">
            <div class="row table-responsive">
              <table class="table table-striped more-info-table" style="width:100%">
                <tbody>
                  <tr >
                    <td>Part Number</td>
                    <td><?= $_POST['part_no']?></td>
                  </tr>

                  <tr >
                    <td>Description</td>

                   <td><div class="scrollBar"style="height:50px;overflow-y: scroll!important;background:#fff"><?php echo $ee['description']; ?></div></td>

                  </tr>

                  <tr >
                    <td>Available&nbsp;Stock</td>
                    <td><?= $_POST['avl_stock']?></td>
                  </tr>

                  <tr >
                    <td>Price</td>
                    <td>$<?php echo $ee['lprice']; ?><?php echo strtoupper($ee['curl']); ?></td>

                  </tr>

                  <tr>
                    <td>Dealer&nbsp;Discount</td>
                    <td><?php echo $ee['sp_price']; ?><?php echo strtoupper($ee['curl']); ?></td>
                  </tr>

                  <?php 
                  if($ee['stk_discount']!='' && $ee['stk_discount']>0){
                  ?>
                  <tr>
                    <td>*Stock&nbsp;Dealer&nbsp;Price</td>
                    <td>$<?php echo $ee['totalprice']; ?></td>
                  </tr>
                  <?php 
                  }else{
                  ?>
                  <tr>
                    <td><span class="blink">*Stock&nbsp;Dealer&nbsp;Price</span></td>
                    <td><form method="post" action="stock-dealer-registration.php">
                      <input type="hidden" name="part_number" value="<?php echo $ee['pno']; ?>"/>
                      <button type="submit" class="cart-table-btn-dealer-price" >Click&nbsp;Here</button></form></td>                        
                  </tr>
                  <?php } ?>
                 

                  <tr>
                   	<td>Extended&nbsp;Price</td>
                   	<td>$<?php echo $ee['totalprice']; ?><?php echo strtoupper($ee['curl']); ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col-lg-5 col-md-5 col-xs-12" style="height: 400px;padding-right:0px;" >
            <div class="" style="text-align: center;background-color:#fff;border-radius:15px">
              <?php if($from_cart_icon==1){?>
                <img src="<?php echo base_url(); ?>public/assets/img/yellow-noimage-BG.png" style="width:100%;height:400px;" />
              <?php } else{?>
              <img src="<?php echo base_url(); ?>public/assets/img/yellow-noimage-BG.png" style="width:100%;height:333px;" />
              <div class="row">
                <div class="col-md-6">
                  <div class="quantity-main">
                    <p class="quantity-title">Quantity</p>
                    <div class="quantity-count">
                      <div class="container">
                        <div class="row" style="display: flex;">
                          <div class="total-cunt col-md-6" style="margin: 5px 0px;">
                            <div>
                            <input type="text" onchange='change_input_quantity()' id="total_count" value="<?php echo $def_qty; ?>"  style="background-color : #ecebeb; border-color: #ecebeb;border: 1px solid #ecebeb;width:30px;">
                          </div>
                          </div>
                          <div class="increment-cunt col-md-6" style="margin: -2px -1px;">
                            <div id="increment-count" class="increment-count" style="margin: 8px 0px;">
                              <a onclick="change_quantity_in_cart(2)" style="cursor:pointer"><img src="<?php echo base_url() ?>public/assets/img/Arrow-drop-up.png"></a>
                            </div>

                            <div id="decrement-count" style="font-size: 0px;">
                              <a onclick="change_quantity_in_cart(1)" style="cursor:pointer">
                              <img src="<?php echo base_url() ?>public/assets/img/Arrow-drop-down.png"></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <a><button type="button" class="more-info-cart-btn" onclick="check_product_8weeks()">Add to cart</button></a>
                </div>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <br><br>
        <div class="row" id="recommended_carousel_part">
        	<?php include('recommended-item.php');?>
        </div>
    </div>
  </div>
</div>
<!-- serach box -->

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

<input type="hidden" id="prod_8weeks">
<input type="hidden" id="stk_discount">
<input type="hidden" id="pno">
<input type="hidden" id="Mcurl">
<input type="hidden" id="Mcntry">
<input type="hidden" id="model_confirm_state" value="">
<input type="hidden" id="mqty">

<?php include_once('public/assets/js/moreinfo/change_input_quantity.js'); ?>
<?php include_once('public/assets/js/moreinfo/change_quantity_in_cart.js'); ?>
<?php include_once('public/assets/js/moreinfo/check_product_8weeks.js'); ?>
<?php include_once('public/assets/js/moreinfo/continue_add_to_cart.js'); ?>
<?php include_once('public/assets/js/moreinfo/fetch_recommended_items.js'); ?>
<?php include_once('public/assets/js/moreinfo/moreinfo.js'); ?>
<?php include_once('public/assets/js/moreinfo/recomm_add_to_cart.js'); ?>

<?php include_once('footer.php'); ?>