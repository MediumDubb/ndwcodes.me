jQuery.noConflict();
(function($) {
    $(document).ready(function() {
        AOS.init({
            once: true,
        });
        const debounce = (fn) => {
            // This holds the requestAnimationFrame reference, so we can cancel it if we wish
            let frame;
            // The debounce function returns a new function that can receive a variable number of arguments
            return (...params) => {
                // If the frame variable has been defined, clear it now, and queue for next frame
                if (frame) {
                    cancelAnimationFrame(frame);
                }
                // Queue our function call for the next frame
                frame = requestAnimationFrame(() => {
                    // Call our function and pass any params we received
                    fn(...params);
                });
            }
        };

        initPageFullScreen();
        overrideSearchForm();

        function initPageFullScreen() {
            // set on page load
            homePgFull();
            // watch for changes
            window.addEventListener('resize', debounce(homePgFull), { passive: true });
        }

        function homePgFull() {
            let documentHeight = $(window).height();
            let footerHeight = $('footer.footer').height();
            documentHeight -= Math.round(footerHeight);
            $(".page.full-window .content-area").parent().height(documentHeight);
        }

        function overrideSearchForm() {
            const searchForm = $('form#CustomSearchForm_SearchForm');

            overrideDefaultAction();

            function overrideDefaultAction() {
                searchForm.on('submit', (e) => {
                    e.preventDefault();
                    const search = $('#CustomSearchForm_SearchForm_Search').val();
                    $.ajax({
                        type: 'GET',
                        dataType: 'html',
                        url: '/home/SearchForm?q=' + search.trim(),
                        success: function(response) {
                            console.log('Success:');
                            $('#search-results-content').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', error);
                        }
                    });
                });
            }
        }
    });
}(jQuery));
