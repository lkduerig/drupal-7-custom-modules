/**
 * @file
 * Javascript for responsive navigation.
 *
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {
    $(document).ready(function () {

        // See _variables scss
        //var handheldMax = 480;
        var handheldMax = 760;
        //var narrowMax = 959;
        var narrowMax = 1024;
        var normalMax = 1219;


        $('body').removeClass("non-js");

        function viewport() {
            var e = window, a = 'inner';
            if (!('innerWidth' in window )) {
                a = 'client';
                e = document.documentElement || document.body;
            }
            return { width: e[ a + 'Width' ], height: e[ a + 'Height' ] };
        }

        function addResponsiveClass() {
            // add a class to the body element for width
            var ww = viewport().width;

            if (ww <= handheldMax) {
                $("body").addClass("window-handheld").removeClass("window-narrow window-normal window-wide");
            } else if (ww > handheldMax && ww <= narrowMax) {
                $("body").addClass("window-narrow").removeClass("window-handheld window-normal window-wide");
            } else if (ww > narrowMax && ww <= normalMax) {
                $("body").addClass("window-normal").removeClass("window-handheld window-narrow window-wide");
            } else {
                $("body").addClass("window-wide").removeClass("window-handheld window-narrow window-normal");
            }
        }

        addResponsiveClass();
        $(window).resize(addResponsiveClass);

        // Make some navigation panes mobile enabled
        // prepend visibility tog
        $.fn.addMobileNav = function (text) {
            this.addClass("mobile-nav-enabled");
            this.children("div[class*='content']");
            this.addClass("mobile-nav-wrapper");
            this.wrapInner("<div class= 'mobile-hidden-content'>");
            this.prepend("<div class='show-content'><a class='show-content-link'>" + text + "</a></div>");
        };

        // Manhandle the header around
        function blockMenuWidth() {
            if ($('body').hasClass('window-handheld')) {
                $('.region-header').find('.block-menu-block').width("");
            }
            else {
                var $header = $('.region-header');
                var availWidth = $header.width() - $header.children('.region-header-right').width();
                $('.region-header').find('.block-menu-block').css({'max-width': availWidth});
            }
        }

        // Hide blocks not in use or in the way and show blocks in use
        // Bug: if the customer area menu is showing in narrow width and it is
        // resized to normal, international navigation menu clicked, resize back
        // to narrow, both menus are visible.
        function toggleBlocks(event) {
            var targetBlock = event.target.parentElement;
            $('.region-header .active-header-block').not(targetBlock)
                .has(".show-header-block:visible")
                .removeClass('active-header-block')
                .children('.header-block-content').slideUp(resetVisible);

            $(this).next('.header-block-content').slideToggle(resetVisible)
                .parents('.block').toggleClass('active-header-block');
        }

        //  Reset visibility of hidden block content when breakpoints are crossed
        $(window).load(breakpointReset).resize(breakpointReset);
        function breakpointReset() {
            $(".mobile-hidden-content").each(resetVisible);
        }

        function resetVisible() {
            $(this).filter(":hidden").css({'display': ''});
        }


        $(".region-header .block").not(".block-menu-block").wrapAll('<div class="region-header-right"></div>');
        $(window).load(blockMenuWidth).resize(blockMenuWidth);


        $(".region-header .block").addClass("mobile-nav-enabled");


        $(".region-header .show-header-block").click(toggleBlocks);

        // Search block requires other page-wide styles
        $(".region-header .block-search").not(".active-header-block").find(".show-header-block").click(toggleSearch);
        function toggleSearch() {
            //$("body").toggleClass("search-block-active");
        }

        $('#megamenu').find('li.megamenu-link').bind('click mouseenter mouseleave', toggleBlocks);


        $(".block-menu-block li.expanded > a").before("<span class='toggle-nav'></span>");
        $(".block-menu-block li.leaf > a").before("<span class='leaf'></span>");
        $(".block-menu-block span.toggle-nav").click(function () {
            $(this).closest("li.expanded").toggleClass("mobile-is-expanded").children("ul.menu").slideToggle();
        });
        $(".block-menu-block .megamenu-link > a").click(function () {
            $(this).closest("li.expanded").toggleClass("mobile-is-expanded").children("ul.menu").slideToggle();
        });
//        $(window).resize(function () {
//            $(".block-menu-block li.is-expanded").toggleClass("is-expanded").children("ul.menu").hide();
//        });

        // List all menu panes that require this functionality
        // .pane-menu-tree should probably be changed to .pane-active eventually
        $(".pane-menu-tree").each(function () {
            var text = $(this).find("h2.pane-title").html();

            if (!text) {
                text = "Navigation";
            }

            $(this).addMobileNav(text);
        });

        // List all additional panes that require this functionality
        $("#accordion-panels-column1").wrapInner("<div class='accordion-panels-content'>").addMobileNav("View filters");

        // On click
        $(".mobile-nav-enabled .show-content").click(function () {
            $(this).closest(".block").siblings().children(".active").toggleClass("active");
            $(this).closest(".block").siblings().children(".active-content").slideToggle().toggleClass("active-content");
            $(this).toggleClass("active").next("div.mobile-hidden-content").toggleClass("active-content").slideToggle();
        });

        $(".block-search .show-content").click(function () {
            $("#edit-search-block-form--2").focus();
        })
    })

})(jQuery, Drupal, this, this.document);
//})(jQuery, Drupal);
