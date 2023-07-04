<script>

$(document).ready(function()
{
    call_order();
    function call_order() 
    {
      $.ajax({
              type: "POST",
              url: '<?php echo base_url(); ?>myorders',
              data: {},
              cache: false,
              success:function(res)
              {
                  // alert(res);
                  $('#get_order').html(res);
              }
      });
    }

});



</script>