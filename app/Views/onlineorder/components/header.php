<?php   
    \Config\Services::session();
    use App\Models\Ordermodel;
    use App\Models\Header\HeaderModel;
    $ordmodel = new Ordermodel();
    $headermodel = new HeaderModel();
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dealers | Online purchase portal</title>
    <link href="<?php echo base_url() ?>public/css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    <script src="<?php echo base_url('public/assets/js/sweetalert.min.js'); ?>"></script>

    <!--cdn for toastr-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" ></script>

</head>
<body onload="basket_append();">
<!-- <div class="preloader" id="preloader">
  <div class="loader"></div>
</div> -->
<!--preloader for page load start  -->
<div class="col-sm-12" style="text-align:center">
    <svg class="loader" id="preloader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 440 440">
     <circle cx="170" cy="170" r="160" stroke="#FFFF00"/>
     <circle cx="170" cy="170" r="135" stroke="#000000"/>
     <circle cx="170" cy="170" r="110" stroke="#FFFF00"/>
     <circle cx="170" cy="170" r="85" stroke="#000000"/>
    </svg>
</div>


<!--preloader for ajaxcall start  -->
<div class="col-sm-12" style="text-align:center">
    <svg class="loader" id="ajaxPreLoader" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 440 440">
     <circle cx="170" cy="170" r="160" stroke="#FFFF00"/>
     <circle cx="170" cy="170" r="135" stroke="#000000"/>
     <circle cx="170" cy="170" r="110" stroke="#FFFF00"/>
     <circle cx="170" cy="170" r="85" stroke="#000000"/>
    </svg>
</div>

<?php include(APPPATH. 'views/onlineorder/components/headercomponents/preloadsession.php' ); ?>

<?php include(APPPATH. 'views/onlineorder/components/navbar.php' ); ?>




<!-- auto identify customer id or ebms id using logged session -->

    <!-- CID-->
    <input type="hidden" id="cid" name="cid" value="<?php if (isset($_SESSION['E_EID'])) { echo $_SESSION['E_EID']; }else{ echo "TEST2";} ?>">
    <!-- temp cur variable -->
    <input type="hidden" id='temp_curl' value="<?php if (isset($_SESSION['custom_currency'])) { echo $_SESSION['custom_currency']; } ?>">
      <!-- Modal -->
      <div class="modal fade default_modals" id="logout_modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content modal-box-design modal_style">
            <div class="row">
              <div class="col-md-12 col-md-offset-3">
                <img src="<?php echo base_url(); ?>public/assets/img/baumalight-logo2.png">
              </div>
            </div>
            <p id='par_id' style="font-size:17px;">
            <div class="modal-body text-center">
            Are you sure..?<br/>
            Do you want to logout?</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn popup-btn-yes" onclick="location.href='logout'">Yes</button>
              <button type="button" class="btn popup-btn-yes" data-bs-dismiss="modal">No</button>
            </div>
        </div>
      </div>
    </div>

    <!-- delete item Modal -->
    <div class="modal fade default_modals" id="delete_item_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
            <div class="modal-content modal-box-design modal_style">
                        <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                        <img src="<?php echo base_url(); ?>public/assets/img/baumalight-logo2.png">
                        </div>
                        </div>   
                <div class="modal-body">
                        <p id='par_id'>Are you sure..?<br/>
                            Do you want to delete!</p>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="delete_item_no" id="delete_item_no" vaule=""/>
                <button type="button" class="btn popup-btn-yes" onclick="delete_item_modal()">Yes</button>
                <button type="button" class="btn popup-btn-yes" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- pop up -->


     <!-- delete cart Modal -->
     <div class="modal fade default_modals" id="clearcart_item_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
            <div class="modal-content modal-box-design modal_style">
                        <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                        <img src="<?php echo base_url(); ?>public/assets/img/baumalight-logo2.png">
                        </div>
                        </div>   
                <div class="modal-body">
                        <p id='par_id'>Are you sure..?<br/>
                            Do you want to Cancel Order!</p>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="delete_cart" id="delete_cart" vaule=""/>
                <button type="button" class="btn popup-btn-yes" onclick="cancel_order()">Yes</button>
                <button type="button" class="btn popup-btn-yes" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- pop up -->

    <!-- confirm order and place Modal -->
    <div class="modal fade default_modals" id="send_order_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
            <div class="modal-content modal-box-design modal_style">
                        <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                        <img src="<?php echo base_url(); ?>public/assets/img/baumalight-logo2.png">
                        </div>
                        </div>   
                <div class="modal-body">
                        <p id='par_id'>Are you sure..?<br/>
                            Do you want to Place Order!</p>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn popup-btn-yes" onclick="send_order_form()">Yes</button>
                <button type="button" class="btn popup-btn-yes" data-bs-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- pop up -->


    <!-- Stock Dealer Modal -->
<div class="modal fade default_modals" id="stock_dealer_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
            <div class="modal-content modal-box-design modal_style">
                <div class="row">
                <div class="col-md-12 col-md-offset-3">
                <img src="<?php echo base_url(); ?>public/assets/img/baumalight-logo2.png">
                </div>
                </div>
                <form action="stock-dealer-registration" method="POST">   
                <div class="modal-body" style="text-align:center">
                  <div class="row">
                        <div class="col-sm-12">
                            <img src="<?php echo base_url(); ?>public/assets/img/discount.png" />
                        </div>
                        <input type="hidden" name="part_number" id="part_number"/>
                        <input type="hidden" name="url" id="url"/>
                        <div class="col-sm-12">
                            <p style="font-weight:normal!important">For <span style="font-weight:bold" id="product_id"></span>, you have <span style="font-weight:bold" id="dealer_discount"></span>% discount, i.e $<span style="font-weight:bold" id="dealer_discount_amount"></span>, and Extended Price will be $<span style="font-weight:bold" id="stock_dealer_price"></span>. If you wish to become Stock dealer, please click on Register button below.</p>
                        </div>
                  </div>
                          
                </div>
                <div class="modal-footer" style="text-align:center">
                <button type="submit" class="btn popup-btn-yes" >Register</button>
                <button type="button" class="btn popup-btn-yes"  data-bs-dismiss="modal" style="background-color:#e85656;color:#fff">Cancel</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- pop up -->


     <!-- No discount modal -->
     <div class="modal fade default_modals" id="no_discount_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            
            <div class="modal-content modal-box-design modal_style">
                        <div class="row">
                        <div class="col-md-12 col-md-offset-3">
                        <img src="<?php echo base_url(); ?>public/assets/img/baumalight-logo2.png">
                        </div>
                        </div>   
                <div class="modal-body">
                        <p id='par_id'>Stock Dealer Price is not set for this product.<br/>
                          </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn popup-btn-yes" data-bs-dismiss="modal">Okay</button>
                </div>
            </div>
        </div>
    </div>
    <!-- pop up -->
