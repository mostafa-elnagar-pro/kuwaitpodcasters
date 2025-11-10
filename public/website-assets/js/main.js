$(document).ready(function () {
    window.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            $(".search-container").addClass("d-none");
        }
    });
    $("header .navbar .auth .search").click(function () {
        $(".search-container").removeClass("d-none");
    });
    $(".search-container .backdrop").click(function () {
        $(".search-container").addClass("d-none");
    });
    $(".home-slider").slick({
        dots: true,
        arrows: false,
        nextArrow: ".home .arrow.next",
        prevArrow: ".home .arrow.prev",
        infinite: true,
        speed: 700,
        fade: true,
        cssEase: "linear",
        autoplay: true,
        autoplaySpeed: 3000,
        rtl: true,
    });
    $(".category-slider").slick({
        slidesToShow: 8,
        dots: false,
        arrows: true,
        nextArrow: ".categories .arrow.next",
        prevArrow: ".categories .arrow.prev",
        infinite: false,
        rtl: true,
        responsive: [
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 3,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                },
            },
        ],
    });
    $(".podcasters-slider").slick({
        slidesToShow: 5,
        dots: false,
        arrows: true,
        nextArrow: ".podcasters .arrow.next",
        prevArrow: ".podcasters .arrow.prev",
        infinite: false,
        rtl: true,
        responsive: [
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                },
            },
        ],
    });

    $(".reviews-slider").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        rtl: true,
        arrows: true,
        nextArrow: ".reviews-content .arrows .next",
        prevArrow: ".reviews-content .arrows .prev",
        asNavFor: ".nav-reviews-slider",
    });
    $(".nav-reviews-slider").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: ".reviews-slider",
        dots: true,
        centerMode: true,
        rtl: true,
        focusOnSelect: true,
        arrows: true,
        nextArrow: ".reviews-content .arrows .next",
        prevArrow: ".reviews-content .arrows .prev",
    });
    $(document).scroll(function (e) {
        if ($(this).scrollTop() > 100) {
            $("header").addClass("fixed-header");
        } else {
            $("header").removeClass("fixed-header");
        }
    });
    $(".preloader").remove();
    var input = document.querySelector("#phone");
    window.intlTelInput(input, {
        separateDialCode: true,
        excludeCountries: ["in", "il"],
        preferredCountries: ["ru", "jp", "pk", "no"],
    });
});
