<script>

function delete_cart_item(a) 
{
  $('#delete_item_no').val(a);
  $('#delete_item_modal').modal('show');
}

function delete_item_modal(){
   
  var id = $('#delete_item_no').val();
  $('#delete_item_modal').modal('hide');
  $.ajax({
      type: "POST",
      url: 'index_delete_cart_item',
      data: {id},
      cache: false,
      beforeSend: function(){
        $("#ajaxPreLoader").show();
      },
      success:function(res)
      {
          toastr.success("Product deleted from cart Successfully!", "", { positionClass: "toast-top-center" });
          
          // swal("Product deleted from cart Successfully!", 
          // {
          //     icon: "success",
          // });
          // $('#cart_body').html(res);
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