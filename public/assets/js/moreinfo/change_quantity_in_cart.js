<script>

function change_quantity_in_cart(in_value) 
{
    var quantity_val=$('#total_count').val();
    if(isNaN(quantity_val) || quantity_val==null || quantity_val===""){
      $('#total_count').val(1);
    }else{
    quantity_val = parseInt(quantity_val);
    if(in_value==2){
        var qty=parseInt(quantity_val)+1;
        var avail_stck='<?= $_POST['avl_stock']?>';
        var avail_stck=parseInt(avail_stck);
        $('#total_count').val(qty);
        $('#cart_qty').val(qty);
    }
    else if(in_value==1){
       var qty=parseInt(quantity_val)-1;
       if(qty<=0){
            toastr.warning("Quantity cannot be less than One", "", { positionClass: "toast-top-center" });
        }else{
            $('#total_count').val(qty);
            $('#cart_qty').val(qty);
        }
    }
  }
}

</script>