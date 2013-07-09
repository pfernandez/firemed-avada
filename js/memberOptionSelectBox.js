jQuery(document).ready(function($) {
  $('.memberOption').each(function() {
    $(this).click(function() {
      $(this).addClass('active');
      $('.membershipOptions').addClass('complete');
      window.location.href = $($(this).children(".button")[0]).attr('href');
    });
  });
});
