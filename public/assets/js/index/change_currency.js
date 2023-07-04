<script>
function change_currency(a) 
{
    $.ajax({
                type: "POST",
                url: '<?php echo base_url() ?>create_session_for_currency',
                data: {a},
                cache: false,
                beforeSend: function(){
                  $("#ajaxPreLoader").show();
                },
                success:function(res)
                {},
                complete:function(data){
                  $("#ajaxPreLoader").hide();
                }
        });
    var d = 1;
    var data = $('#pid').val(); 
    var pd1 = $('#pd1').val();
    var pd2 = $('#pd2').val();
    var curl = "<?php echo $curl; ?>";
    var cntry = "<?php echo $cntry; ?>";
    
    if(pd1!='' || pd2!='')
    {
        d=2;
    }
    else
    {
        d=3;
    }

    var oncur = $('#curl_area').html();
    a = a.trim();
    if(a == 'USD')
    {
        $('#curl_area').html('USD');
        oncur = 'USD';          
        cntry = 'US';
    }else if(a == 'CAD')
    {
        $('#curl_area').html('CAD');
        oncur = 'CAD';
        cntry = 'CA';
    }
    curl = oncur;  
    $('#temp_curl').val(curl);
    var arg = $('#pid').val();
    var pd1 = $('#pd1').val();
    var pd2 = $('#pd2').val();
    if(arg!='' || pd1!='' || pd2!='')
    {
        var search = arg;
        $.ajax({
                type: "POST",
                url: 'search_product_details',
                data: {curl,cntry,search,pd1,pd2},
                cache: false,
                beforeSend: function(){
                  $("#ajaxPreLoader").show();
                },
                success:function(res)
                {
                    // alert(res);
                    $('#pidres').html(res);
                },
                complete:function(data){
                  $("#ajaxPreLoader").hide();
                }
        });
    }else
    {
        $('#pidres').html('');
    }
}


</script>