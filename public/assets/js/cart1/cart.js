<script>

$(document).ready(function()
{
  var ldn = $('#login_dealer_name').val();
  select_cid(ldn);

  //get_ship_address();
  //cart_append();
  //cart_footer();

 // get_ship_address_load();
  cart_append_load();
  //cart_footer_load();
 
    // alert("ldn");
});

function select_cid(a) 
{
  $('#cid').val(a);  
}

//cancel order in cart(all items)
function clear_cart_item(cid) 
{
    $('#delete_cart').val(cid);
    $('#clearcart_item_modal').modal('show');
}


</script>