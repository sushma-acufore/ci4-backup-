<script>

function cancel_order(){ 
  var id = $('#delete_cart').val();
   $('#clearcart_item_modal').modal('hide');
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>order/clearcartitem',
                data: {id},
                cache: false,
                success:function(res)
                {
                  // alert(res);
                   window.location.href= "<?php echo base_url(); ?>"; 
                }
        });
}


</script>