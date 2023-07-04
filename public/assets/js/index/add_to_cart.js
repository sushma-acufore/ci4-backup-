<script type="text/javascript">

function add_to_cart(part_no,curl,cntry,avl_stock) 
{  
  $('#avail_stck').val(avl_stock);
  if(flag==0){
    flag=1;
    var qty = $('#qty_value'+part_no+'').val(); 
    qty = qty.trim();
    qty = parseInt(qty);
    $('#mqty').val(qty);

    var cid = $('#cid').val();
    cid = cid.trim();
    var pno = part_no;
    pno = pno.trim();
    var cid = $('#cid').val();
    cid = cid.trim();
    if(cid == '')
    {
      //swal('Cannot load customer details. Please try later');
      toastr.warning("Cannot load customer details. Please try later", "", { positionClass: "toast-top-center" });
      flag=0;
    }else
    {           
      $.ajax({
          type: "POST",
          url: '<?php echo base_url(); ?>check_product_in_8weeks',
          data: {curl,cntry,pno,cid},
          cache: false,
          beforeSend: function(){
            $("#ajaxPreLoader").show();
          },
          success:function(res)
          {
            
            var text = res;
            var res = text.trim();
            var text = res;
            const myArray = text.split("||");
            var prod_8weeks = myArray[0];
            var stk_discount = myArray[1];
            var apply_discount = myArray[2];
            $('#prod_8weeks').val(prod_8weeks);
            $('#stk_discount').val(stk_discount);
            $('#apply_discount').val(apply_discount);

            $('#pno').val(pno);
            $('#Mcurl').val(curl);
            $('#Mcntry').val(cntry);
            if(prod_8weeks==1)
            {
                $('#exampleModal').modal('show');
            }
            else
            {
                $('#model_confirm_state').val('0');
                continue_add_to_cart(); 
            }
          },
          complete:function(data){
            $("#ajaxPreLoader").show();
          }
      });
    }
  }//end of else part 
}

function continue_add_to_cart() 
{
 var mstatus = $('#model_confirm_state').val();
 mstatus = mstatus.trim();
 var prod_8weeks = $('#prod_8weeks').val();
 var stk_discount = $('#stk_discount').val();
 var apply_discount = $('#apply_discount').val();
 var curl = $('#Mcurl').val();
 var cntry = $('#Mcntry').val();
 var cid = $('#cid').val();
 cid = cid.trim();
 var pno = $('#pno').val();
 pno = pno.trim();
 var cid = $('#cid').val();
 cid = cid.trim();
 var qty = $('#mqty').val();
 var avl_stock=$('#avail_stck').val();

  if(cid == '')
  {
      toastr.warning("Cannot load customer details. Please try later", "", { positionClass: "toast-top-center" });
        flag=0;
  }else
  {
  $.ajax({
      type: "POST",
      url: 'add_to_cart_index',
      data: {qty,mstatus,prod_8weeks,stk_discount,curl,cntry,pno,cid,apply_discount},
      cache: false,
      beforeSend: function(){
        $("#ajaxPreLoader").show();
      },
      success:function(res)
      {
        flag=0;
        res = res.trim();
        if(res==3)
        {
            toastr.warning("Cart items currency is not matching! Please change the currency or delete cart items and try with other currency", "", { positionClass: "toast-top-center" });
            $("#ajaxPreLoader").hide();
        }else if(res==4){
            $("#ajaxPreLoader").hide();
            $('#invalid_discount_modal').modal('show');
            recommended_item_prompt(pno,curl,cntry,avl_stock);
        }
        else if(res==2){
            recommended_item_prompt(pno,curl,cntry,avl_stock);
        }else{
            toastr.warning("Error while adding item to cart", "", { positionClass: "toast-top-center" });
        }
      },
      complete:function(data){
        $("#ajaxPreLoader").show();
      }
    });
  }

}

function cart_append() 
{
  var cid = $('#cid').val();
  cid = cid.trim();
  $.ajax({
        type: "POST",
        url: 'index_cart_append',
        data: {cid},
        cache: false,
        beforeSend: function(){
          // Show image container
          $("#ajaxPreLoader").show();
        },
        success:function(res)
        {
            // alert(res);
            if(res!=1)
            {
                document.getElementById("cart_body_title").style.display = "block";
                document.getElementById("cart_body_title1").style.display = "block";
                $('#cart_body').html(res);
                cart_footer();
            }else
            {
                document.getElementById("cart_body_title").style.display = "none";
                document.getElementById("cart_body_title1").style.display = "none";
                $('#cart_body').html('');
                cart_footer();
            }
        },
        complete:function(data){
          // Hide image container
          $("#ajaxPreLoader").hide();
        }
  });        
}

var update_flag=0;

function change_quantity_in_cart(in_value,rid,avail_stock,existing_qty,updt_qty) 
{
    if(update_flag==0){
        update_flag=1;
    if(in_value==0){
        //swal('Quantity cannot be less than One');
        toastr.warning("Quantity cannot be less than One", "", { positionClass: "toast-top-center" });
        update_flag=0;  
                        
    }
    // else if(in_value==2 && avail_stock==existing_qty){
    //     //swal('Sorry..! You have reached maximun available quantity'); 
    //     toastr.warning("Sorry..! You have reached maximun available quantity", "", { positionClass: "toast-top-center" });
                               
    // }
    else if(in_value==1 && existing_qty==1){
        //swal('Quantity cannot be less than One');
        toastr.warning("Quantity cannot be less than One", "", { positionClass: "toast-top-center" });   
        update_flag=0;                         
    }
    else{
        $.ajax({
                type: "POST",
                url: 'update_cart',
                data: {in_value,rid,updt_qty},
                cache: false,
                beforeSend: function(){
                  $("#ajaxPreLoader").show();
                },
                success:function(res)
                {
                    // alert(res);
                    update_flag=0;
                    cart_append();
                    basket_append();
                },
                complete:function(data){
                  $("#ajaxPreLoader").hide();
                }
        });
    }
}
}

function change_input_quantity_cart(id,part_no,avl_qty,exis_qty){
    var qty=$('#qty_value_cart'+part_no).val();
    if(isNaN(qty) || qty==null || qty===""){
      $('#qty_value_cart'+part_no).val(exis_qty);
    }else{
    qty = qty.trim();
    qty = parseInt(qty);
    var updt_qty = parseInt(qty);
    var avl_qty = parseInt(avl_qty);
    var exis_qty = parseInt(exis_qty);

    // if(qty>avl_qty){
    //     toastr.warning("Sorry..! You have reached maximun available quantity", "", { positionClass: "toast-top-center" });
    //     $('#qty_value_cart'+part_no).val(exis_qty);
    // }
    // else 
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


</script>