<li class="nav-item top-level dropdown fl-blade has-children">
    <span class="nav-link top-level dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        {$MenuTitle}
    </span>
    <ul class="dropdown-menu<% if $isLast %> dropdown-menu-end<% end_if %>">
        <% loop $Children %>
            <li><a class="dropdown-item" href="{$Link}">{$MenuTitle}</a></li>
        <% end_loop %>
    </ul>
</li>
