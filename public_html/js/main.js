// JavaScript source code
$(document).ready(function () {
    $("#create").on("click", function () {
        $(".sign-in").addClass("d-none");
        $(".create-account").addClass("d-block");
    });
    $("#close").click(function () {
        $(".create-account").removeClass("d-block");
        $(".sign-in").removeClass("d-none");
    });
    $("#btn-choose").click(function () {
        if (screen.width > 768) {
            $("#table-choose").toggle(500);
        }
        else {
            $(".popup-mobile").addClass("active")
        }
    });
    $(".in-link a").mouseenter(function () {
        if ($(".group-list-out").show()) {
            $(".group-list-out").hide();
        }
        $(".group-list-in").removeClass("d-none");
        $(".group-list-in").addClass("d-block")
    });
    $(".group-list-in").mouseleave(function () {
        $(".group-list-in").addClass("d-none");
        $(".group-list-in").removeClass("d-block")
    });
    $(".out-link").mouseenter(function () {
        if ($(".group-list-in").hasClass("d-block")) {
            $(".group-list-in").addClass("d-none");
            $(".group-list-in").removeClass("d-block")
        }
        $(".group-list-out").show();
    });
    $(".group-list-out").mouseleave(function () {
        $(".group-list-out").hide();
    });
    $("#btn-go").click(function () {
        $(".popup-mobile-go").addClass("active")
    });
    $("#btn-cato").click(function () {
        $(".popup-mobile-cato").addClass("active")
    });
    $(".show-filter").click(function () {
        $(".popup-filter").addClass("active")
    });
    $("#btn-child").click(function () {
        if (screen.width < 768) {
            $("#note-child").toggle(500);
        }
    });
    $("#btn-info").click(function () {
        if (screen.width < 768) {
            $("#note-info").toggle(500);
        }
    });
    $(".close-mobile").click(function () {
        $(".popup-mobile").removeClass("active")
        $(".popup-mobile-go").removeClass("active")
        $(".popup-mobile-cato").removeClass("active")
    });
});
$('.owl-carousel.bannertop ').owlCarousel({
    autoplay: true,
    loop: true,
    margin: 10,
    nav: false,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 1
        },
        1200: {
            items: 1
        }
    }
});
function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
    let isOutbound = '0';
    if(cityName==='Out'){
        isOutbound = '1'
    }
    $('#MenuSearch').find('[name="destination"] option').each(function(index,item){
        $(item).attr('data-type') === isOutbound
    })
}
function openGroup(evt, groupName) {
    var i, tabcontent2, tablinks2;
    tabcontent2 = document.getElementsByClassName("tabcontent2");
    for (i = 0; i < tabcontent2.length; i++) {
        tabcontent2[i].style.display = "none";
    }
    tablinks2 = document.getElementsByClassName("tablinks2");
    for (i = 0; i < tablinks2.length; i++) {
        tablinks2[i].className = tablinks2[i].className.replace(" active", "");
    }
    document.getElementById(groupName).style.display = "block";
    evt.currentTarget.className += " active";
}
$(document).ready(function () {
    var bigimage = $("#big");
    var thumbs = $("#thumbs");
    //var totalslides = 10;
    var syncedSecondary = true;

    bigimage
        .owlCarousel({
            items: 1,
            slideSpeed: 2000,
            nav: true,
            autoplay: true,
            dots: false,
            loop: true,
            responsiveRefreshRate: 200,
            navText: [
                '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ]
        })
        .on("changed.owl.carousel", syncPosition);

    thumbs
        .on("initialized.owl.carousel", function () {
            thumbs
                .find(".owl-item")
                .eq(0)
                .addClass("current");
        })
        .owlCarousel({
            items: 4,
            dots: true,
            nav: true,
            navText: [
                '<i class="fa fa-arrow-left" aria-hidden="true"></i>',
                '<i class="fa fa-arrow-right" aria-hidden="true"></i>'
            ],
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: 4,
            responsiveRefreshRate: 100
        })
        .on("changed.owl.carousel", syncPosition2);

    function syncPosition(el) {
        //if loop is set to false, then you have to uncomment the next line
        //var current = el.item.index;

        //to disable loop, comment this block
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - el.item.count / 2 - 0.5);

        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }
        //to this
        thumbs
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = thumbs.find(".owl-item.active").length - 1;
        var start = thumbs
            .find(".owl-item.active")
            .first()
            .index();
        var end = thumbs
            .find(".owl-item.active")
            .last()
            .index();

        if (current > end) {
            thumbs.data("owl.carousel").to(current, 100, true);
        }
        if (current < start) {
            thumbs.data("owl.carousel").to(current - onscreen, 100, true);
        }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            bigimage.data("owl.carousel").to(number, 100, true);
        }
    }

    thumbs.on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).index();
        bigimage.data("owl.carousel").to(number, 300, true);
    });
    if($('.find_blog').length> 0){
        $('.find_blog').on('click touchstart',function(e){
            var parent  = $(this).closest('[class*=popup-mobile-]');
            var items  = parent.find('.tab-pane ').find('button[name="category"],button[name="destination"]');
            var query  = parent.find('.find_blog_value').val();
            items.each(function(index,item){
                var value= $(item).attr('value');
                if(value.toLowerCase().includes(query.toLowerCase())){
                    $(item).show();
                } else {
                    $(item).hide();
                }
            });
        });
        $('.find_blog_value').on('keyup input ',function(e){
            e.preventDefault();
            var parent  = $(this).closest('[class*=popup-mobile-]');
            parent.find('.find_blog').trigger('click');
        });
    }
});
