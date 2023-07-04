<script>

function cart_append_load() 
{
  $('.shipp-preview-btn'). prop('disabled',true);

    var cid = $('#cid').val();
    cid = cid.trim();
    $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>order/refreshcart',
            data: {cid},
            cache: false,
            beforeSend: function(){
                $("#ajaxPreLoader").show();
              },
            success:function(res)
            {
                $('#cart_body').html(res);
                get_ship_address_load();
            },
            complete:function(data){
                $("#ajaxPreLoader").show();
              }
    });        
}


</script>