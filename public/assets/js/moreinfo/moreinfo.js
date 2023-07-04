<script>

function cancle_btn_moreinfo(val){
  if(val==1){
    window.location.href="cart";
  }else if(val==0){
    window.location.href="index";
  }
}

$(".carousel").owlCarousel({
  margin: 10,
  loop: false,
  autoplay: false,
  autoplayTimeout: 2000,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 1,
      nav: false,
    },
    500: {
      items: 2,
      nav: false,
    },
    750: {
      items: 2,
      nav: false,
    },
    1000: {
      items: 4,
      nav: false,
    },
  }
})


window.onload = function() {
    //add_to_cart();
    basket_append();
    // fetch_recommended_items();
};


$(document).click(function (e) 
{
  if ($(e.target).is('#exampleModal')) 
  {
      $('#exampleModal').fadeOut(500);
      $('#model_confirm_state').val('0');
      continue_add_to_cart();    
  }
});

function model_cnf_cancel() 
{
  $('#model_confirm_state').val('0');
  continue_add_to_cart();
}
function model_cnf_yes() 
{
  $('#model_confirm_state').val('1');
  continue_add_to_cart();   
}




</script>