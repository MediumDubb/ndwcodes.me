<li class="post post-summary">
    <p>$PostDate.Format('MM/yyyy') |
        <a href="$Link" title="Read more about {$Title}">$Title</a>
    </p>

    <% if $FeaturedImage %>
        <a href="$Link" title="Read more about {$Title}">
            <p class="post-image" style="background-image: url('{$FeaturedImage.ScaleWidth(795).Link()}'); background-size:cover;" aria-label="Featured Image: {$FeaturedImage.Title}">
            </p>
        </a>
    <% end_if %>

    <% if $SpecialPreview %>
        $SpecialPreview
    <% else %>
        <p>$Excerpt</p>
    <% end_if %>
</li>
