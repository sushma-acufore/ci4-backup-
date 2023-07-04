<script>

function cart_footer_load(){
    id='';
    $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>order/checkitemsincart',
          data: {id},
          cache: false,
          beforeSend: function(){
                    $("#ajaxPreLoader").show();
                  },
          success:function(res)
          {
              if(res==0){
                $(".cart-items-div").css("background-color","transparent");
                $('.cart_footer').hide();
                $('.existing_addr').hide();
                $('.new-addr-div').hide();
                $('#shipp_address').hide();
                $('#po_by_customer_div').hide();
                
                $('#add_product_top').show();
                
              }else{
                $('.cart_footer').show();
              }
              $('.shipp-preview-btn'). prop('disabled',false);
          },
          complete:function(data){
                    $("#ajaxPreLoader").hide();
                  }
      });  

   }

</script>