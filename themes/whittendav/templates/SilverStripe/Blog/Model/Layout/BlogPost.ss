<% require css('silverstripe/blog: client/dist/styles/main.css') %>

<div class="blog-post page full-window">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="content-area center">
                <% if $ContentSections %>
                    <% loop $ContentSections %>
                        {$CopyBlock}
                    <% end_loop %>
                <% end_if %>
            </div>
        </div>
    </div>
</div>
