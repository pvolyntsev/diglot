application = application || {};

application.articleView = {};
application.articleView.ready = function($) {
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

  $paragraphs.on('click', '.js-article-paragraph-add a', appendParagraph)
  $paragraphs.on('click', '.js-article-paragraph-remove a', removeParagraph)

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
  }
};

// attach ready event
$(document)
  .ready(application.articleView.ready)
  .ready(application.articleEdit.ready)
;