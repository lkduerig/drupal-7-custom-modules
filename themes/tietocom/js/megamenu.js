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


    /*  Megamenu setup  */

    $(document).ready(setupMegamenu);
    $('body').not('lt-ie9').each(function() {
      // Lower versions of IE fire resize event when any element is changed
      // A timer could be used in conjunction with testing the actual window width,
      // but we'd prefer if people would just update their browsers.
      $(window).resize(setupMegamenu);
    });


    $event = (is_touch_device()) ? 'click' : 'mouseenter mouseleave';

    $('.front').find($('#megamenu li.megamenu-link')).bind($event, adjustHeight);

    function adjustHeight(event) {
      var allowedSpace = $('.header-inner').height() - $('.region-header').height() - 30;
      var menuHeight = $(event.target).children('ul.menu').outerHeight();
      var $type = event.type;
      if ($type == 'mouseleave') {
        $('#block-tieto-megamenus-megamenu').stop().animate({'top': 0}, 'fast')
      }
      if (menuHeight > allowedSpace && $type != 'mouseleave') {
        $('#block-tieto-megamenus-megamenu').stop().delay(80).animate({'top': (menuHeight - allowedSpace + 16) + "px"}, 'fast')
      } else {
        $('#block-tieto-megamenus-megamenu').stop().animate({'top': 0}, 'fast')
      }
    }

    function is_touch_device() {
      return !!('ontouchstart' in window);
    }


    function setupMegamenu() {
      if($('body').hasClass('window-handheld')) {
        return;
      }

      $("#megamenu li.megamenu-link").children("ul").removeClass("active").hide("fast");

      // 1. calculate width percentages based on menuLen = menu item amount
      var menuLen = $("#megamenu .megamenu-link").length;
      var menuItemWidth = 100 / menuLen;
      $("#megamenu").find(".megamenu-link").each(function () {
        $(this).width(menuItemWidth + '%');
      });

      // 2. layout into columns: 1-maxPerColumn, changes ordering from row based to column based

      //var multiplier = 0;
      var multiplier = 100;

      // use 100 as a multiple unless the screen width is very narrow, then use 200
//        if (multiplier == 0) {
//          multiplier = 100;
//        }

      $('#megamenu').find('.megamenu-link').each(function () {
        layoutMegaMenu($(this).find("> ul.menu > li"));

        // 3. set submenu column width based on column count
        var subMenuItemWidth = 100 / $(this).find('.megamenu-column').size();
        $(this).find('.megamenu-column').each(function () {
          $(this).width(subMenuItemWidth + "%");
        });

        // 4. calculate submenu width and left margin to be more centered over the parent menu item
        var maxWidth = Math.round(($(this).parent("ul.menu").width() / $(this).width())) * 100;
        if ($(this).hasClass("megamenu-link-expanded")) {
          if(menuLen > $(this).find(".megamenu-column").length) {
            maxWidth = menuLen * 100;
          }
          if($(this).find(".megamenu-column").length <= menuLen) {
            maxWidth = menuLen * 100;
          }
        }

        var width = $(this).find(".megamenu-column").length * multiplier;
        width = (width > maxWidth) || $(this).hasClass('megamenu-link-expanded') ? maxWidth : width;

        var offsetLeft = Math.ceil((menuItemWidth - width) / 200) * multiplier;

        // 5. calculate left margin adjustment if going over right or left edge
        var overflowRight = (100 * $(this).index()) + width + offsetLeft;
        var adjustRight = overflowRight - menuLen * multiplier;
        offsetLeft = adjustRight > 0 ? offsetLeft - adjustRight : offsetLeft;

        var adjustLeft = (100 * $(this).index() + offsetLeft);
        offsetLeft = adjustLeft < 0 ? -100 * $(this).index() : offsetLeft;

        // 6. apply calculated CSS
        $(this).find("> ul.menu").css({
          'width': width + "%",
          'margin-left': offsetLeft + "%"
        });
      });

      // adjust width of margins around menu
      var offset = $('.block-tieto-megamenus').offset();
      var margin = offset.left - 5;
      $('.megamenu-left').width(margin);
      $('.megamenu-right').width(margin);
    }


    // layout out megamenu items into columns
    function layoutMegaMenu(menuItems) {

      var len = menuItems.length;
      var column = addColumn($(menuItems[0]).parent());

      for (var i = 0; i < len; i++) {
        var item = menuItems[i];
        $(item).css({'width': '100%'});
        if (hasRoom(column, item)) {
          $(item).appendTo(column);
        } else {
          column = addColumn($(item).parent());
          $(item).appendTo(column);
        }
      }
      $(menuItems).parent().wrapAll("<div class='megamenu-columns'></div>");
    }

    // check if current column has enough room for menu item
    function hasRoom(column, item) {
      var maxPerColumn = 3;
      var megaMenuH = $('body').hasClass('front') ? ($('#header').height() - $('.region-header ').height()) : $('body').height();
      //var megaMenuH = $('body').hasClass('front') ? (parseInt($('.region-header ').css('margin-bottom'))) : $('body').height();
      //megaMenuH = 2 * megaMenuH;

      var childHeight = 80;
      var len = $(column).children().size();
      $(column).children().each(function () {
        childHeight += $(this).actual('outerHeight', { includeMargin: true });
      });
      var has = (childHeight + $(item).actual('outerHeight', { includeMargin: true }) < megaMenuH && len < maxPerColumn) ? true : false;
      return has;
    }

    function addColumn(container) {
      var column = $('<div class="megamenu-column"></div>').appendTo(container);
      return column;
    }

    //If there is no MEGAMENU on the site, this code removes the Spacing
    if ($('#megamenu .expanded').length == 0) {
      $('#block-tieto-megamenus-megamenu').css('display','none');
    }

  })
})(jQuery, Drupal, this, this.document);
