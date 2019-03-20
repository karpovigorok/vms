jQuery.noConflict();
jQuery(document).foundation();
jQuery(document).ready(function(jQuery){
    "use strict";
    /*Layer slider trigger*/
    jQuery("#layerslider").layerSlider({
        responsive: false,
        responsiveUnder: 1280,
        layersContainer: 1280,
        skin: 'noskin',
        hoverPrevNext: false,
        skinsPath: '../layerslider/skins/'
    });
    //login register click
    jQuery(".loginReg").on("click", function(e){
        e.preventDefault();
        jQuery(this).next().slideToggle();
        jQuery(this).toggleClass("active");
    });

    //search bar
    jQuery(".search").on("click", function(){
        if(jQuery(this).children().hasClass("fa-search")){
            jQuery(this).children().removeClass("fa-search");
            jQuery(this).children().addClass("fa-times");
        }else{
            jQuery(this).children().removeClass("fa-times");
            jQuery(this).children().addClass("fa-search");
        }
        jQuery(this).toggleClass("search-active");
        jQuery("#search-bar").slideToggle();

    });

     //Premium carousel
    jQuery('.owl-carousel').each(function(){
        var owl = jQuery(this);
        jQuery(".prev").on('click', function () {
            jQuery(this).parent().parent().parent().parent().next().trigger('prev.owl.carousel');
        });

        jQuery(".next").on('click', function () {
            jQuery(this).parent().parent().parent().parent().next().trigger('next.owl.carousel');
        });
        var loopLength = owl.data('car-length');
        var divLength = jQuery(this).find("div.item").length;
        if(divLength > loopLength){
            owl.owlCarousel({
                dots : owl.data("dots"),
                items: owl.data("items"),
                slideBy : owl.data("slideby"),
                center : owl.data("center"),
                loop : owl.data("loop"),
                margin : owl.data("margin"),
                nav : owl.data("nav"),
                autoplay : owl.data("autoplay"),
                autoplayTimeout : owl.data("autoplay-timeout"),
                autoWidth:owl.data("auto-width"),
                autoHeight:owl.data("auto-Height"),
                merge: owl.data("merge"),
                responsive:{
                    0:{
                        items:owl.data("responsive-small"),
                        nav:false
                    },
                    600:{
                        items:owl.data("responsive-medium"),
                        nav:false
                    },
                    1000:{
                        items:owl.data("responsive-large"),
                        nav:false
                    },
                    1900:{
                        items:owl.data("responsive-xlarge"),
                        nav:false
                    }
                }
            });

        }else{
            owl.owlCarousel({
                dots : false,
                items: owl.data("items"),
                loop: false,
                margin: owl.data("margin"),
                autoplay:false,
                autoplayHoverPause:true,
                responsiveClass:true,
                autoWidth:owl.data("auto-width"),
                autoHeight:owl.data("auto-Height"),
            });
        }
    });

    //grid system
    jQuery(".grid-system > a").on("click", function(event){
        event.preventDefault();
        var selector = jQuery(this).parent().parent().next().find('div.item');
        var classStr = jQuery(selector).attr('class'),
            lastClass = classStr.substr( classStr.lastIndexOf(' ') + 1);
        jQuery(selector)
        // Remove last class
            .removeClass(lastClass)
            // Put back .item class + the clicked elements class with the added prefix "group-item-".
            .addClass('item group-item-' + jQuery(this).attr('class') );
        if(jQuery(this).hasClass("current")!== true)
        {
            jQuery('.grid-system > a').removeClass("current");
            jQuery(this) .addClass("current");
        }
    });

    //back to top
    var backtotop = '#back-to-top';
    if (jQuery(backtotop).length) {
        var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = jQuery(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    jQuery(backtotop).addClass('show');
                } else {
                    jQuery(backtotop).removeClass('show');
                }
            };
        backToTop();
        jQuery(window).on('scroll', function () {
            backToTop();
        });
        jQuery('#back-to-top').on('click', function (e) {
            e.preventDefault();
            jQuery('html,body').animate({
                scrollTop: 0
            }, 700);
        });
    }
    //newsTicker
    jQuery('#newsBar').inewsticker({
        speed       : 2500,
        effect      : 'fade',
        dir         : 'ltr',
        font_size   : 13,
        color       : '#fff',
        font_family : 'arial',
        delay_after : 1000
    });

    //show more and less
    jQuery('.showmore_one').showMore({
        speedDown: 300,
        speedUp: 300,
        height: '165px',
        showText: 'Show more',
        hideText: 'Show less'
    });

    jQuery(".reply").each(function(){
        if(jQuery(this).parent().next().length > 0){
            jQuery(this).html('Hide replies <i class="fa fa-angle-up"></i>');
        }
    });
    //comments reply hide show
    jQuery(".reply").on('click', function(){
       if(jQuery(this).parent().next().length > 0){
           jQuery(this).parent().nextAll().slideToggle();
           //jQuery(this).html(jQuery(this).text() === 'Hide replies' ? 'Show replies' : 'Hide replies');
           if(jQuery(this).hasClass('hide-reply')){
               jQuery(this).removeClass('hide-reply');
               jQuery(this).html('show replies <i class="fa fa-angle-down"></i>');
           }else {
               jQuery(this).addClass('hide-reply');
               jQuery(this).html('Hide replies <i class="fa fa-angle-up"></i>');
           }
       }
    });

    //register form
    jQuery( "div.social-login" ).mouseenter(function() {
        jQuery("i.arrow-left").addClass("active");
    })
    .mouseleave(function() {
        jQuery("i.arrow-left").removeClass("active");
    });
    jQuery( "div.register-form" ).mouseenter(function() {
            jQuery("i.arrow-right").addClass("active");
        })
        .mouseleave(function() {
            jQuery("i.arrow-right").removeClass("active");
        });

    //vertical thumb slider
    var thumb = jQuery('.thumb-slider .thumbs').find('.ver-thumbnail');
    jQuery(thumb).on('click', function(){
        var id = jQuery(this).attr('id');
        //alert(id);
        jQuery('.image').eq(0).show();
        jQuery('.image').hide();
        jQuery('.'+id).fadeIn();
    });
    var $par = jQuery('.thumb-slider .thumbs .thumbnails').scrollTop(0);
    jQuery('.thumb-slider .thumbs a').click(function( e ) {
        e.preventDefault();                      // Prevent defautl Anchors behavior
        var n = jQuery(this).hasClass("down") ? "+=200" : "-=200"; // Direction
        $par.animate({scrollTop: n});
    });

    //tab panel
    jQuery('[data-tab]').on('click', function (e) {
        jQuery(this).addClass('active').siblings('[data-tab]').removeClass('active');
        jQuery(this).siblings('[data-content=' + jQuery(this).data('tab') + ']').addClass('active').siblings('[data-content]').removeClass('active');
        e.preventDefault();
    });

});