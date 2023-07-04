<?php 
\Config\Services::session();
use App\Models\Ordermodel;
$ordmodel = new Ordermodel();


    $part_no=trim($_POST['part_no']);
     //$curl=trim($_POST['curl']);
     //$cntry=trim($_POST['cntry']);
     //$avl_stock=trim($_POST['avl_stock']);

     //$part_no='060183';
     $result_comp = Ordermodel::getcompid($part_no);
     $num_rows=odbc_num_rows($result_comp);

	if(odbc_num_rows($result_comp)>0){ ?>
      <h4 style="color: #ecc712;text-align: left;font-size: 20px;font-weight: 700;"><u>RECOMMENDED ITEMS</u></h4>

      <div class="col-md-12 carousel-more-info-background">
        <form name="recommended_items_form" id="recommended_items_form">
        <input type="hidden" name="curl" value="<?= $curl ?>" />
        <input type="hidden" name="cntry" value="<?= $cntry ?>"/>
            <div class="wrapper">
                <div class="carousel owl-carousel" style="padding-top: 15px;">
             <?php   
        while($data_comp = odbc_fetch_array($result_comp)){
        $COMP_ID = $data_comp['COMP_ID'];
       
        $recom_sql = Ordermodel::getgp_comp($COMP_ID);

        // $recom_sql = "SELECT * FROM `gp_report` WHERE `Part_Number` = '".$COMP_ID."' ";
        // $result_recom_gp = mysqli_query($conn,$recom_sql);

        foreach ($recom_sql as $row_gp){

        $recom_Part_Number = $row_gp['Part_Number'];
        $recom_fulldescription = $row_gp['Description'];
        $recom_Description = $row_gp['Description'];
        if(strlen($recom_Description)>60)
        {
            $recom_Description = substr($recom_Description, 0, 50)."...";
        }

        $recom_C60_price_level_price = $row_gp['C60_price_level_price'];
        $recom_U60_price_level_price = $row_gp['U60_price_level_price'];
        $recom_lprice = '';
        $recom_price_level = 'C60';
        if($curl == '' AND $cntry=="US") 
        {
            $recom_lprice = $recom_U60_price_level_price;
            $recom_price_level = 'U60';
        }
        else if($curl == '' AND $cntry !="US") 
        {
            $recom_lprice = $recom_C60_price_level_price;
            $recom_price_level = 'C60';
        }
        else if($curl == "usa" or $curl=="usd" or $curl=="USD") 
        {
            $recom_lprice = $recom_U60_price_level_price;
            $recom_price_level = 'U60';
        }
        else if($curl == "cad" or $curl == "CAD") 
        {
            $recom_lprice = $recom_C60_price_level_price;
            $recom_price_level = 'C60';
        }
        }
    ?>
                <div class="rec-content">
                    <h5 class="carousel-heading"><b>Part-Number : <?= $recom_Part_Number ?></b></h5>
                    <h5 class="carousel-desc"  data-toggle="tooltip" title="<?= $recom_fulldescription?>"><?= $recom_Description ?></h5>
                    <h5 class="carousel-item-pricing">$<?= $recom_lprice ?></h5>
                    <input type="checkbox" class="carousel-checkbox" name="carouselinput[]"  id="carouselinput_<?= $recom_Part_Number?>" value="<?= $recom_Part_Number ?>|<?=$recom_lprice?>|<?= $curl?>|<?=$recom_price_level?>">
                </div>
                
     <?php } ?>
     </div>
			
        </div>
        <button type="button" class="recomm_items_addtocartbtn" 
            onclick="recomm_add_to_cart()">Add Selected items to Cart</button>
        
        <button type="button" class="recomm_items_cancelbtn" 
            onclick="cancle_btn_moreinfo('<?php echo $from_cart_icon ?>')">Back</button>
			</form>
        </div>
    <?php }else{}?>