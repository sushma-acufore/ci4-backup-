<script>
    //for page reload
    var loader = document.getElementById("preloader");
    window.addEventListener("load", function(){
        loader.style.display="none";
    })


    // for ajaxPreLoad script
    var ajaxLoad = document.getElementById("ajaxPreLoader");

    window.addEventListener("load", function(){
        ajaxLoad.style.display="none";
    })

    
//script for cart refresh in header 
function basket_append() 
{
    var cid = $('#cid').val();
    cid = cid.trim();
    $.ajax({
            type: "POST",
            url: '<?php echo base_url(); ?>order/refresh_basket',
            data: {cid},
            cache: false,
            success:function(res)
            {
               // alert(res);
                if(res!=1)
                {
                    $('#basket_body').html(res);
                }else
                {
                    document.getElementById("cart_body_title").style.display = "none";
                    document.getElementById("cart_body_title1").style.display = "none";
                    $('#basket_body').html('');
                }
            }
          });        
}



</script>