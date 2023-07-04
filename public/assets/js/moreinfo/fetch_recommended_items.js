<script type="text/javascript">

function fetch_recommended_items(){
  var part_no='<?php echo $ee['pno']; ?>';
  var curl='<?php echo $ee['curl']; ?>';
  var cntry='<?= $cntry?>';
  var avl_stock = '<?= $_POST['avl_stock']?>';
  // console.log(part_no,curl,cntry);

  $.ajax({
      type: "POST",
      url: 'recommendedIitem',
      data: {part_no,curl,cntry,avl_stock},
      cache: false,
      success:function(res)
      {
          $('#recommended_carousel_part').html(res);
      }
  });
}

</script>