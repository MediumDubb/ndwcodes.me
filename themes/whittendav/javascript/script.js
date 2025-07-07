jQuery.noConflict();
(function($) {
    $(document).ready(function() {
        AOS.init({
            once: true,
        });
        homePgFull();
        function homePgFull() {
            let documentHeight = $(window).height();
            let footerHeight = $('footer.footer').height();
            documentHeight -= Math.round(footerHeight);
            $("#home .center-piece").parent().height(documentHeight);
        }
    });
}(jQuery));
