application = application || {};

application.articleComments = {};
application.articleComments.ready = function($) {

  $('#js-comments-show-all').on('click', function(event){
    event.stopPropagation();
    $('#js-comments-recommended').hide();
    $('#js-comments-page').show();
    $('#js-comments-show-all').hide();
    self.location = '#responses';
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

  $("#new_comment_form").on("pjax:end", function() {
    $('#js-comments-recommended').hide();
    $('#js-comments-page').show();
    $('#js-comments-show-all').hide();
    $.pjax.reload({container:"#comments_list"});  //Reload ListView
  });

};


// attach ready event
$(document)
  .ready(application.articleComments.ready);

function funcSuccess(id,response)
{
  alert ("Ajax works!");
  $('#comment_'+id).html(response);
}

function update_comment(id,id_article)
{
  var comment="yess7";
  $.ajax({
    url:"update-comment?id="+id+"&id_article="+id_article,
    type:"POST",
    data:{id:id,comment:comment},
    datatype:"json",
    // beforeSend:funcBefore,
    // success:funcSuccess(id,response)
    success:function (response)
    {
      if (response!=null)
      {
        $('#comment_'+id).html(response);
        swal("Comment is updated!", "You clicked the button!", "success");
      }
    }
  });
}

function delete_comment(id,id_article)
{
  swal({   title: "Are you sure?",   text: "Your will not be able to recover this comment!",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!" }, function()
  {
    $.ajax({
      url:"delete-comment",
      type:"POST",
      data:{id:id,id_article:id_article},
      datatype:"json",
      // beforeSend:funcBefore,
      // success:funcSuccess(id,response)
      success:function (response)
      {
        if (response=='success')
        {
          $('#js-comments-recommended').hide();
          $('#js-comments-page').show();
          $('#js-comments-show-all').hide();
          $.pjax.reload({container:"#comments_list"});  //Reload ListView
          swal("Comment is deleted!", "You clicked the button!", "success")
        }
        else
        {
          sweetAlert("Oops...", "Something went wrong!", "error");
        }
      }
    });
  });
}
