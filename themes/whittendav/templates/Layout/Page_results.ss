<div data-ajax-results="true" class="searchResults">
    <% if $Me.Count > 0 %>
    <ul id="SearchResults">
        <% loop $Me %>
        <li>
            <strong>
                <a href="$Link">
                    <% if $MenuTitle %>
                        $MenuTitle
                    <% else %>
                        $Title
                    <% end_if %>
                </a>
            </strong>
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
            <ul>
                <% if $Me.NotFirstPage %>
                    <li class="prev" >
                        <a data-href="$Me.PrevLink" title="View the previous page">&larr;</a>
                    </li>
                <% end_if %>
                <% loop $Me.Pages %>
                    <% if $CurrentBool %>
                        <li class="current">{$PageNum}</li>
                    <% else %>
                        <li class="go-to-page">
                            <a data-href="$Link" title="View page number $PageNum" >$PageNum</a>
                        </li>
                    <% end_if %>
                <% end_loop %>
                <% if $Me.NotLastPage %>
                    <li class="next">
                        <a data-href="$Me.NextLink" title="View the next page">&rarr;</a>
                    </li>
                <% end_if %>
            </ul>
        </div>
        <p>Page $Me.CurrentPage of $Me.TotalPages</p>
    </div>
    <% end_if %>
</div>
