var owlcarouselrelate;
owlcarouselrelate = jQuery(".owl-slider-v4");
var Carousel = function () {

    return {
        //Carousel
        initCarousel: function () {
            //Owl Slider v4
            owlcarouselrelate.owlCarousel({
                items:3,
                autoPlay : 5000,
                itemsDesktop : [1000,3],
                itemsTablet : [600,2],
                itemsMobile : [479,1]
            });
        }

    };

}();/**
 * Created by Administrator on 20/04/2015.
 */
