/*! Fabrik */

var FbSlideshowViz=new Class({Implements:[Options],options:{},initialize:function(s,i){this.setOptions(i);parseInt(this.options.slideshow_delay,10),parseInt(this.options.slideshow_duration,10),parseInt(this.options.slideshow_height,10),parseInt(this.options.slideshow_width,10),this.options.liveSite,this.options.slideshow_thumbnails,this.options.slideshow_captions;this.options.slideshow_thumbnails?(jQuery(".slider").slick({slidesToShow:1,slidesToScroll:1,arrows:!1,dots:!1,fade:!0,cssEase:"linear",infinite:!0,speed:500,asNavFor:".slider-nav"}),jQuery(".slider-nav").slick({slidesToShow:3,slidesToScroll:1,arrows:!0,dots:!0,centerMode:!0,focusOnSelect:!0,asNavFor:".slider"})):jQuery(".slider").slick({slidesToShow:1,slidesToScroll:1,arrows:!0,dots:!0,fade:!0,cssEase:"linear",infinite:!0,speed:500}),this.mediaScan()},mediaScan:function(){"undefined"!=typeof Slimbox&&Slimbox.scanPage(),"undefined"!=typeof Lightbox&&Lightbox.init(),"undefined"!=typeof Mediabox&&Mediabox.scanPage()}});