<% require css('silverstripe/blog: client/dist/styles/main.css') %>

<div class="blog-post page full-window">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="content-area center">
                <% if $ContentSections %>
                    <% loop $ContentSections %>
                        <% if $Images %>
                            <div id="postImageCarousel" class="carousel slide pb-3">
                                <div class="carousel-inner">
                                    <% loop $Images %>
                                        <div class="carousel-item<% if $isFirst %> active<% end_if %>">
                                            <img class="d-block w-100" src="{$ScaleMaxWidth(1920).Link()}" alt="{$Title}">
                                        </div>
                                    <% end_loop %>
                                </div>
                                <% if $Images.count > 1 %>
                                    <a class="carousel-control-prev" href="#postImageCarousel" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#postImageCarousel" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                <% end_if %>
                            </div>
                        <% end_if %>
                        {$CopyBlock}
                    <% end_loop %>
                <% end_if %>
            </div>
        </div>
    </div>
</div>
