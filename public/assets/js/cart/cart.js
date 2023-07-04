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


  //adding place holder for search2 box
  $(".select2-search__field").attr("placeholder", "Type here to search");
  
  $("input#po_by_customer").on({
    keydown: function(e) {
      if (e.which === 32)
        return false;
    }
  });

  $("input#new_addr_po_number").on({
    keydown: function(e) {
      if (e.which === 32)
        return false;
    }
  });
  
  function check_po_new_addr(){
    $('#new_addr_sub'). prop('disabled',true);
      var po_by_customer=$('#new_addr_po_number').val();
    $.ajax({
              type: "POST",
              url: '<?php echo base_url(); ?>order/setsessionponewaddr',
              data: {po_by_customer},
              cache: false,
              beforeSend: function(){
                    $("#ajaxPreLoader").show();
                  },
              success:function(res)
              {
                  if(res==1){
                    $('#exampleModal #par_id').html('PO Number is already exists');
                    $('#exampleModal').modal('show');    

                    $('#new_addr_sub'). prop('disabled', true);
                  }else{
                    $('#new_addr_sub'). prop('disabled', false);
                  }

              },
              complete:function(data){
                    $("#ajaxPreLoader").hide();
                  }
            });

  }

    function set_session_po()
    {
      $('.shipp-preview-btn'). prop('disabled',true);
      var po_by_customer=$('#po_by_customer').val();
      if(po_by_customer=='' || po_by_customer==null)
      {
          $('.shipp-preview-btn'). prop('disabled',false);
      }
      else
      {
      $.ajax({
              type: "POST",
              url: '<?php echo base_url(); ?>order/setsessionpo',
              data: {po_by_customer},
              cache: false,
              beforeSend: function(){
                    //$("#ajaxPreLoader").show();
                  },
              success:function(res)
              {
                  if(res==1){
                    //toastr.warning("PO Number is already exists, please try with another PO Number", "", { positionClass: "toast-top-center" });
                    $('#exampleModal #par_id').html('PO Number is already exists');
                    $('#exampleModal').modal('show');    

                    $('.shipp-preview-btn'). prop('disabled', true);
                  }else{
                    $('.shipp-preview-btn'). prop('disabled', false);
                  }

              },
              complete:function(data){
                   // $("#ajaxPreLoader").hide();
                  }
            });
      }
    }
    function blink_text() 
    {
      $('#blink').fadeOut(500);
      $('#blink').fadeIn(500);
    }
setInterval(blink_text, 1000);


function createNewAddress() 
{
  alert();
    // $('#shipp_address').hide();
    // $('.existing_addr').hide();
    // $('.shipp-preview-btn').hide();  
    // $('#po_by_customer_div').hide();
    // $('.new-addr-div').show();

    // a='';
    // $.ajax({
    //         type: "POST",
    //         url: "unset_shipping_session.php",// where you wanna post
    //         data: a,
    //         processData: false,
    //         contentType: false,
    //         beforeSend: function(){
    //           $("#ajaxPreLoader").show();
    //         },
    //         success: function(data) {
              
    //         },
    //          complete:function(data){
    //           $("#ajaxPreLoader").hide();
    //         }
    //     });
}


</script>
