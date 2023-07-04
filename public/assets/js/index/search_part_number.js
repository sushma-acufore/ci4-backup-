<script type="text/javascript">

function search_part_number() 
{
    var curl = "<?php echo $curl; ?>";
    var cntry = "<?php echo $cntry; ?>"; 
    var temp_curl = $('#temp_curl').val(); 
    if(temp_curl=='')
    {
        $('#temp_curl').val(curl); 
    }else
    {
        if(temp_curl == 'CAD')
        {
            var curl = "CAD";
            var cntry = "CA"; 
        }else if(temp_curl == 'USD')
        {
            var curl = "USD";
            var cntry = "US"; 
        }
    }

    var arg = $('#pid').val();
    var pd1 = $('#pd1').val();
    var pd2 = $('#pd2').val();
    if(arg!='' || pd1!='' || pd2!='')
    {
      var search = arg;
      $.ajax({
              type: "POST",
              url: '<?php echo base_url(); ?>search_product_details',
              data: {curl,cntry,search,pd1,pd2},
              cache: false,
              beforeSend: function(){
                $("#ajaxPreLoader").show();
              },
              success:function(res)
              {
                  $('#pidres').html(res);
                  
              },
              complete:function(data){
                $("#ajaxPreLoader").hide();
              }
      });
    }else
    {
        $('#pidres').html('');
    }
    
    $("#placeholder-glow").removeClass("placeholder-glow");
}

function change_quantity(in_value,prt_no) 
{
    var a = in_value;
    var c_qty = $('#qty_value'+prt_no+'').val();
    c_qty = parseInt(c_qty);
    var stk_val = $('#stk_val'+prt_no+'').html();
    stk_val = parseInt(stk_val);
    if(a==2)
    {
        c_qty = c_qty + 1;
    }
    else if(a==1)
    {
        if(c_qty<=1)
            {}else{ c_qty = c_qty - 1; }
    }
    if(c_qty<10){
        $('#qty_value'+prt_no+'').val('0'+c_qty);
    }else{
        $('#qty_value'+prt_no+'').val(c_qty);   
    }
}

function change_input_quantity(part_no,avl_qty){
	var qty=$('#qty_value'+part_no).val();
  qty = qty.trim();
  qty = parseInt(qty);
  if(isNaN(qty) || qty=='' || qty==null){
      //toastr.warning("Sorry..! You have reached maximun available quantity", "", { positionClass: "toast-top-center" });
      $('#qty_value'+part_no).val('01');
  }else if(qty<=0){
      toastr.warning("Quantity cannot be less than One", "", { positionClass: "toast-top-center" });
      $('#qty_value'+part_no).val('01');
  }
  else{
      $('#qty_value'+part_no).val(qty);
      $('#mqty').val(qty);
  }
}

$(document).ready(function()
{
    var ldn = $('#login_dealer_name').val();
    select_cid(ldn);
    //alert(ldn);
});
$(document).click(function (e) 
{
  if ($(e.target).is('#exampleModal')) 
  {
      $('#exampleModal').fadeOut(500);
      $('#model_confirm_state').val('0');
      continue_add_to_cart();    
  }
});
    
function model_cnf_cancel() 
{
  $('#model_confirm_state').val('0');
  continue_add_to_cart();
}
function model_cnf_yes() 
{
  $('#model_confirm_state').val('1');
  continue_add_to_cart();   
}

function select_cid(a) 
{
  $('#cid').val(a);
  //alert(a);
  var search = a;
  var E_EID_st = "<?php echo $E_EID_st; ?>";
  
  if(E_EID_st!=1)
  {
          // document.getElementById("cust_result").style.display = "none";
          $.ajax({
            type: "POST",
            url: 'search_cust_details_for_modal.php',
            data: {search},
            cache: false,
            beforeSend: function(){
              $("#ajaxPreLoader").show();
            },
            success:function(res)
            {
              cart_append(); 
            },
            complete:function(data){
              $("#ajaxPreLoader").hide();
            }
          });
  }
  else
  {
      cart_append();
  }
}

function price_alert(part_no){
    $('#price_alert_modal').modal('show');
}



</script>