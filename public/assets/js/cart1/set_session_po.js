<script type="text/javascript">
    function set_session_po()
    {
        var po_by_customer=$('#po_by_customer').val();
        if(po_by_customer=='' || po_by_customer==null)
        {
            $('.shipp-preview-btn'). prop('disabled',false);
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
                                toastr.warning("PO Number is already exists, please try with another PO Number", "", { positionClass: "toast-top-center" });
                                $('.shipp-preview-btn'). prop('disabled', true);
                            }else
                            {
                                $('.shipp-preview-btn'). prop('disabled', false);
                            }

                        },
                        complete:function(data)
                        {
                            $("#ajaxPreLoader").hide();
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