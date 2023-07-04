<?php
\Config\Services::session();
use App\Models\Ordermodel;
$ordmodel = new Ordermodel();

if(isset($_POST['e_eid'])){
    $cid=trim($_POST['e_eid']);
    $cid=strtoupper($cid);
    $user_id=trim($_POST['user_id']);
    
    $_SESSION['user']['ebms_id']=$cid;
    $_SESSION['E_EID']=$cid;
     // $_SESSION['user']=trim($_POST['user']);
    
    if($user_id==1787){
    //$update_ebms_id=mysqli_query($conn,"update users set ebms_id='$cid' where user_id='1787'");
    //$update_eid_customer=mysqli_query($conn,"update eagle_customer set EID='$cid' where id='6665'");

    $db = db_connect();
    $model= $db->table('users');
    $model->where('user_id', '1787')->
    set('ebms_id',$cid)->update();
    
    $model2= $db->table('eagle_customer');
    $model2->where('id', '6665')->
    set('EID',$cid)->update();
    }
}


        //$_SESSION['user']['ebms_id']='TEST2';
        //$_SESSION['E_EID']='TEST2';


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