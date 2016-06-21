application = application || {};

application.articleView = {};
application.articleView.ready = function($) {

  $('.js-article-switch-languages').click(function(e){
    e.stopPropagation();

    // url, data, callback, type
    $.ajax('/article/swap', {
      type: 'post',
      dataType: 'application/json',
      complete: function(){
        window.location.href = window.location.href;
      }
    });
  });
};

application.articleEdit = {};
application.articleEdit.ready = function($) {
  var $paragraphs = $('#js-paragraphs');
  if ($paragraphs.length == 0)
    return;
  var $template = $('#js-paragraph-template');
  if ($paragraphs.find('.article-paragraph').length == 0)
    appendParagraph();
  else
    initEditor($paragraphs);

  $paragraphs.on('click', '.js-article-paragraph-add a', appendParagraph);
  $paragraphs.on('click', '.js-article-paragraph-remove a', removeParagraph);

  function appendParagraph(event)
  {
    var $newParagraph = $template.clone(true).removeAttr('id');
    if (event)
    {
      event.stopPropagation();
      var $target = $(event.target).parents('.article-paragraph').first();
      if ($target.length == 0)
      {
        $target = $(event.target).parents('.js-article-paragraph-add').first();
      }
      $newParagraph.insertAfter($target);
    }
    else
      $paragraphs.append($newParagraph);

    initEditor($newParagraph)
    $newParagraph.show();
    return false;
  }

  function removeParagraph(event)
  {
    event.stopPropagation();
    var $target = $(event.target).parents('.article-paragraph').first();
    if ($target.length == 0)
    {
      $target = $(event.target).parents('.js-article-paragraph-add').first();
    }
    $newParagraph.insertAfter($target);
  }

  function initEditor(paragraph)
  {
    //if (MediumEditor)
    //  new MediumEditor($(paragraph).find('.editable'));

    $('.expandingArea', paragraph).each(function(){
      makeExpandingArea($(this));
    });
  }

  function makeExpandingArea(container) {
    var $container = $(container),
      $area = $('textarea', $container),
      $span = $('span', $container);

    $span.text($area.val());

    $area.on('keyup', function(){
      $span.text($area.val());
    });

    // Enable extra CSS
    $container.addClass('active');
  }
};

// attach ready event
$(document)
  .ready(application.articleView.ready)
  .ready(application.articleEdit.ready)
;