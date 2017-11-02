(function ($, Drupal, window, document, undefined) {
  $(document).ready(function () {

    setupSearchFilters();
  });

  function setupSearchFilters() {
//    console.log('setupSearchFilters');

    // TODO: get translations for langArr texts
    var langArr = ['By country', 'By industry', 'By year'];
    var menuSelector = '.whelan-column1 .item-list';
    $(menuSelector).addClass('searchMenuClosed');
    var len = $(menuSelector).length;
    if (len == 0) {
      console.log('menuSelector length 0 - return');
      return;
    } else {
      console.log('menuSelector length: ' + len);
    }

    // removing padding from the parent container
    var container = $(menuSelector).parent().parent();
    container.css('padding', '1px 10px 0 10px');

    // add the headers (block titles does not seem to work)
    $('.whelan-column1 .item-list').each(function (index) {
      $(this).prepend('<div class="searchMenuHeader">' + langArr[index] + countMenuTotals(this) + '</div>');
      setupMenu(this);
    });


    function setupMenu(target) {
      var h = $(target).height();
      $(target).css({'height' : '30px'});
      $(target).bind('click', { param : [target, h] }, menuHeaderClick);
//      console.log('setupMenu h' + h);
    }


    function menuHeaderClick(event) {
      var target = event.data.param[0];
      var h = event.data.param[1];

      if ($(target).hasClass('searchMenuClosed')) {
        $(target).removeClass('searchMenuClosed').addClass('searchMenuOpen');
        $(this).animate({'height' : h + 'px'}, 270, 'linear');
      } else {
        $(target).removeClass('searchMenuOpen').addClass('searchMenuClosed');
        $(this).animate({'height' : '30px'}, 270, 'linear');
      }
//			console.log('height now: ' + $(this).height());
    }


    function countMenuTotals(target) {
      var total = 0;
      $(target).find('li a').each(function (index) {
        var s = $(this).text().split('(')[1].split(')')[0];
//				console.log('this.text():' + $(this).text() + ' s: ' + s);
        if (s.length > 0) {
          var n = parseInt(s);
          if (isNaN(n))
            n = 0;
          total += n;
        }
      });
//			console.log('countMenuTotals total: ' + total);
      return ' (' + total + ')';
    }
  }

})(jQuery, Drupal, this, this.document);