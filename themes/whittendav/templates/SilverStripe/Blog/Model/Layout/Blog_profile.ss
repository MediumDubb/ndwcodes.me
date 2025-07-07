<% require css('silverstripe/blog: client/dist/styles/main.css') %>
<div class="blog panel <% if $RemoveTopPadding %> pt-0 <% end_if %><% if $RemoveBottomPadding %> pb-0 <% end_if %><% if $BackgroundColorClass %> {$BackgroundColorClass}<% end_if %>" id="Blog">
    <div class="container">
        <div class="paragraphs p-0 mb-5">
            <div class="red-trapezoid big"></div>
            <h2 class="h2">$CurrentProfile.FirstName $CurrentProfile.Surname</h2>
        </div>

        <noscript>This form requires that you have javascript enabled to work properly please enable javascript in your browser.</noscript>
        <% if $getPostAuthors() %>
            <div class="custom-select dropdown w-100 mb-3" id="formSelector">
                <button class="btn btn-secondary dropdown-toggle w-100" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Filter by Author
                </button>
                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
                    <a href="{$Link}">
                        <li>
                            <span>All Authors</span>
                        </li>
                    </a>
                    <% loop $getPostAuthors() %>
                        <a href="{$Up.Link}/profile/{$URLSegment}">
                            <li>
                                <span>{$FirstName} {$Surname}</span>
                            </li>
                        </a>
                    <% end_loop %>
                </ul>
            </div>
        <% end_if %>

        <div class="container-innerpage mx-auto">
            <div class="content-box">
            </div>
        </div>
    </div>
</div>
