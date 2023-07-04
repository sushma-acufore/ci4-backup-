<script>

var update_flag=0;
function change_quantity_in_cart(in_value,rid,avail_stock,existing_qty,updt_qty) 
{
  if ( typeof(updt_qty) == "undefined") 
  {
      updt_qty = 0;
  }
  if(update_flag==0){
    update_flag=1;
    if(in_value==0){
        toastr.warning("Quantity cannot be less than One", "", { positionClass: "toast-top-center" });
         update_flag=0;
    }
    else if(in_value==1 && existing_qty==1){
        toastr.warning("Quantity cannot be less than One", "", { positionClass: "toast-top-center" });
         update_flag=0;
    }else{
      $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>order/updatecartitems',
                data: {in_value,rid,updt_qty},
                cache: false,
                beforeSend: function(){
                      $("#ajaxPreLoader").show();
                    },
                success:function(res)
                {
                    // alert(res);
                    update_flag=0;
                    cart_append();
                    basket_append();
                },
                complete:function(data){
                      $("#ajaxPreLoader").hide();
                    }
        });
    }
  } 
}


</script>