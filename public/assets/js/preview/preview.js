<script>

function clear_cart_item(cid) 
{
    $('#delete_cart').val(cid);
    $('#clearcart_item_modal').modal('show');
}

function cancel_order(){ 
  var id = $('#delete_cart').val();
   $('#clearcart_item_modal').modal('hide');
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>order/clearcartitem',
                data: {id},
                cache: false,
                success:function(res)
                {
                   window.location.href="index"; 
                }
        });
}

function send_order() 
{
    $('#send_order_modal').modal('show');
}

function send_order_form() 
{
  $('#send_order_modal').modal('hide');
  var cid = $('#cid').val();
  cid = cid.trim();
  $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>order/saveorderdetails',
          data: {cid},
          cache: false,
          beforeSend: function(){
            // Show image container
            $("#ajaxPreLoader").show();
          },
          success:function(res)
          {
              if(res!=0)
              {
                  $('#auto_id').val(res);
                  $('#myForm').submit();
              }
              else
              {
                  toastr.warning("Server down, Order cannot be placed now. Kindly check later", "", { positionClass: "toast-top-center" });
              }
              // alert(res);
          },
          complete:function(data)
          {
            // Hide image container
            $("#ajaxPreLoader").hide();
          }
  }); 
}


</script>