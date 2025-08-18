<%-- NOTE: Before including this, you will need to wrap the include in a with block  --%>

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
                        <li class="current" title="current page number $PageNum">{$PageNum}</li>
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

