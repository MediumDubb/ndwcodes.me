<div class="blog-entry page full-window">
    <div class="container">
        <div class="page-wrapper">
            <div class="content-area">
                <article>
                    <h1>
                        {$H1}
                    </h1>

                    <% if $Content %>
                        <div class="content">$Content</div>
                    <% end_if %>

                    <% if $getPagePaginatedPosts.Exists %>
                        <div id="blog-posts">
                            <% loop $getPagePaginatedPosts %>
                                <% include PostSummary %>
                            <% end_loop %>
                        </div>
                        <% with $getPagePaginatedPosts %>
                            <% include Includes %>
                        <% end_with %>
                    <% else %>
                        <div id="blog-posts">
                            <p>There are no posts</p>
                        </div>
                    <% end_if %>
                </article>
            </div>
        </div>
    </div>
</div>
