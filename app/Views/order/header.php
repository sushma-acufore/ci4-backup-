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
<?php
        if(isset($_POST['e_eid']))
        {
            $cid=trim($_POST['e_eid']);
            $_SESSION['user']['ebms_id']=$cid;
            $_SESSION['E_EID']=$cid;
            // $_SESSION['user']=trim($_POST['user']);
        }

        $_SESSION['user']['ebms_id']='TEST2';
        $_SESSION['E_EID']='TEST2';

        // $_SESSION['user']['ebms_id']='TEST1';
        // $_SESSION['E_EID']='TEST1';

        // if(!isset($_SESSION['user']['ebms_id']) || !isset($_SESSION['E_EID'])){
        //     echo '<script>window.location.href="logout.php"</script>';
        // }

        if(isset($_SESSION['E_EID']))
        {
            if(empty($_SESSION['user']['ebms_id']) || $_SESSION['user']['ebms_id']=='' || $_SESSION['user']['ebms_id']==NULL)
            {
                echo '<input type="hidden" name="login_dealer_name" id="login_dealer_name" value="">';  
            }
            else
            {
                echo '<input type="hidden" name="login_dealer_name" id="login_dealer_name" value="'.$_SESSION['user']['ebms_id'] .'">'; 
            }

            $cid=$_SESSION['user']['ebms_id'];
        }

        $E_EID_st = 0;
       


        if(isset($_SESSION['E_EID']))
        {
            $E_EID_st = 1;

            $user_name = 'APIACCESS';
            $password = 'APIaccessL';
            $eid = $_SESSION['E_EID'];
            
            $result = Ordermodel::geteaglecust_eid($eid);
            if(!empty($result))
            { 
                foreach ($result as $row)
                {
                    $ch1 = curl_init();
                    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch1, CURLOPT_TIMEOUT, 100);
                    curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                    $api_request_url = 'https://ECC842362022020802.servicebus.windows.net/myebms/MTB/odata/ARCUSPRC?$filter=ID%20eq%20\''.$eid.'\'';
                    curl_setopt($ch1, CURLOPT_URL, $api_request_url);
                    curl_setopt($ch1, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch1, CURLOPT_USERPWD, "$user_name:$password");
                    $resp1 = curl_exec($ch1);
                    if($e1 = curl_error($ch1))
                    {
                        //echo $e1;
                    }
                    else 
                    {
                        $json_data1 = json_decode($resp1,true);
                    }
                    curl_close($ch1);

                   // var_dump($json_data1);

                    $discount = '';
                    if(!empty($json_data1['value']))
                    {
                        $size = $a = $c = $json_data1['value'];
                        $discount = $size[0]["DISCOUNT"];
                    }

                    $_SESSION['E_EID'] = $row['EID'];
                    $_SESSION['E_FULL_NAME'] = $row['FULL_NAME'];
                    $_SESSION['E_ADDRESS1'] = $row['ADDRESS1'];
                    $_SESSION['E_ADDRESS2'] = $row['ADDRESS2'];
                    $_SESSION['E_CITY'] = $row['CITY'];
                    $_SESSION['E_COUNTRY'] = $row['COUNTRY'];
                    $_SESSION['E_ZIP'] = $row['ZIP'];
                    $_SESSION['E_PHONE'] = $row['PHONE'];
                    $_SESSION['E_EMAIL'] = $row['EMAIL'];
                    $_SESSION['E_CONTACT_1'] = $row['CONTACT_1'];
                    $_SESSION['E_CONTACT_2'] = $row['CONTACT_2'];
                    $_SESSION['E_CONTACT_3'] = $row['CONTACT_3'];
                    $_SESSION['E_discount'] = $discount;
                    $e = $row['EID'];


                }
                // $ch2 = curl_init();
                // curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                // curl_setopt($ch2, CURLOPT_TIMEOUT, 100);
                // curl_setopt($ch2, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                // $api_request_url1 = 'https://ECC842362022020802.servicebus.windows.net/myebms/MTB/odata/ARCUST?$filter=ID%20eq%20\'GREE5_S10\'';
                // curl_setopt($ch2, CURLOPT_URL, $api_request_url1);
                // curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                // curl_setopt($ch2, CURLOPT_USERPWD, "$user_name:$password");
                // $resp2 = curl_exec($ch2);
                // if($e2 = curl_error($ch2))
                // {
                //     echo $e2;
                // }
                // else 
                // {
                //     $json_data2 = json_decode($resp2,true);
                // }
                // curl_close($ch2);

                // var_dump($json_data2);


            }
        }
        // <!-- To get geolocation -->

        /*error_reporting(0);
        function ip_details($IPaddress) {
            $json       = file_get_contents("http://api.ipstack.com/{$IPaddress}?access_key=7cb4044e933b2bfc41a1ae17e28bcc14");
            $details    = json_decode($json);
            return $details;
        }
        $IPaddress = $_SERVER['REMOTE_ADDR'];
        //$IPaddress ='106.51.80.163';//india
        //$IPaddress ='198.7.59.119';//US
        //$IPaddress ='192.206.151.131';//canada
        //$IPaddress='45.62.255.255';//canada
        //$IPaddress ='000.000.000.000';//null
        //$details='{"success":false}';


        $details = ip_details("$IPaddress");
        //var_dump($details);
        $cntry='';
        $curl='';
        if($details === NULL){
            $cur='CAD';
            $curl='CAD';
            $cntry='CA';
        }elseif( $details->country_code === NULL){
            $cur='CAD';
            $curl='CAD';
        }else{
            $cntry = $details->country_code;
            if($cntry=="US"){
                $cur = "USD";
                $curl='USD';
            }else if($cntry=="CA"){
                $cur = "CAD";
                $curl='CAD';
            }else if($cntry!="CA" OR $cntry!="US"){
                $cur = "USD";
                $curl='USD';
            }else if(empty($cntry) OR is_null($cntry))  
            {
                $cur='CAD';
                $curl='CAD';
            }
            else
            {
                $cur='CAD';
                $curl='CAD';
            }
        }



        $url=$_SERVER['QUERY_STRING'];
        if(empty($url) or is_null($url))
        { 
        }else
        {
            $curl=$url;
            if($curl=="usa")
            {
                $cur="USD";
                $curl="usd";
            }
            else
            {
                $cur=strtoupper($curl);
                $curl=$curl;
            }
        }*/
        $curl = 'USD';
        $cntry = 'US';



    ?>

<!-- navbar start   -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo base_url(); ?>">
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
                       Welcome,<?php if(isset($_SESSION['E_FULL_NAME'])){ echo $_SESSION['E_FULL_NAME'];}else{}?>
                    </a>
                </li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="<?php echo base_url(); ?>" role="button" aria-expanded="false">
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
                        <li><a class="dropdown-item" href="<?php echo base_url(); ?>my-orders">Your Orders</a></li>
                        <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#logout_modal" style="cursor:pointer!important">Logout <span><img
                                        src="<?php echo base_url(); ?>public/assets/img/On-button.png" /></span></a></li>
                    <?php } else{ ?>
                        <li><a class="dropdown-item" href="logout.php" style="cursor:pointer!important">Login</a></li>
                   <?php }?>
                    
                    </ul>
                </li>
            </ul>

        </div>
    </div>
</nav>
<!-- navbar ends  -->


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
                <button type="button" class="btn popup-btn-yes" onclick="location.href='logout.php'">Yes</button>
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