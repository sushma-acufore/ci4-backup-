<?php

\Config\Services::session();
use App\Models\Ordermodel;
use App\Models\Header\HeaderModel;
$ordmodel = new Ordermodel();
$headermodel = new HeaderModel();

?>
<!-- navbar start   -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="index">
            <img src="<?php echo base_url(); ?>public/assets/img/yellow-logo-1.png" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation" style="background-color:#ECC712;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <?php if(isset($_SESSION['E_EID'])){?>
                <li class="nav-item dropdown">
                    <a class="nav-link" role="button" aria-expanded="false" style="color: #ecc712;font-weight: 900;">
                       Welcome,<?php if(isset($_SESSION['E_EID'])){ echo $_SESSION['E_EID'];}else{}?>
                    </a>
                </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="index" role="button" aria-expanded="false">
                        <img src="<?php echo base_url(); ?>public/assets/img/yellow-search.png"/>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo base_url(); ?>public/assets/img/yellow-ship.png" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end drop-style shipping-details">
                        <li><a class="dropdown-item"><span class="navbar-list-head">Dealer</span><span
                        style="float: right;background: #ECC712;border-radius: 20px;"><img src="<?php echo base_url(); ?>public/assets/img/Close-square-fill.png" /></span></a>
                        </li>
                        <?php
                        $ee2 = '';
                        
                        if(isset($_SESSION['E_EID']))
                        {
                            $_SESSION['user']['ebms_id'];
                            $eid = $_SESSION['E_EID'];
                        
                        $getResult2 = headermodel::getebms_order_main($eid);

                        if(!empty($getResult2))
                        {  
                        $cid=$_SESSION['user']['ebms_id'];
                        $ee2 = '<li class="navbar-order-list scrollBar" style="height: 300px;overflow-y: scroll;">';
                          foreach ($getResult2 as $getRow2) 
                          { 
                            $autoID = $getRow2['AUTOID'];
                            $INVOICE = $getRow2['INVOICE'];
                            $DateTime = $getRow2['date_time'];
                            $onylDate = date('d-m-Y',strtotime($DateTime));

                            $ee2 .= '<div style="padding: 2px 10px;">
                                      <div class="shipping-details-div">
                                          <p><b>Orderd id </b>: '.$INVOICE.'</p>
                                          <p><b>Orderd on </b>: '.$onylDate.'</p>
                                      </div>
                                    </div>';
                          }
                          $ee2 .= '</li>';
                          $ee2 .= '<li>';
                          $row = headermodel::getgetTotal($cid);
                          /*$getTotal = "SELECT SUM(totalprice) FROM `ebms_order_main` where `cid` = '".$cid."'";
                          $result2 = $conn->query($getTotal);
                          $row = mysqli_fetch_assoc($result2);*/
                          $ee2 .= '<div style="padding: 10px;">
                            <p class="order-details-total-amt">Total Amount :</p>
                            <button class="btn btn-sm btn-warning order-details-btn"
                                style="background-color: #ECC712!important;border-radius:60px;color: #0A4276;font-weight:400;">$'.$row['SUM(totalprice)'].'</button>
                            
                                <a href="my-orders.php" style="float:right;padding:0px!important;">
                                <button class="btn btn-sm btn-warning order-details-btn"
                                  style="cursor:pointer!important;float:right;background-color: #ECC712!important;border-radius:60px;color: #0A4276;font-weight:400;" >View Orders</button></a>

                          </div>
                        </li>';

                        }else{
                          $ee2 .= '<li class="navbar-order-list">
                                      <div style="padding: 2px 10px;">
                                        <div class="shipping-details-div">
                                          <p>No Orders Found</p>    
                                      </div>
                                    </div>
                                  </li>';
                        }}else{
                            $ee2 .= '<li class="navbar-order-list" style="text-align:center">
                                            <p style="color:#fff;margin-top:8px;">No Orders Found</p>  
                                    </li>';
                          }
                        echo $ee2;
                        ?>


                    </ul>
                </li>

               

                <li class="nav-item dropdown">
                  <a class="nav-link" role="button" data-bs-toggle="dropdown" aria-expanded="false" >
                  <img src="<?php echo base_url(); ?>public/assets/img/Yellow-cart.png" />
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end drop-style shipping-details">
                    <li><a class="dropdown-item"><span class="navbar-list-head">Over View</span><span style="float: right;background: #ECC712;border-radius: 20px;"><img add_to_cart() src="<?php echo base_url(); ?>public/assets/img/Close-square-fill.png" /></span></a>
                    </li>
                    <li class="navbar-order-list">
                      <div style="padding: 10px;">
                        <div class="" id="basket_body">
                          <p style="color:#fff;text-align:center">No Records found</p>    
                        </div>
                      </div>
                    </li>
                  </ul>
                </li> 


                <!-- <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo base_url(); ?>public/assets/img/Yellow-cart.png" style="width:100%;height:100%" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end drop-style order-details">
                        <li><a class="dropdown-item"><span class="navbar-list-head">Over view</span><span
                                    style="float:right"><img src="<?php echo base_url(); ?>public/assets/img/Close-square-fill.png" /></span></a>
                        </li>
                        <li>
                            <div style="height: 200px;overflow-y: auto;">
                                <div class="navbar-order-list">
                                    <div style="padding: 10px;">
                                        <div class="order-details-div">
                                            <p>Item 1: TRL620D</p>
                                            <p>Tracked radial Mini Skidsteer</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="navbar-order-list">
                                    <div style="padding: 10px;">
                                        <div class="order-details-div">
                                            <p>Item 1: TRL620Y</p>
                                            <p>Tracked radial Mini Skidsteer</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div style="padding: 10px;">
                                <p class="order-details-total-amt">Total Amount :</p>
                                <button class="btn btn-sm btn-warning order-details-btn"
                                    style="background-color: #ECC712!important;border-radius:60px;color: #0A4276;font-weight:400;">$
                                    65,000.00</button>
                                <button class="btn btn-sm btn-warning order-details-btn"
                                    style="float:right;background-color: #ECC712!important;border-radius:60px;color: #0A4276;font-weight:400;">View
                                    Cart</button>
                            </div>
                        </li>


                    </ul>
                </li> -->

                <li class="nav-item dropdown">
                    <a class="nav-link"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?php echo base_url(); ?>public/assets/img/Yellow-user.png" />
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end drop-style">
                        <li><a class="dropdown-item" ><span class="navbar-list-head">Dealer</span><span
                        style="float: right;background: #ECC712;border-radius: 20px;"><img src="<?php echo base_url(); ?>public/assets/img/Close-square-fill.png" /></span></a>
                        </li>
                        <?php if(isset($_SESSION['E_EID'])){?>
                        <li><a class="dropdown-item" href="account" >Your Account</a></li>
                        <li><a class="dropdown-item" href="#">Your Orders</a></li>
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logout_modal" style="cursor:pointer!important">Logout <span><img
                                        src="<?php echo base_url(); ?>public/assets/img/On-button.png" /></span></a></li>
                    <?php } else{ ?>
                        <li><a class="dropdown-item" href="logout" style="cursor:pointer!important">Login</a></li>
                   <?php }?>
                    
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
<!-- navbar ends  -->