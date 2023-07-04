<script type="text/javascript">
    function check_po_before_preview()
    {
    var s = $("#ship_to_address").val();
    var po_by_customer = $("#po_by_customer").val();
    
    if(s==0)
    {
        $('#exampleModal #par_id').html('Please Confirm shipping address.');
        $('.shipp-preview-btn'). prop('disabled',false);
        $('#exampleModal').modal('show');        
    }
    else if(po_by_customer=='' || po_by_customer==null)
    {
        $('#exampleModal #par_id').html('Please Enter PO Number');
        $('.shipp-preview-btn'). prop('disabled',false);
        $('#exampleModal').modal('show');        
    }
        else
        {
            $.ajax({
                        type: "POST",
                        url: '<?php echo base_url(); ?>order/setsessionpo',
                        data: {po_by_customer},
                        cache: false,
                        beforeSend: function()
                        {
                            $("#ajaxPreLoader").show();
                        },
                        success:function(res)
                        {
                            if(res==1)
                            {
                                //toastr.warning("PO Number is already exists, please try with another PO Number", "", { positionClass: "toast-top-center" });
                                $('#exampleModal #par_id').html('PO Number is already exists');
                                $('#exampleModal').modal('show');   
                                $('.shipp-preview-btn'). prop('disabled', false);
                            }else
                            {
                                $('.shipp-preview-btn'). prop('disabled', false);
                                send_order();
                            }

                        },
                        complete:function(data)
                        {
                            $("#ajaxPreLoader").show();
                        }
            });
        }
    }
  function blink_text() {
    $('#blink').fadeOut(500);
    $('#blink').fadeIn(500);
}
setInterval(blink_text, 1000);
</script>