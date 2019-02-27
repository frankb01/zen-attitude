(function ($) {

    $.fn.liScroll = function (settings) {
        settings = $.extend({
            travelocity: 0.07
        }, settings);
        return this.each(function () {
            var $strip = $(this);
            $strip.addClass("newsticker")
            var stripWidth = 1;
            $strip.find("li").each(function (i) {
                stripWidth += $(this, i).outerWidth(true);
            });
            var $mask = $strip.wrap("<div class='mask'></div>");
            var $tickercontainer = $strip.parent().wrap("<div class='tickercontainer'></div>");
            var containerWidth = $strip.parent().parent().width();
            $strip.width(stripWidth);
            var totalTravel = stripWidth + containerWidth;
            var defTiming = totalTravel / settings.travelocity;
            function scrollnews(spazio, tempo) {
                $strip.animate({
                    left: '-=' + spazio
                }, tempo, "linear", function () {
                    $strip.css("left", containerWidth);
                    scrollnews(totalTravel, defTiming);
                });
            }
            scrollnews(totalTravel, defTiming);
            $strip.hover(function () {
                    $(this).stop();
                },
                function () {
                    var offset = $(this).offset();
                    var residualSpace = offset.left + stripWidth;
                    var residualTime = residualSpace / settings.travelocity;
                    scrollnews(residualSpace, residualTime);
                });
        });
    };

    //Modal d'affichage du contenu de la news
    $(".displayNews").click(function (e) {
        e.preventDefault();
        $("#displayNewsModal").modal("show");
    });

})(jQuery)