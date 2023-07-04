<?php include_once('public/assets/js/footer/footer.js'); ?>    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
</script>

<script>
function stock_dealer_alert(product,sp_price,stock_dealer_discount,url){ 
    if(stock_dealer_discount>0){
    var stck_dealer_disc=((sp_price*stock_dealer_discount)/100);
    var stock_dealer_price=parseFloat(sp_price)-parseFloat(stck_dealer_disc);

    stck_dealer_disc=parseFloat(stck_dealer_disc).toFixed(2)
    stock_dealer_price=parseFloat(stock_dealer_price).toFixed(2)
    var stock_dealer_discount=parseFloat(stock_dealer_discount).toFixed(2);

    $('#part_number').val(product);
    $('#url').val(url);
    $('#product_id').html(product);
    $('#dealer_discount').html(stock_dealer_discount);
    $('#dealer_discount_amount').html(stck_dealer_disc);
    $('#stock_dealer_price').html(stock_dealer_price);
    $('#stock_dealer_modal').modal('show');
    }else{
        $('#no_discount_modal').modal('show');        
    }
}
</script>

</body>
<!-- Footer -->

<a href="help" style="bottom: 10px;position: fixed;float: right;right: 10px;"><img src="<?php echo base_url(); ?>public/assets/img/Yellow-help-question.png" alt="copy-right" /></a></p>
<!-- Footer -->
</html>