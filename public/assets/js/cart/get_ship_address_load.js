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
                    check_shipping_addr();
                    cart_footer_load();
                },
                complete:function(data){
                    $("#ajaxPreLoader").show();
                  }
        });        
    }
function get_ship_address() 
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
                $('#shipp_address').html(res);
                if(res==null || res==''){
                  $('#po_by_customer_div').hide();
                }else{
                  $('#po_by_customer_div').show();
                }
                
            },
            complete:function(data){
                $("#ajaxPreLoader").hide();
              }
    });        
}

function check_shipping_addr()
{
    var ship_to_address=$('#ship_to_address').val();    
    if(ship_to_address!='' || ship_to_address!=null)
    {
        var a=$('#ship_to_address').val();
        add_shipping_address(a);
    }
}
function add_shipping_address(a) 
    {
        var cid = $('#cid').val();
        cid = cid.trim();
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>order/getshipaddressinfo',
                data: {cid,a},
                cache: false,
                beforeSend: function(){
                      // Show image container
                      $("#ajaxPreLoader").show();
                    },
                success:function(res)
                {
                    // alert(res);
                    $('#shipp_info').html(res);
                },
                complete:function(data){
                      // Hide image container
                      $("#ajaxPreLoader").hide();
                    }
        });
    }

</script>