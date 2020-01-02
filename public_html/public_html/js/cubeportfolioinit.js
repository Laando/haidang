(function($, window, document, undefined) {
    'use strict';

    // init cubeportfolio
    var cube_po = $('#grid-container').cubeportfolio({
        filters: '#filters-container',
        loadMore: '#loadMore-container',
        loadMoreAction: 'click',
        layoutMode: 'grid',
        defaultFilter: '*',
        animationType: 'slideLeft',
        gapHorizontal: 35,
        gapVertical: 15,
        gridAdjustment: 'responsive',
        mediaQueries: [{
 
            width: 800,
            cols: 3
        }, {
            width: 500,
            cols: 2
        }, {
            width: 320,
            cols: 1
        }],
        caption: 'zoom',
        displayType: 'lazyLoading',
        displayTypeSpeed: 100,
    });
    if (typeof clicktype !== 'undefined') {
        var clicktype;
    }

    $('.cbp-filter-item').click(function(e){
        setTimeout(function(){
            clicktype = $('.cbp-filter-item.cbp-filter-item-active').attr('data-filter');
            if(clicktype=='.TOUR-NOEL'||clicktype=='.TOUR-TET-DUONG-LICH'||clicktype=='.TOUR-TET-NGUYEN-DAN'){
                $( gridcube ).trigger( "click" );
            }
        },1000)

    });

})(jQuery, window, document);
