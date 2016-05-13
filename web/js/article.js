application = application || {};

application.articleView = {};
application.articleView.ready = function($) {
};

application.articleEdit = {};
application.articleEdit.ready = function($) {
};

// attach ready event
$(document)
  .ready(application.articleView.ready)
  .ready(application.articleEdit.ready)
;