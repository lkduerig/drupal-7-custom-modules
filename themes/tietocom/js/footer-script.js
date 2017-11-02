/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {
  $(document).ready(function () {

    /* Lightbox overlay code */
    // Items to be displayed in an overlay
    $(".region-header .block-search .search-block-link").addClass("tieto-lightbox-trigger").next("form").addClass("tieto-lightbox-content");

    //create HTML markup for lightbox window
    var lightbox =
      '<div id="tieto-lightbox-overlay"></div>' +
      '<div id="tieto-lightbox">' +
        '<div id="tieto-lightbox-content-wrapper">' +
        '<div class="close"><span>Click to close</span></div>' +
        '<div id="tieto-lightbox-content">' +
        '</div>' +
        '</div>' +
        '</div>';
    //insert lightbox HTML into page
    $('.tieto-lightbox-trigger').parents('body').append(lightbox);

    $('.tieto-lightbox-trigger').click(function(e) {
      //prevent default action (hyperlink)
      e.preventDefault();

      //Get the content to be displayed in the lightbox
      var content = $(this).next(".tieto-lightbox-content").clone();

      // add class to body to allow for other styling
      $('body').addClass('tieto-lightbox-active');

      // Only replace contents if it is a different element, so e.g. search criteria will not be erased unnecessarily
      $('#tieto-lightbox-content').filter(function() {
        return (!$(this).children().attr("id") || $(this).children().attr('id') != content.attr('id'));
      }).html(content);

      $('#tieto-lightbox-overlay').fadeIn('fast', function() {
        $('#tieto-lightbox').slideDown(400);
	  $('#tieto-lightbox-content #search-block-form input.form-text').focus();
      });


    });
    //Click close to get rid of lightbox window
    $('#tieto-lightbox').find('.close').live('click', function() { //must use live, as the lightbox element is inserted into the DOM
      $('#tieto-lightbox').slideUp(400, function() {
        $('#tieto-lightbox-overlay').fadeOut('fast');
      });
      $('body').removeClass('tieto-lightbox-active');
    });

    $(window).resize(function() {
      $('body.window-handheld').find('#tieto-lightbox').find('.close').click();
    });
    /* End lightbox code */



    // This little thing don't always work properly if not executed after everything is loaded
    $(window).load(carouselMainImage).resize(carouselMainImage);
    function carouselMainImage() {
      $("img.carousel-main").css({"min-height": $(".header-image").outerHeight()}).height("auto").width("auto");
    }

  })
})(jQuery, Drupal, this, this.document);
