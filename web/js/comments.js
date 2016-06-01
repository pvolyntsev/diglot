application = application || {};

application.articleComments = {};
application.articleComments.ready = function($) {

  $('#js-comments-show-all').on('click', function(event){
    event.stopPropagation();
    $('#js-comments-recommended').hide();
    $('#js-comments-page').show();
    $('#js-comments-show-all').hide();
    return false;
  });

  $('#addCommment').on('click', function(){
    $('#newComment').val()
  });

};

// attach ready event
$(document)
  .ready(application.articleComments.ready);

$("document").ready(function() {
  $("#new_note").on("pjax:end", function () {
    $('#js-comments-recommended').hide();
    $('#js-comments-page').show();
    $('#js-comments-show-all').hide();
    $.pjax.reload({container: "#comments_list"});  //Reload ListView
    return false;
  });
});
