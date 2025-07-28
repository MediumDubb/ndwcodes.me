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
        siteSearchForm();

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

        function siteSearchForm() {
            const searchForm = $('form#CustomSearchForm_SearchForm');
            const searchModalEl = document.getElementById('searchModal');
            const searchModal = new bootstrap.Modal(searchModalEl);
            let search = '';

            openSearchModal();
            modalEvents();
            updatePopState();
            overrideDefaultAction();

            function openSearchModal() {
                if (window.location.hash.includes('#search-open')) {
                    const searchModalEl = document.getElementById('searchModal');
                    const searchModal = new bootstrap.Modal(searchModalEl);

                    if (window.location.search.includes('?q=')) {
                        const urlParams = new URLSearchParams(window.location.search);
                        const term = urlParams.get('q');
                        $('#CustomSearchForm_SearchForm_Search').val(term)
                        searchAJAX(term);
                    }

                    searchModal.show();
                }
            }

            function overrideDefaultAction() {
                searchForm.on('submit', (e) => {
                    e.preventDefault();
                    search = $('#CustomSearchForm_SearchForm_Search').val();
                    if (search.length > 0) {
                        setURLQueryAnchor(search);
                        searchAJAX(search);
                    }
                });
            }

            function pagination(links) {
                console.log("links",links);
                $(links).on('click', function(e) {
                    e.preventDefault();
                    const href = $(this).attr('data-href');
                    const urlParams = new URLSearchParams(href.substring(href.indexOf("?"), (href.length)));
                    const q = urlParams.get('q');
                    const start = urlParams.get('start');
                    const termString = start.length > 0 ? q + '&start=' + start : q;

                    setURLQueryAnchor(q, start);
                    searchAJAX(termString);
                });
            }

            function searchAJAX(term)
            {
                if (term) {
                    $.ajax({
                        type: 'GET',
                        dataType: 'html',
                        url: '/home/SearchForm?q=' + term,
                        success: function(response) {
                            let searchResults = $('#search-results-content');
                            searchResults.html(response);
                            pagination(searchResults.find('.pagination a'));
                        },
                        error: function(xhr, status, error) {
                            console.error('search error');
                        }
                    });
                } else {
                    console.log('no term');
                }
            }

            function updatePopState() {
                window.onpopstate = function(event) {
                    // Check if event.state exists to ensure it's a state pushed by pushState()
                    if (event.state) {
                        let termString = '';
                        const term = event.state.term;
                        const offset = event.state.offset;

                        if (offset.length > 0)
                            termString = term + '&start=' + offset;
                        else
                            termString = term;

                        $('#CustomSearchForm_SearchForm_Search').val(term);
                        event.state.url.includes('#search-open') ? searchModal.show() : null;
                        searchAJAX(termString);

                        if (!window.location.hash.includes('#search-open')) {
                            searchModal.hide();
                        }
                    } else {
                        // Handle cases where the state is null (e.g., initial page load or navigating to a non-pushState entry)
                        console.log("Back button pressed, but no associated state.");
                    }
                };
            }

            function modalEvents() {
                searchModalEl.addEventListener('show.bs.modal', e => {
                    if (!window.location.hash.includes('#search-open')) {
                        setURLQueryAnchor();
                        console.log('show search');
                    }
                });
                searchModalEl.addEventListener('hide.bs.modal', e => {
                    if (window.location.hash.includes('#search-open')) {
                        setURLQueryAnchor('', '',true);
                        console.log('hide search');
                    }
                });
            }

            function setURLQueryAnchor(searchTerm = '', offset = '', closed = false)
            {
                console.log("term",  searchTerm);
                console.log('offset', offset);
                let newUrl, query;
                const baseUrl = location.protocol + '//' + location.host + location.pathname;

                if ((searchTerm === '' && offset !== '') || (searchTerm !== '' && offset !== '')) {
                    query = '?q=' + searchTerm + '&start=' + offset;
                    newUrl = baseUrl + query;
                } else if (searchTerm !== '' && offset === '') {
                    query = '?q=' + searchTerm;
                    newUrl = baseUrl + query;
                } else {
                    query = '';
                    newUrl = baseUrl;
                }

                console.log(query);

                const fullSearchURL = closed ? baseUrl : newUrl + '#search-open';

                const stateObj = {
                    title: document.title, // A title for the new history entry
                    search: query,
                    offset: offset,
                    term: searchTerm, // search query to call in ajax
                    url: fullSearchURL // The URL to display in the address bar
                };

                window.history.pushState(stateObj, "", fullSearchURL);
            }
        }
    });
}(jQuery));
