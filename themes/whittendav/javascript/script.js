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
            let search = '';

            modalEvents();
            overrideDefaultAction();
            updatePopState();

            function overrideDefaultAction() {
                searchForm.on('submit', (e) => {
                    e.preventDefault();
                    search = $('#CustomSearchForm_SearchForm_Search').val();
                    if (search.length > 0) {
                        setURLQueryAnchor(search);
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
                    }
                });
            }

            function updatePopState() {
                window.onpopstate = function(event) {
                    // Check if event.state exists to ensure it's a state pushed by pushState()
                    if (event.state) {
                        console.log(event.state);
                        const query = event.state.search.includes('?q=') ? event.state.search : "?q=" ;
                        $('#CustomSearchForm_SearchForm_Search').val(event.state.term);
                        $.ajax({
                            type: 'GET',
                            dataType: 'html',
                            url: '/home/SearchForm' + query,
                            success: function(response) {
                                console.log('Success:');
                                $('#search-results-content').html(response);
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', error);
                            }
                        });
                    } else {
                        // Handle cases where the state is null (e.g., initial page load or navigating to a non-pushState entry)
                        console.log("Back button pressed, but no associated state.");
                    }
                };
            }

            function modalEvents() {
                const searchModalEl = document.getElementById('searchModal');
                searchModalEl.addEventListener('show.bs.modal', e => {
                    setURLQueryAnchor();
                });
                searchModalEl.addEventListener('hide.bs.modal', e => {
                    setURLQueryAnchor('', true);
                });
            }

            function setURLQueryAnchor(searchTerm = '', closed = false)
            {
                const baseUrl = location.protocol + '//' + location.host + location.pathname;
                const query = searchTerm !== '' ? '?q=' + searchTerm : '';
                const newUrl = baseUrl + query;
                const fullSearchURL = closed ? baseUrl : newUrl + '#site-search';

                console.log('query:', query);
                console.log('newURL:', newUrl);
                console.log('full:', fullSearchURL);

                const stateObj = {
                    title: document.title, // A title for the new history entry
                    search: query,
                    term: searchTerm, // search query to call in ajax
                    url: fullSearchURL // The URL to display in the address bar
                };

                window.history.pushState(stateObj, stateObj.title, fullSearchURL);
            }
        }
    });
}(jQuery));
