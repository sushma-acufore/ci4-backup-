<script>

function get_ship_address_load() 
{
  //onloader 
    var cid = $('#cid').val();
    cid = cid.trim();
    $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>order/getshipaddress',
            data: {cid},
            cache: false,
            beforeSend: function(){
                $("#ajaxPreLoader").show();
              },
            success:function(res)
            {
                //alert(res);
                $('#shipp_address').html(res);
                if(res==null || res==''){
                  $('#po_by_customer_div').hide();
                }else{
                  $('#po_by_customer_div').show();
                  
                }
                cart_footer_load();
            },
            complete:function(data){
                $("#ajaxPreLoader").show();
              }
    });        
}


</script>