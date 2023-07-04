<script>

//deleting item in cart
function delete_cart_item(a) 
{
    $('#delete_item_no').val(a);
    $('#delete_item_modal').modal('show');
}
function delete_item_modal()
{
   var id = $('#delete_item_no').val();
   $('#delete_item_modal').modal('hide');
      $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>order/deletecartitem',
          data: {id},
          cache: false,
          beforeSend: function(){
            $("#ajaxPreLoader").show();
          },
          success:function(res)
          {
              // alert(res);
              toastr.success("Product deleted from cart Successfully!", "", { positionClass: "toast-top-center" });
              //get_ship_address();
              cart_append();
              basket_append();
              cart_footer();
          },
          complete:function(data){
            $("#ajaxPreLoader").hide();
          }
      });  
}

</script>