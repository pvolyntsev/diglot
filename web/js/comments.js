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

  var addFormActive = false;
  $('#js-add-comment').on('click', function(event){
    if (addFormActive)
    {
      event.stopPropagation();
      return false;
    }

    $('#js-add-card-placeholder').addClass('hidden2');
    $('#js-add-card-form').addClass('visible2');

    setTimeout(function(){
      $('#js-add-card-user').addClass('visible2');
      $('#comment-comment').focus();
      addFormActive = true;
    }, 200);
  });

  $('#js-add-comment #comment-comment').on('blur', function(event){
    if (!addFormActive || $(this).val().length > 0)
    {
      event.stopPropagation();
      return false;
    }

    $('#js-add-card-form').removeClass('visible2');
    $('#js-add-card-user').removeClass('visible2');

    setTimeout(function(){
      $('#js-add-card-placeholder').removeClass('hidden2');

      addFormActive = false;
    }, 200);
  });
};

// attach ready event
$(document)
  .ready(application.articleComments.ready);

$("document").ready(function() {

  $("#new_comment_form").on("pjax:end", function() {
    $('#js-comments-recommended').hide();
    $('#js-comments-page').show();
    $('#js-comments-show-all').hide();
    $.pjax.reload({container:"#comments_list"});  //Reload ListView
  });

  // $("#delete_note").on("pjax:end", function () {
  //   $.pjax.reload({container: "#comments_list"});  //Reload ListView
  //   $.pjax.reload({container: "#comments_selected_list"});  //Reload ListView
  //   return false;
  // });

});
