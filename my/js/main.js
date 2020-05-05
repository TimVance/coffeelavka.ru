$(document).ready(function () {

    $("#owl-demo1").owlCarousel({

        // autoPlay: 3000, //Set AutoPlay to 3 seconds

        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 1]

    });

});
$("body").on("keypress", "input", function (e) {
    $(this).removeClass('error_input');
});
$(document).ready(function () {

    $("#owl-demo2").owlCarousel({

        // autoPlay: 3000, //Set AutoPlay to 3 seconds

        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 1]

    });

});

$(document).ready(function () {

    $("#owl-demo3").owlCarousel({

        // autoPlay: 3000, //Set AutoPlay to 3 seconds

        items: 4,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 1]

    });

});


$(document).ready(function () {

    $("#owl-demo").owlCarousel({

        // Most important owl features
        items: 1,
        itemsCustom: false,
        itemsDesktop: [1199, 1],
        itemsDesktopSmall: [980, 1],
        itemsTablet: [768, 1],
        itemsTabletSmall: false,
        itemsMobile: [479, 1],
        singleItem: false,
        itemsScaleUp: true,

        //Basic Speeds
        slideSpeed: 200,
        paginationSpeed: 800,
        rewindSpeed: 1000,

        //Autoplay
        autoPlay: false,
        stopOnHover: false,

        // Navigation
        navigation: true,
        navigationText: [" <i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
        rewindNav: true,
        scrollPerPage: false,

        //Pagination
        pagination: false,
        paginationNumbers: false,

        // Responsive
        responsive: true,
        responsiveRefreshRate: 200,
        responsiveBaseWidth: window,

        // CSS Styles
        baseClass: "owl-carousel",
        theme: "owl-theme",

        //Lazy load
        lazyLoad: false,
        lazyFollow: true,
        lazyEffect: "fade",

        //Auto height
        autoHeight: false,

        //JSON
        jsonPath: false,
        jsonSuccess: false,

        //Mouse Events
        dragBeforeAnimFinish: true,
        mouseDrag: true,
        touchDrag: true,

        //Transitions
        transitionStyle: false,

        // Other
        addClassActive: false,

        //Callbacks
        beforeUpdate: false,
        afterUpdate: false,
        beforeInit: false,
        afterInit: false,
        beforeMove: false,
        afterMove: false,
        afterAction: false,
        startDragging: false,
        afterLazyLoad: false

    })

});


$(document).ready(function () {

    var sync1 = $("#sync1");
    var sync2 = $("#sync2");

    sync1.owlCarousel({
        singleItem: true,
        slideSpeed: 1000,
        navigation: false,
        itemsMobile: [479, 1],
        navigationText: [" <i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"],
        pagination: false,
        afterAction: syncPosition,
        responsiveRefreshRate: 200,
    });

    sync2.owlCarousel({
        items: 3,
        itemsDesktop: [1199, 3],
        itemsDesktopSmall: [979, 10],
        itemsTablet: [768, 8],
        itemsMobile: [479, 3],
        pagination: false,
        responsiveRefreshRate: 100,
        afterInit: function (el) {
            el.find(".owl-item").eq(0).addClass("synced");
        }
    });

    function syncPosition(el) {
        var current = this.currentItem;
        $("#sync2")
            .find(".owl-item")
            .removeClass("synced")
            .eq(current)
            .addClass("synced")
        if ($("#sync2").data("owlCarousel") !== undefined) {
            center(current)
        }
    }

    $("#sync2").on("click", ".owl-item", function (e) {
        e.preventDefault();
        var number = $(this).data("owlItem");
        sync1.trigger("owl.goTo", number);
    });

    function center(number) {
        var sync2visible = sync2.data("owlCarousel").owl.visibleItems;
        var num = number;
        var found = false;
        for (var i in sync2visible) {
            if (num === sync2visible[i]) {
                var found = true;
            }
        }

        if (found === false) {
            if (num > sync2visible[sync2visible.length - 1]) {
                sync2.trigger("owl.goTo", num - sync2visible.length + 2)
            } else {
                if (num - 1 === -1) {
                    num = 0;
                }
                sync2.trigger("owl.goTo", num);
            }
        } else if (num === sync2visible[sync2visible.length - 1]) {
            sync2.trigger("owl.goTo", sync2visible[1])
        } else if (num === sync2visible[0]) {
            sync2.trigger("owl.goTo", num - 1)
        }

    }

});

$('.carousel').carousel({
    interval: 8000,
})

// тултипы
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// активный класс при клике
// $(document).on("click","a.cart_click",function(){
//     $(this).parents(".item-meta-container").find(".shop_buy .hidden").click();
//     return false;
//   });
$(document).on("click", ".js_shop_wishlist ", function () {
    $(this).toggleClass("active");
});


// $("button[action=buy]").click(function() {
//     $(this).closest(".thumbnail").find(".shop_img img:first").clone().css({
//         'position': 'absolute',
//         'z-index': '111000',
//         'display': "block",
//         top: $(this).offset().top,
//         left: $(this).offset().left - 100
//     }).appendTo("body").animate({
//         opacity: 0.4,
//         left: $("#show_cart2").offset()['left'] + 5,
//         top: $("#show_cart2").offset()['top'] + 5,
//         width: 20,
//         height: 20
//     }, 1000, function () {
//         $(this).remove();
//     });

//    $(this).parents('form').find('button[name=action]').val('buy');
//  $(this).parents('form').submit();
// });


$(document).on("click", "input[action=buy]", function () {
    $.growl.warning({
        'title': "",
        'message': "Товар добавлен в корзину! ",
    });
});

// $(".shop_compare_button").bind("click",function(){
// if($(this).prop("checked")){
//     $.growl({
//         'title'  : "",
//       'message' : 'Товар добавлен в сравнение',
//       });
//     }else{
//       $.growl({
//         'title'  : "",
//       'message' : "Товар удален из сравнения",
//       });
//     }
// });

$("document").ready(function () {


    if ($(window).width() <= 768) {
        $(".dropdown-submenu > a").click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            if ($(this).hasClass('open2')) {
                $(this).removeClass('open2');
                $(this).find('.dropdown-menu').hide();
            } else {
                $(this).addClass('open2');
                $(this).find('.dropdown-menu').show();
            }
        });
    }


    $(document).on('click', ".do-minus", function () {
        let input = $(this).parent().find("input");
        if (input.val() > 1) input.val(parseInt(input.val()) - 1);
    });

    $(document).on('click', ".do-plus", function () {
        let input = $(this).parent().find("input");
        input.val(parseInt(input.val()) + 1);
    });


    // Выбор веса
    $(".addict-field-coffee select[name=param5] option").each(function () {
        let val = $(this).val();
        let text = $(this).text();
        let weight = $(this).parents(".js_shop").find(".weight-select");

        let span = document.createElement('span');
        span.innerText = text;
        span.setAttribute("data-value", val);
        if ($(this).prop("selected")) span.className = "active";

        weight.append(span);
    });

    $(document).on('click', '.weight-select span', function() {
        $(".weight-select span").removeClass("active");
        $(this).addClass("active");
        let val = parseInt($(this).data("value"));
        let option = $(this).parents(".js_shop").find("select[name='param5'] option[value='" + val + "']");
        option.prop("selected", true).change();
    });

});