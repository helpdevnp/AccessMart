(function ($) {
    "user strict";
    $(window).on("load", () => {
        $("#landing-loader").fadeOut(1000);
    });
    $(document).ready(function () {
        //Header Bar
        $(".nav-toggle").on("click", () => {
            $(".nav-toggle").toggleClass("active");
            $(".menu").toggleClass("active");
        });

        $(".counter-item").each(function () {
            $(this).isInViewport(function (e) {
                if ("entered" === e)
                    for (
                        var i = 0;
                        i < document.querySelectorAll(".odometer").length;
                        i++
                    ) {
                        var n = document.querySelectorAll(".odometer")[i];
                        n.innerHTML = n.getAttribute("data-odometer-final");
                    }
            });
        });
        var header = $("header");
        $(window).on("scroll", function () {
            if ($(this).scrollTop() > 300) {
                header.addClass("active");
            } else {
                header.removeClass("active");
            }
        });

        if ($(".wow").length) {
            var wow = new WOW({
                boxClass: "wow",
                animateClass: "animated",
                offset: 0,
                mobile: true,
                live: true,
            });
            wow.init();
        }

        $(".learn-feature-wrapper").on("scroll", function () {
            $(".learn-feature-item-group").addClass("stop-animation");
        });
        $(".learn-feature-wrapper").on("mouseover mouseleave", function () {
            $(".learn-feature-item-group").removeClass("stop-animation");
        });

        // $(".section-header .title").each(function () {
        //     var $this = $(this);
        //     function getWords(text) {
        //         $this.html("");
        //         let x = text.replace(/[^A-Za-z0-9]+/g, " ");
        //         let newArr = x.trim().split(" ");

        //         for (var i = 0; i <= newArr.length; i++) {
        //             if (newArr[i] != undefined) {
        //                 if (i + 1 < newArr.length) {
        //                     $this.append(`<span>${newArr[i]} ${" "}</span>`);
        //                 } else {
        //                     $this.append(
        //                         `<span class="text--base">${
        //                             newArr[i]
        //                         } ${" "}</span>`
        //                     );
        //                 }
        //             }
        //         }
        //     }

        //     getWords($(this).text());
        // });
    });
})(jQuery);
