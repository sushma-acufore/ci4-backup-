<?php include_once('header.php'); ?>


<div class="container account-page-container">
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3">
    <button type="button" class="account-btn">My Account</button>
</div>
</div>
<div class="row ">
<div class="container" style="margin-bottom: 74px;">
<div class="col-lg-12 account-area-row">
<div class="account-page-content page-container" id="page-content">
    <div class="account-padding">
        <div class="col-xl-12 col-md-12">
          <div class="card card-user-main user-card-full-account">
            <div class="row account-m-l account-m-r">
              <div class="col-sm-4 bg-c-lite-green user-profile">
                <div class="card-block-account text-center">
                  <div class="user-myaccount">
                    <img src="<?php echo base_url() ?>public/assets/img/profile.png" style="width:150px;height:auto;" class="img-radius"
                      alt="User-Profile-Image">
                  </div>
                </div>
              </div>
              
              <div class="col-lg-8 col-md-8 col-sm-8">
                <div class="card-block-account">
                  <h5 class="account-margin-info account-details b-b-default account-font">Customer details in eagle</h5>
                  <hr>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">EBMS ID:</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['EID']); ?></h6>
					</div>
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">ZIP:</p>
                      <h6 class="account-text-muted account-text-font-w">
                      	<?php echo($users['ZIP']); ?></h6>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Full Name</p>
                      <h6 class="account-text-muted account-text-font-w">
                      	<?php echo($users['FULL_NAME']); ?></h6>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Phone:</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['PHONE']); ?></h6>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Address1:</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['ADDRESS1']); ?></h6>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Email:</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['EMAIL']); ?></h6>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Address2:</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['ADDRESS2']); ?></h6>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Contact 1:</p>
                      $e1 .= '<h6 class="account-text-muted account-text-font-w">
                      	<?php echo($users['CONTACT_1']); ?></h6>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">City</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['CITY']); ?></h6>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Contact 2:</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['CONTACT_2']); ?></h6>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Country</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['COUNTRY']); ?></h6>
                    </div>
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Contact 3:</p>
                      <h6 class="account-text-muted account-text-font-w"><?php echo($users['CONTACT_3']); ?></h6>
                    </div>
                  </div> 
                  <div class="row">
                    <div class="col-sm-6 col-xs-6">
                      <p class="account-page-details-style account-font">Dealer Discount</p>
                      <h6 class="account-text-muted account-text-font-w"></h6>
                    </div>
                   </div>
                  </div> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>




<?php include_once('footer.php'); ?>