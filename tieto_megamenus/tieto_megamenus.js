var eventBound = false;

(function ($) {
  var $event;

  Drupal.behaviors.tieto_megamenus = {

    attach : function (context) {

      // Remove href attribute, link is only used as a toggle.
      $('li.megamenu-link').children('a').removeAttr('href');

      // Clone all menu links to megamenu block.
      $('#megamenu').not('.megamenu-block').addClass('megamenu-block').append($('li.megamenu-link').clone()).wrapInner('<ul class="menu"></ul>');

      $('#megamenu').find('.megamenu-link').each(function() {
        // Removes child megamenu links as they are already cloned separately.
        // Removes non-megamenu links from first level of menu items.
        $(this).find('.megamenu-link').remove().parents('.megamenu-link').last().siblings().not('.megamenu-link').remove();
      });

      // Add a nav element for theming purposes.
      $('#megamenu').find('li.megamenu-link').children('a').append('<span class="subnav"></span>').wrap('<span class="button"></span>');

      // Additional classes.
      $('#megamenu').addClass('length-' + $('#megamenu').find('li.megamenu-link').length).find('li.megamenu-link').removeClass('first last').first().addClass('first').siblings().andSelf().last().addClass('last');


      $event = (is_touch_device()) ? 'click' : 'mouseenter mouseleave';
      $('#megamenu li.megamenu-link').bind($event, toggleMenu);
    }
  }

  function toggleMenu(event) {
    var target = event.currentTarget;

    // Close others when hover not in use.
    $(target).siblings('li').children('ul').stop(true, true).removeClass('active').hide('fast');
    if ($event == 'click') {
      $(target).children('ul').toggleClass('active').slideToggle('fast');
    }
    else {
      if(event.type == 'mouseleave') {
        $(target).children('ul').stop(true, true).removeClass('active').hide('fast');
      } else {
        $(target).children('ul').addClass('active').delay(80).slideDown('fast');
      }
    }
  }

  function is_touch_device() {
    return !!('ontouchstart' in window);
  }
})(jQuery);
