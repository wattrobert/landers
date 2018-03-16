console.log('Main Javascript Works!');
var imageBackground = $('.fixed-image-bg');
var window = $(window);
var logo = $('#logo');
var secondaryText = $('#secondaryText');

$(window).on('load', function() {
    window.scrollTo(0, 0);
});


// $(window).bind('scroll', function(event) {
//     var diff = document.documentElement.offsetHeight - window.innerHeight;
//     var percentage = ((document.documentElement.scrollTop || document.body.scrollTop) / diff);
//     imageBackground.css('filter', 'blur(' + (percentage * 15) + 'px)');
//     secondaryText.css('opacity', (percentage > 0.6 ? 1 : 0));

//     if (1 - percentage > 0.4 && percentage > 0) {
//         logo.css('transform', 'scale(' + ((1 - percentage)) + ',' + ((1 - percentage)) + ') translateX(' + (percentage * 450) + 'px)');
//     }

// })
var lastCalc;
setInterval(function() {
    var diff = document.documentElement.offsetHeight - window.innerHeight;
    var scroll = document.documentElement.scrollTop || document.body.scrollTop;
    var percentage = scroll / diff;
    if (lastCalc === percentage) return;
    lastCalc = percentage;
    imageBackground.css('filter', 'blur(' + (percentage * 15) + 'px)');
    secondaryText.css('opacity', (scroll > 160 ? 1 : 0));

    if (1 - percentage > 0.4 && percentage > 0) {
        logo.css('transform', 'scale(' + ((1 - percentage)) + ',' + ((1 - percentage)) + ') translateY(-' + (percentage * 100) + 'px)');
    }
}, 10);