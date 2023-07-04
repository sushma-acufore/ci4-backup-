<?php include_once('header.php'); ?>
<?php
$part_number=trim($_POST['part_number']);
if(empty($part_number)){
  echo "<script>window.href.location='index.php'</script>";
}
?>


<!-- your cart button start -->
<div class="container result-of-search-container">
  <div class="row" >
    <div class="col-lg-5" style="padding: 10px 25px;">
      <button style="width:200px!important; float: left;" class="search-page-btn-your-cart">Register as stock dealer</button>
    </div>
	</div>
</div>
<!-- your cart button end -->

<!-- item to cart start -->
<div class="container result-of-search-container">
  <div class="row">  
	  <div class="col-lg-12" style="padding: 10px 25px;">
	    <div class="row table-stock-row">     
	      <form method="post" name="stock_dealer_form" id="stock_dealer_form" >
          <div class="form-outline mb-4">
            <h1 style="font-size: 24px;color:#ecc712">Request to Register as a Stock Dealer for <?= $part_number?> <small style="font-size: 16px;">(Confirmation will be Sent to Provided Email)</small></h1>
            <br>
          </div>
          <div class="row">
            <div class="col-lg-4"></div>
            	<div class="col-lg-4">
	              <div class="col mb-4">
		              <div class="form-outline" >
			              <input type="hidden"  class="form-control"  id="part_number" name="part_number" value="<?= $part_number ?>" />
			              <input type="hidden" readonly class="form-control" value="<?php echo $_SESSION['user']['ebms_id'] ?? ''; ?>" placeholder="Customer ID" id="cid" name="cid">
			              <input type="hidden"  readonly class="form-control"  id="part_number" name="part_number" value="<?= $part_number ?>" />
			              <input type="text"  class="form-control" placeholder="Name of the Requester" id="firstname" name="firstname" />
		              </div>
	            	</div>
		            <div class="col mb-4">
		              <div class="form-outline">
		              <input type="text" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" class="form-control" placeholder="Email ID" id="email" name="email">
		              </div>
		            </div>

		            <div class="col mb-4">
		              <div class="form-outline">
		              <input type="number"  class="form-control" placeholder="Intended Stocking Quantity (Numeric value)" id="intended_stocking_quantity" name="intended_stocking_quantity" />
		              </div>
		            </div>

		            <div class="col mb-4">
		              <div class="form-outline">
		                <button onclick="form_submit()"type="button"  class="btn-your-cart" name="submit" id="submit" >Send request</button>
		              </div>
		            </div>
            	</div>
          </div>
	      </form>
	    </div>  
	  </div>
  </div>
</div>
<!-- item cart end -->


<div class="modal fade default_modals" id="send_req" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content modal-box-design modal_style">
     	<div class="row">
      	<div class="col-md-12 col-md-offset-3">
      		<img src="<?php base_url() ?>public/assets/img/baumalight-logo2.png">
      	</div>
      </div>

      <div class="modal-body text-center">
        <p id='par_id' style="font-size:17px;">Your request for stock dealer registration has been successfully sent to Baumalight team and it will be confirmed via registered email.<br/>
            Thank you.</p>
      </div>
      <div class="modal-footer" style="justify-content: center;">
        <a href="index"><button type="button" class="btn popup-btn-yes">Okay</button></a>     
      </div>
    </div>
  </div>
</div>


<!-- logout Modal ends -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js" ></script>

<script>
  function form_submit(){
    // handle the invalid form...
    var firstname=$('#firstname').val();
    var intended_stocking_quantity=$('#intended_stocking_quantity').val();
    var cid=$('#cid').val();
    var email=$('#email').val();
   
    if(firstname==''){
      toastr.warning("Please enter First Name", "", { positionClass: "toast-top-right" });
    }
    else if(cid==''){
      toastr.warning("Please enter CID", "", { positionClass: "toast-top-right" });
    }
    else if(email==''){
      toastr.warning("Please enter Email", "", { positionClass: "toast-top-right" });
    }
    else if(intended_stocking_quantity==''){
      toastr.warning("Please enter Intended Stocking Quantity", "", { positionClass: "toast-top-right" });
    }
    else{
      var formData = new FormData(document.getElementsByName('stock_dealer_form')[0]);// yourForm: form selector        
		// everything looks good!
    $.ajax({
            type: "POST",
            url: "save-stock-dealer-registration",// where you wanna post
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                    $("#ajaxPreLoader").show();
                  },
            success: function(data) {
              if(data==1){
                $('#send_req').modal('show');
              }else{
                toastr.warning("Cannot able register, please try again", "", { positionClass: "toast-top-right" });
                
              }
            },
            complete:function(data){
                    $("#ajaxPreLoader").hide();
                  }
        });
    }

  }
 </script>
  


<?php include_once('footer.php'); ?>
