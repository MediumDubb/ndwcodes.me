jQuery.noConflict();
(function($) {
    $(document).ready(function() {
        AOS.init({
            once: true,
        });

        homePgFull();

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

        function homePgFull() {
            let documentHeight = $(window).height();
            let footerHeight = $('footer.footer').height();
            documentHeight -= Math.round(footerHeight);
            $("#home .center-piece").parent().height(documentHeight);
            // watch for changes
            window.addEventListener('resize', debounce(homePgFull), { passive: true });
        }

        function overrideSearchForm() {
            const searchForm = $('form#SearchForm_SearchForm');

            overrideDefaultAction();

            function overrideDefaultAction() {
                searchForm.on('submit', () => {
                    $(this).preventDefault();
                    const formData = new FormData(this);
                    $.ajax({
                        type: 'POST',
                        url: '/home/SearchForm',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log('Success:', response);
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
