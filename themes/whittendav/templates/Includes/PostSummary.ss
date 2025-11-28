<div class="post-summary">
    <p>$PostDate.Format('MM, yyyy') |
        <a href="$Link" title="Read more about {$Title}">$Title</a>
    </p>

    <p class="post-image">
        <a href="$Link" title="Read more about {$Title}">
            $FeaturedImage.ScaleWidth(795)
        </a>
    </p>

    <% if $SpecialPreview %>
        $SpecialPreview
    <% else %>
        <p>$Excerpt</p>
    <% end_if %>
</div>
