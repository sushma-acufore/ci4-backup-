<script>

function cart_append() 
    {
        var cid = $('#cid').val();
        cid = cid.trim();
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>order/refreshcart',
                data: {cid},
                cache: false,
                beforeSend: function()
                {
                  $("#ajaxPreLoader").show();
                },
                success:function(res)
                {
                    $('#cart_body').html(res);
                },
                complete:function(data)
                {
                  $("#ajaxPreLoader").hide();
                }
        });        
    }


</script>