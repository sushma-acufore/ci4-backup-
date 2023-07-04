<script type="text/javascript">
function cart_footer(){
    id='';
    $.ajax({
          type: "POST",
          url: 'check_items_incart',
          data: {id},
          cache: false,
          beforeSend: function(){
            $("#ajaxPreLoader").show();
            },
          success:function(res)
          {
              if(res==0){
                $('#cart_body_title1').hide();
              }else{
                $('#cart_body_title1').show();
              }
          },
          complete:function(data){
            $("#ajaxPreLoader").hide();
            }
      });  

   }
</script>