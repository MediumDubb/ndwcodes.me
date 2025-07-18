<div data-ajax-results="true" class="searchResults">
    <% if $Me.Count > 0 %>
    <ul id="SearchResults">
        <% loop $Me %>
        <li>
            <p>
                <strong>
                    <a href="$Link">
                        <% if $MenuTitle %>
                            $MenuTitle
                        <% else %>
                            $Title
                        <% end_if %>
                    </a>
                </strong>
            </p>
            <% if $Content %>
                <p>$Content.LimitWordCountXML</p>
            <% end_if %>
            <a class="readMoreLink" href="$Link" title="Read more about &quot;{$Title}&quot;">Read more about &quot;{$Title}&quot;...</a>
        </li>
        <% end_loop %>
    </ul>
    <% else %>
    <p>Sorry, your search query did not return any results.</p>
    <% end_if %>

    <% if $Me.MoreThanOnePage %>
    <div id="PageNumbers">
        <div class="pagination">
            <% if $Me.NotFirstPage %>
            <a class="prev" href="$Me.PrevLink" title="View the previous page">&larr;</a>
            <% end_if %>
            <span>
                <% loop $Me.Pages %>
                    <% if $CurrentBool %>
                    $PageNum
                    <% else %>
                    <a href="$Link" title="View page number $PageNum" class="go-to-page">$PageNum</a>
                    <% end_if %>
                <% end_loop %>
            </span>
            <% if $Me.NotLastPage %>
            <a class="next" href="$Me.NextLink" title="View the next page">&rarr;</a>
            <% end_if %>
        </div>
        <p>Page $Me.CurrentPage of $Me.TotalPages</p>
    </div>
    <% end_if %>
</div>
