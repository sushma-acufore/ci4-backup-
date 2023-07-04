<script type="text/javascript">

function change_input_quantity_cart(id,part_no,avl_qty,exis_qty,updt_qty)
{
  
    var qty=$('#qty_value_cart'+part_no).val();
   
    if(isNaN(qty) || qty==null || qty===""){
      $('#qty_value_cart'+part_no).val(exis_qty);
    }else{
    //qty = qty.trim();
    qty = parseInt(qty);
    var updt_qty = parseInt(qty);
    var avl_qty = parseInt(avl_qty);
    var exis_qty = parseInt(exis_qty);
    
    if(qty<=0){
        toastr.warning("Quantity cannot be less than One", "", { positionClass: "toast-top-center" });
        $('#qty_value_cart'+part_no).val(exis_qty);
    }
    else{
        if(qty>exis_qty){
            change_quantity_in_cart(3,id,avl_qty,exis_qty,updt_qty);
        }
        else if(qty<exis_qty){
            change_quantity_in_cart(3,id,avl_qty,exis_qty,updt_qty);
        }
        $('#qty_value_cart'+part_no).val(qty);

    }
  }
}


function createNewAddress() 
{
    $('#shipp_address').hide();
    $('.existing_addr').hide();
    $('.shipp-preview-btn').hide();  
    $('#po_by_customer_div').hide();
    $('.new-addr-div').show();
    a='';
    $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>order/unsetshippingsession",// where you wanna post
            data: a,
            processData: false,
            contentType: false,
            beforeSend: function(){
              $("#ajaxPreLoader").show();
            },
            success: function(data) 
            {
              
            },
             complete:function(data)
             {
              $("#ajaxPreLoader").hide();
            }
        });
}

</script>