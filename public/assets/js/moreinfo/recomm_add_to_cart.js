<script>

function recomm_add_to_cart(){
  var ch_count=0;
  $('#recommended_items_form input[name="carouselinput[]"]:checked').each(function() {
    ch_count=1;
  });
    
  var cid = $('#cid').val();
  cid = cid.trim();
  if(cid == '')
  {
    //swal('Cannot load customer details. Please try later');
    toastr.warning("Cannot load customer details. Please try later", "", { positionClass: "toast-top-center" });
  }
  else if(ch_count==0)
  {
    toastr.warning("Please select alteast one recommended item", "", { positionClass: "toast-top-center" });
  }
  else{
    var formData = new FormData(document.getElementsByName('recommended_items_form')[0]);// yourForm: form selector        

    $.ajax({
        type: "POST",
        url: "addtocart-by-moreinfo",// where you wanna post
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function(){
          $("#ajaxPreLoader").show();
        },
        success: function(data) {
          basket_append();
         if(data==1){
          //swal('Items area added to Cart');
          toastr.success("Items are added to Cart", "", { positionClass: "toast-top-center" });
         }else{
          //swal('Out of Stock, Please try again for these items '+data);
          toastr.warning("Please try again for these items "+data, "", { positionClass: "toast-top-center" });
        }
        },
        complete:function(data){
          $("#ajaxPreLoader").hide();
        }
    });
  }

}

</script>