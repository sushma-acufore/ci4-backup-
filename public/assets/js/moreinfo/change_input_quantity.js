<script>

function change_input_quantity(){
var qty=$('#total_count').val();
qty = qty.trim();
qty = parseInt(qty);
  if(isNaN(qty) || qty=='' || qty==null){
      //toastr.warning("Sorry..! You have reached maximun available quantity", "", { positionClass: "toast-top-center" });
      $('#total_count').val('01');
  }else if(qty<=0){
      toastr.warning("Quantity cannot be less than One", "", { positionClass: "toast-top-center" });
      $('#total_count').val('01');
  }
  else{
      $('#total_count').val(qty);
      $('#mqty').val(qty);
  }
}


</script>