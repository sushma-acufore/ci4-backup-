<script>

function send_order() 
{
    var s = $("#ship_to_address").val();

    if(s==0)
    {
        $('#exampleModal').modal('show');        
    }
    else
    {
        var cid = $('#cid').val();
        cid = cid.trim();
        $.ajax({
                type: "POST",
                url: '<?php echo base_url(); ?>order/savepreviewdetails',
                data: {cid},
                cache: false,
                beforeSend: function(){
                  // Show image container
                  $("#ajaxPreLoader").show();
                },
                success:function(res)
                {
                    if(res==2)
                    {
                      toastr.warning("Server down, kindly check later", "", { positionClass: "toast-top-center" });
                    }else{
                      //$('#myForm').submit();
                    }
                    //$("#hi").html(res);
                    $('#myForm').submit();
                },
                complete:function(data){
                  // Hide image container
                  $("#ajaxPreLoader").hide();
                }

        });
       
    }   
}

</script>