<script type="text/javascript">

// for recommended modal
function check_recommended_items_yes() 
{
    $('#recommended_items_modal_text').val();
    var text=$('#recommended_items_modal_text').val();
    const myArray = text.split("|");
    var part_no = myArray[0];
    var curl = myArray[1];
    var cntry = myArray[2];
    var avl_stock = myArray[3];
    var url='more-info';
    var form = $('<form action="' + url + '" method="POST">' +
        '<input type="hidden" name="from_cart_icon" value="1" /><input type="hidden" name="part_no" value="' + part_no + '" /><input type="hidden" name="curl" value="' + curl + '" /><input type="hidden" name="cntry" value="' + cntry + '" /><input type="hidden" name="avl_stock" value="' + avl_stock + '" />' +
        '</form>');
    $('body').append(form);
    form.submit();
}

// function check_recommended_items_no() 
// {
//     var text=$('#recommended_items_modal_text').val();
//     const myArray = text.split("|");
//     var part_no = myArray[0];
//     var curl = myArray[1];
//     var cntry = myArray[2];
//     var avl_stock = myArray[3];
//     $('#recommended_items_modal').modal('hide');
//     add_to_cart(part_no,curl,cntry,avl_stock);   
// }

var flag=0;
function recommended_item_prompt(part_no,curl,cntry,avl_stock) 
{  
var text=""+part_no+"|"+curl+"|"+cntry+"|"+avl_stock+"";
$.ajax({
        type: "POST",
        url: 'check_product_recommended',
        data: {part_no},
        cache: false,
        beforeSend: function(){
            $("#ajaxPreLoader").show();
        },
        success:function(res)
        {
            if(res==1){
                $('#recommended_items_modal_text').val(text); 
                $('#recommended_items_modal').modal('show');
            }
            else{
                //add_to_cart(part_no,curl,cntry,avl_stock);
            }
            cart_append();
            basket_append();
        },
        complete:function(data){
            $("#ajaxPreLoader").show();
        }
        });
}

function price_alert(part_no){
    $('#price_alert_modal').modal('show');
}


</script>