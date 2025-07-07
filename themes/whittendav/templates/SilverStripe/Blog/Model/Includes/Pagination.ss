<%-- NOTE: Before including this, you will need to wrap the include in a with block  --%>

<div class="pagination">
    <ul class="">
        <li class="rounded-start-left">
            <% if $NotFirstPage %>
                <a class="prev text-decoration-none" href="{$PrevLink}">«</a>
            <% else %>
                <span class="prev">«</span>
            <% end_if %>
        </li>
            <% loop $PaginationSummary(5) %>
                <% if $CurrentBool %>
                    <li class="inner">
                        <span class="current">$PageNum</span>
                    </li>
                <% else %>
                    <li class="inner">
                        <% if $Link %>
                            <a class="paginated-link text-decoration-none" href="$Link">$PageNum</a>
                        <% else %>
                            <span>...</span>
                        <% end_if %>
                    </li>
                <% end_if %>
            <% end_loop %>
        <li class="rounded-end-right">
            <% if $NotLastPage %>
                <a class="next text-decoration-none" href="{$NextLink}">»</a>
            <% else %>
                <a class="next text-decoration-none" href="#">»</a>
            <% end_if %>
        </li>
    </ul>
</div>

