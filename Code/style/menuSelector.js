$(document).ready(function() {

    $('li.nav-item').click(function(){
  $(this).addClass('current').siblings().removeClass('current');
  });

});
