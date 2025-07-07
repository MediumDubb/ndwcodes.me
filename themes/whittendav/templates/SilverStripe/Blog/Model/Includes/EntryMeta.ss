<div class="">
    <div class="text-decoration-none date" href="$MonthlyArchiveLink">$PublishDate.Format('MMMM dd, yyyy')</div>
    <div class="text-decoration-none authors" href="$MonthlyArchiveLink">
        <% if $Authors %>By:
            <% loop $Authors %>
                $FirstName $Surname<% if not $isLast %>, <% end_if %>
            <% end_loop %>
            <% if $AuthorNames %>
                $AuthorNames
            <% end_if %>
        <% end_if %>
    </div>
</div>
