<script>

function send_request_new_address(){
      $('#new_addr_sub'). prop('disabled',true);
      var po_by_customer=$('#new_addr_po_number').val();
        $.ajax({
                  type: "POST",
                  url: '<?php echo base_url(); ?>order/setsessionponewaddr',
                  data: {po_by_customer},
                  cache: false,
                  beforeSend: function(){
                        $("#ajaxPreLoader").show();
                      },
                  success:function(res)
                  {
                      if(res==1){
                        $('#exampleModal #par_id').html('PO Number is already exists');
                        $('#exampleModal').modal('show');    

                        $('#new_addr_sub'). prop('disabled', true);
                      }else{
                        $('#new_addr_sub'). prop('disabled', false);
                        save_new_address();
                      }

                  },
                  complete:function(data){
                        $("#ajaxPreLoader").hide();
                      }
                });
    }

function save_new_address() 
    { 
    var cid=$('#cid').val();
    var firstname=$('#first_name').val();
    var secondname=$('#last_name').val();
    var new_addr_po_number=$('#new_addr_po_number').val();
    var number=$('#phone_no').val();
    var email=$('#email').val();
    var cname=$('#company_name').val();
    var address=$('#address_1').val();
    var state=$('#state').val();
    var country=$('#country').val();
    var pincode=$('#pin_code').val();
   
    if(firstname==''){
      toastr.warning("Please enter First Name", "", { positionClass: "toast-top-center" });
    }
    else if(secondname==''){
      toastr.warning("Please enter Last Name", "", { positionClass: "toast-top-center" });
    }
    else if(new_addr_po_number==''){
      toastr.warning("Please enter PO Number", "", { positionClass: "toast-top-center" });
    }
    else if(number==''){
      toastr.warning("Please enter Phone Number", "", { positionClass: "toast-top-center" });
    }
    else if(email==''){
      toastr.warning("Please enter Email", "", { positionClass: "toast-top-center" });
    }
    else if(cname==''){
      toastr.warning("Please enter Company Name", "", { positionClass: "toast-top-center" });
    }
    else if(address==''){
      toastr.warning("Please enter Address", "", { positionClass: "toast-top-center" });
    }
    else if(state==''){
      toastr.warning("Please enter State", "", { positionClass: "toast-top-center" });
    }
    else if(country==''){
      toastr.warning("Please enter Country", "", { positionClass: "toast-top-center" });
    }
    else if(pincode==''){
      toastr.warning("Please enter Pincode", "", { positionClass: "toast-top-center" });
    }
  
    else{
      var formData = new FormData(document.getElementsByName('new_address_form')[0]);// yourForm: form selector        
    // everything looks good!
    $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>order/savecartaddress",// where you wanna post
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function(){
                $("#ajaxPreLoader").show();
              },
            success: function(data) {
              if(data==1){
                $('#send_req #par_id').html('Your request for adding new shipping address has been successfully sent to Baumalight team. Please wait until we have entered it. Once we have added it, we will email you to let you know that you can continue with your order.<br />Your reference number is '+new_addr_po_number+'<br/>Thank you');

                $('#send_req').modal('show');
              }
              else if(data==0){
                toastr.warning("Please try again", "", { positionClass: "toast-top-center" });
              }else{
                toastr.warning("Email Failed to Send", "", { positionClass: "toast-top-center" });
                //window.location.reload();
              }
            },
             complete:function(data){
                  $("#ajaxPreLoader").hide();
                }
        });

    }
}
</script>