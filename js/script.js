$(document).ready(function() {
  $('#fullpage').fullpage({
    anchors: ['page1', 'page2', 'page3'],
    responsiveWidth: 321,
    responsiveHeight: 801
  });
  $('#send').click(function(event) {
    event.preventDefault();
    form();
  })
});

$(window).on('load resize', function() {
  if ($(window).width() <= 640) {
    $('.right .social').insertAfter($('.contact-links'));
    // $('body').css({'transform': 'scale(' + $(window).width()/640 + ')'});
  } else {
    $('.contacts .social').insertAfter($('.contacts'));
  }
});

function form() {
  var content = $('#contact').serialize();
  $.ajax({
    type: 'POST',
    url: 'ajax.php',
    data: content,
    success: function(data) {
      $('#results').html(data);
    },
    error: function(xhr, str) {
      alert('Error! Form was not sent');
    }
  });
}
