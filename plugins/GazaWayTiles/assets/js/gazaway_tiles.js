jQuery('a[href*=#]:not([href=#])').click(function() {
    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {
        var target = jQuery(this.hash);
        target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
        if (target.length) {
            var top_offset = '100';

            jQuery('html,body').animate({
                scrollTop: target.offset().top - top_offset
            }, 1000);
            return false;
        }
    }
});