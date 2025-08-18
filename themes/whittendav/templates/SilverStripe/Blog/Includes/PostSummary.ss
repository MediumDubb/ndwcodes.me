<div class="post-summary">
    <p>$PublishDate.Format('MM, yyyy') |
        <a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
            <% if $MenuTitle %>$MenuTitle
            <% else %>$Title<% end_if %></a>
    </p>

    <p class="post-image">
        <a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">
            $FeaturedImage.ScaleWidth(795)
        </a>
    </p>

    <% if $Summary %>
        $Summary
    <% else %>
        <p>$Excerpt</p>
    <% end_if %>
</div>
