/**
 * @file
 * Javascript to correct display in pane admin page.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {
  $(document).ready(function () {

    $(".tieto-pane-wrapper").parents(".panels-ipe-portlet-wrapper").each(function() {
      var classes = $(this).find(".tieto-pane-wrapper").attr('class');
      $(this).wrap("<div class='" + classes + "'></div>").find(".panel-pane").unwrap();
    });



  });
})(jQuery, Drupal, this, this.document);
