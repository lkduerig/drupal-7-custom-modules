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

    //Custom parallax scroll
    $.fn.parallax = function(options) {

      var windowHeight = $(window).height();

      // Establish default settings
      var settings = $.extend({
        speed        : 0.15
      }, options);

      // Iterate over each object in collection
      return this.each( function() {

        // Save a reference to the element
        var $this = $(this);

        // Set up Scroll Handler
        $(document).scroll(function(){
          var scrollTop = $(window).scrollTop();
          var offset = $this.offset().top;
          var height = $this.outerHeight();

          // Check if above or below viewport
          if (offset + height <= scrollTop || offset >= scrollTop + windowHeight) {
            return;
          }
          var yBgPosition = Math.round((offset - scrollTop) * settings.speed);

          // Apply the Y Background Position to Set the Parallax Effect
          $this.css('background-position', 'center ' + yBgPosition + 'px');

        });
      });
    }


    // remove body class 'non-js'
    $('body').removeClass("non-js");

    // FitVid responsive videos, NOTE: youtube videos height correction before fitvid */
    // $(".flexslider li div.field-content").fitVids();
    // alternate way for fitvid, min-height for setting videos not yet visible
//    $('.flexslider li div.field-content iframe').css({'width' : '100%', 'min-height' : '303px'});
//    function setAspectRatio() {
//      $('.flexslider li div.field-content iframe').each(function () {
//        $(this).css({'height' : $(this).width() * 9 / 16 + 35, 'min-height' : 'auto'});
//      });
//    }
//

    // Remove sidebars from panel if content is displayed in an iFrame,
    // there doesn't seem to be any way to hook into panel layout to do this elsewhere.
    $(".viewmode-iframe").find($("[class*=sidebar]")).remove();


    // loop through elements to find max height
    $.fn.getMaxHeight = function (element) {
      var maxHeight = 0;
      if (element) {
        this.children(element).each(function () {
          if ($(this).actual("height") > maxHeight) maxHeight = $(this).actual("height");
          //if ($(this).actual("height") > maxHeight) maxHeight = $(this).height();
        });
      }
      else {
        this.parent().children().each(function () {
          //if ($(this).height() > maxHeight) maxHeight = $(this).height();
          if ($(this).actual("height") > maxHeight) maxHeight = $(this).actual("height");
        });
      }
      return maxHeight;
    };


    // Filter visibility
    $(".tieto-collapsible-filter .facetapi-active").parents(".panel-pane").addClass("active").children(".pane-content").show();
    $(".tieto-collapsible-filter").show().children(".pane-title").click(function () {
      $(this).parents(".panel-pane").toggleClass("active").children(".pane-content").slideToggle();
    });

    // Wrap highlight items for theming
    $(".highlight-list .highlight").wrapInner("<div class='highlight-inner'></div>");

    // Add class to last pane in region
    $(".industryhub-column-content .panel-panel").each(function () {
      $(this).find(".panel-pane").not(".pane-panels-ipe").last().addClass("column-pane-last-visible");
    });

    // Allow for different styling depending on the content of the carousel slide
    $(".slides").each(function () {
      $(this).find(".views-field-body").each(function() {
        //if(!($(this).find(".field-content").text().trim())) {
        // trim breaks IE8
        if(!($(this).find(".field-content").text())) {
          $(this).parent("li").addClass("no-text");
          if($(this).find(".field-content iframe")) {
            $(this).parent("li").addClass("video-only");
          }
        }
      });
    });


    // Setting  carousel heights dynamically
    function setAspectRatio() {
      $('.flexslider li div.field-content iframe').each(function () {
        //$(this).css({'height' : $(this).actual("width") * 9 / 16 + 35, 'min-height' : 'auto'});
        $(this).attr({'height' : $(this).actual("width") * 9 / 16 + 35});
      });

    }

    // equalize carousel slide height
    function abuseCarousels () {
      $('.flexslider .slides').each(function() {
        var setHeight = 0;

        $(this).find("> li").each(function() {
          $(this).height('');
          if ($(this).height() > setHeight) { setHeight = $(this).height(); }
        }).height(setHeight);
      });
    }

    // manhandle the carousel content into place
    function manhandleHeader() {
      var carouselHeight = $(".view-main-carousel .flexslider").outerHeight();
      var headerInnerHeight = $(".header-inner").outerHeight();
      $(".region-header").css("margin-bottom", carouselHeight);
      $(".view-main-carousel .flex-direction-nav").css("margin-top", carouselHeight * -0.5);

    }


    // Set heights of everything else dynamically
    function setElementHeights() {

      // Setting news list highlight height
      $(".highlight-inner").height(elementHeight($(".highlight-inner").height("").getMaxHeight()));


      // Setting front page and industry hub pane heights
      $(".industryhub-footer .panel-pane").height(elementHeight($(".industryhub-footer .panel-pane").height("").getMaxHeight()));

      $(".frontpage-container .frontpage-content").each(function () {
        $(this).find(".panel-pane").height("").height(elementHeight($(this).find(".panel-pane").getMaxHeight()));
      });

      // Make sure that header image is taken care of.
      //$("img.carousel-main").css({"min-height": $(".header-image").outerHeight()}).height("auto").width("auto");

    }

    function elementHeight(height) {
      // none of this should apply to mobile layouts
      $("body.window-handheld").each(function () {
        height = "";
      });
      return height;
    }

    // All functions that must be executed both when the page loads and when window is resized
    var functions = [setAspectRatio, abuseCarousels, manhandleHeader, setElementHeights];
    var additionalFunctions = [abuseCarousels];

    jQuery.each(functions, function() {
      $(document).ready(this);
      $(window).resize(this);
    });

    // If page has a carousel, Additional functions are loaded after EVERYTHING is loaded
    if ($(".flex-nav-container")[0]){
      jQuery.each(additionalFunctions, function() {
        $(window).load(this);
      });
    };

    //Quickfix for carousel weights because they are messed up in some situations. If there is only 1 in the carousel,
    //we will use a css of height:auto !important;.

    if ($(".flexslider .views-row-2").html()){
    }
    else {
      $(".flexslider-views-slideshow-main-frame-row").addClass("flexslider-single");
    }

    //Draw wrapper js on click toggles the following selectors to show if checkbox is YES, the first one will be triggered,
    //Else the second one.
    var topHeader = $(".views-field-field-open-all-the-time .field-content").text().length;
    if(topHeader == 3) {
      $(document).ready(function () {
        $(".views-field-field-crisis-message").toggle(0);
        $(".view-crisis-communication .views-field-body, .views-field-field-crisis-message-1, .views-field.views-field-colorbox").slideToggle("fast", function() {
        });
        $("#draw-wrapper").click(function () {
          $(".views-field-field-crisis-message").toggle(0);
          $(".view-crisis-communication .views-field-body, .views-field-field-crisis-message-1, .views-field.views-field-colorbox").slideToggle("fast", function() {
          });
        });
      });
    }
    else {
      $("#draw-wrapper").click(function () {
        $(".views-field-field-crisis-message").toggle(0);
        $(".view-crisis-communication .views-field-body, .views-field-field-crisis-message-1, .views-field.views-field-colorbox").slideToggle("fast", function() {
        });
      });
    }

    // Do this only on key topics pages @todo seperate this from normal js
    if ($(".node-type-key-topics")[0]){
      $(".view-key-topics-navigation .views-row-1 .first a").attr("href","#page");

      // On Tieto Key Topics, because of contextual links regions, we need to prevent links from loading
      // and load instead the link in the pushState and with jquery toggle the hidden fields.

      $(document).off('click', ".key-topics-visible >a").on('click', ".key-topics-visible >a", function(e) {
        e.preventDefault();
        /*var link = $(this).attr('href');
         history.pushState(null, null, link);*/
      });

      // Added a function to clean up everything extra.
      function cleanup () {
        $(".key-topics-hidden").css("display","none");
        $(".key-topics-visible").css("display","block");
        $(".selected").removeClass("selected");
      }

      // Create function to initiate isotope.
      function initiateIso() {
        var $container = $('.view-key-topics-phases .view-content');
        $container.isotope({
          // options
          itemSelector: '.cp-tile',
          layoutMode: 'masonry',
          transitionDuration: 0,
          masonry: {
            columnWidth: 10
          }
        });
//        if (scrollItem) {
//          $container.isotope( 'once', 'layoutComplete', function() {
//            panelScroll(scrollItem);
//          });
//        }
      }

      //On click to the views rows, open and add classes
      $(document).off('click', "#main .views-row:not(.selected)").on('click', "#main .views-row:not(.selected)", function() {
        if ( $( this ).hasClass( "selected" ) ) {
          cleanup();
          initiateIso();
        } else {
          cleanup();
          $(this).find( ".key-topics-hidden" ).toggle();
          $(this).find( ".key-topics-visible" ).toggle();
          $(this).addClass("selected");
          initiateIso();
          panelScroll($(this));

        }
      });
      $(document).off('click', ".tile-close").on('click', ".tile-close", function(e) {
        e.preventDefault();
        cleanup();
				initiateIso();
				
				// return scroll to phase title
				panelScroll($(this).parents('.pane-views-panes'));
      });

      // Create a timeout to check that Ajax has been applied and after that add the new stuff to isotope.
      function ajaxCheck (){
        setTimeout(function(){
          if ($(".progress-disabled")[0]){
            ajaxCheck ();
          } else {
            var $container = $('.view-key-topics-phases .view-content');
            // Reload new items to the isotope.js.
            $container.isotope( 'reloadItems' );
            initiateIso();
            // Need to re-apply the click function after ajax.
            $(".pager-next a").click(function(){
              ajaxCheck();
            });
          }
        }, 500);
      };

      // Run ajax check function after click.

      $(".pager-next a").click(function(){
        ajaxCheck();
      });

			function panelScroll(target_element) {
				if (target_element.length) {
					var target_pos = target_element.offset().top;
					var fhdr = $(".view-key-topics-navigation");
					var fhdr_height = fhdr.length ? fhdr.outerHeight() : 0;
					target_pos -= fhdr_height;
					
					$('html,body').animate({
						scrollTop: target_pos
					}, 1000);
				}
      }
			
      //Apply smooth scrolling behaviors
      /*$('a[href*=#]:not([href=#])').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
					panelScroll(target);
        }
      });*/
				
			// new logic for sticky nav target scrolling
			$('.sticky-navigation ul li a').click(function(e) {
				e.preventDefault();
				panelScroll( $(this.hash) );
        $(".sticky-navigation").toggleClass("fixed-class");
      });

      // Apply equal height to given selectors
      function equalHeight(group) {
        var tallest = 0;
        var thisHeight = '';
        group.each(function() {
          $(this).height('inherit');
          thisHeight = $(this).height();
          if(thisHeight > tallest) {
            tallest = thisHeight;
          }
        });
        group.height(tallest);
      }

      // Apply equal top and bottom padding
      // specifically used for sticky nav items
      function equalPadding( parent_node, child_node ) {
        equalHeight(parent_node);
        var parent_node_height = parent_node.first().height();
        parent_node.each(function () {
          var target_node = $(this).children(child_node),
            outer_height = parseInt(target_node.height()),
            diff = (parent_node_height - outer_height) / 2;
          target_node.css({
            'padding-top': diff,
            'padding-bottom': diff
          });
        });
      }
			
			function resetStickyNav() {
				// first reset the height and padding of sticky nav items
				var sticky_nav_items = $(".sticky-navigation ul li");
				sticky_nav_items.height(0);
				$('a', sticky_nav_items).css({'padding-top': '0.75em', 'padding-bottom': '0.75em'});
			}

      //after everything has loaded, load the concept page stuff
      $(window).load(function (){
        var elementHeights = $('.view-key-topics-portfolio .view-content').map(function() {
          return $(this).height();
        }).get();

        // Math.max takes a variable number of arguments
        // `apply` is equivalent to passing each height as an argument
        var maxHeight = Math.max.apply(null, elementHeights);

        // Set each height to the max height
        $('.view-key-topics-portfolio .view-content').height(maxHeight);

        equalPadding( $(".sticky-navigation ul li"), 'a' );
      }).bind('resize orientationchagne',  function() {
          resetStickyNav();
          equalPadding( $(".sticky-navigation ul li"), 'a' );
        });

      function setBackground () {
        $('.field-name-field-basic-image-image').each(function() {
          var bg =$(this).find(".panopoly-image-full").attr("src");
          $(this).css("background-image",'url(' + bg + ')');
        });
      }
      setBackground ();

      $(".mobile-nav-key-topics").click(function(){
        $(".sticky-navigation").toggleClass("fixed-class");
				resetStickyNav();
				equalPadding( $(".sticky-navigation.fixed-class ul li"), 'a' );
      });
      $('.header-image ,.field-name-field-basic-image-image').parallax({
        speed : 0.3
      });

      $('.form-text, .form-textarea').each(function(){
        $(this).attr('placeholder', $('label[for=' + this.id + ']').text());
      });

      // contact form in two columns for IE9-
      if( $.browser.msie && $.browser.version <= 9 ) {
        $('.webform-client-form').addClass('ie-lte-9');
      }
    }

  })
})(jQuery, Drupal, this, this.document);
