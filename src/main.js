var imageBackground = $('.fixed-image');
var window = $(window);

$(window).on('load', function() {
    window.scrollTo(0, 0);
});

var lastCalc;
setInterval(function() {
    var diff = document.documentElement.offsetHeight - window.innerHeight;
    var scroll = document.documentElement.scrollTop || document.body.scrollTop;
    var blurAmount = Math.round(scroll / diff * 12);
    if (lastCalc === blurAmount) return;
    lastCalc = blurAmount;
    imageBackground.css('filter', 'blur(' + blurAmount + 'px)');
}, 15);
