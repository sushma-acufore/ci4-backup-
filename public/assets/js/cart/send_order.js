<script>

function send_order() 
{
    var s = $("#ship_to_address").val();
    var po_by_customer = $("#po_by_customer").val();
    
    if(s==0)
    {
        $('#exampleModal #par_id').html('Please Confirm shipping address.');
        $('#exampleModal').modal('show');        
    }
    else if(po_by_customer=='' || po_by_customer==null)
    {
        $('#exampleModal #par_id').html('Please Enter PO Number');
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
                    if(res==2){
                      toastr.warning("Server down, kindly check later", "", { positionClass: "toast-top-center" });
                    }else{
                      $('#myForm').submit();
                    }
                },
                complete:function(data){
                  // Hide image container
                  $("#ajaxPreLoader").hide();
                }

        });
       
    }
    
}
</script>