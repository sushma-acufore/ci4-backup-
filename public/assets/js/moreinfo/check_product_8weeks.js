<script>

var flag=0;
function check_product_8weeks(){
  if(flag==0){
  flag=1;
  var m_status = '<?php echo $ee['mstatus']; ?>';
  var pno = '<?php echo $ee['pno']; ?>';
  $.ajax({
      type: "POST",
      url: 'check_cartproduct_discount',
      data: {pno},
      cache: false,
      success:function(res)
      { 
          if(res==0){
            //alert(m_status)
            if(m_status==1)
            {
                $('#exampleModal').modal('show');
            }
            else
            {
                $('#model_confirm_state').val('0');
                continue_add_to_cart(); 
            }
              
          }else{
            $('#model_confirm_state').val('0');
            continue_add_to_cart(); 
            
          }
      }
    });
  }
}



</script>