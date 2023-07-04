<script>

function continue_add_to_cart() 
{
  var mstatus = $('#model_confirm_state').val();
  mstatus = mstatus.trim();
  var prod_8weeks ='<?php echo $ee['mstatus']; ?>';
  var stk_discount ='<?php echo $ee['stk_discount']; ?>';
  var apply_discount ='<?php echo $ee['is_stock_dealer']; ?>';
  var curl = '<?= $curl?>';
  var cntry = '<?= $cntry?>';
  var cid = $('#cid').val();
  cid = cid.trim();
  var pno = '<?php echo $ee['pno']; ?>';
  pno = pno.trim();
  var cid = $('#cid').val();
  cid = cid.trim();
  var qty = $('#total_count').val();
  var lprice='<?php echo $ee['lprice']; ?>'; 
  if(cid == '')
  {
      //swal('Cannot load customer details. Please try later');
      toastr.warning("Cannot load customer details. Please try later", "", { positionClass: "toast-top-center" });
      flag=0;
  }
  else if(qty<=0)
  {
      //swal('Cannot load customer details. Please try later');
      toastr.warning("Quantity cannot be Zero", "", { positionClass: "toast-top-center" });
      flag=0;
  }
  else if(lprice<=0)
  {
      //swal('Cannot load customer details. Please try later');
      $('#price_alert_modal').modal('show');
      flag=0;
  }
  else
  {
    $.ajax({
          type: "POST",
          url: 'add_to_cart',
          data: {qty,mstatus,prod_8weeks,stk_discount,curl,cntry,pno,cid,apply_discount},
          cache: false,
          beforeSend: function(){
            $("#ajaxPreLoader").show();
          },
          success:function(res)
          {
            flag=0;
            basket_append();
            res = res.trim();
            if(res==3)
            {
                toastr.warning("Cart items currency is not matching! Please change the currency or delete cart items and try with other currency", "", { positionClass: "toast-top-center" });
                flag=0;
            }
            else if(res==4)
            {
              $('#invalid_discount_modal').modal('show');
              flag=0;
            }else if(res==2){
              toastr.success("Item is added to cart", "", { positionClass: "toast-top-center" });
              flag=0;
            }else{
              toastr.warning("Error while Adding product", "", { positionClass: "toast-top-center" });
              flag=0;
            }
            
          },
          complete:function(data){
          $("#ajaxPreLoader").hide();
        }
      });
  }
}
</script>