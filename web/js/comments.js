application = application || {};

application.articleComments = {};
application.articleComments.ready = function($) {

  $('#js-comments-show-all').on('click', function(){
    $(this).find('a').text('Show more responses');
    $('#js-comments-recommended').hide();
    $('#js-comments-page').show();
  });

};

// attach ready event
$(document)
  .ready(application.articleComments.ready)
;