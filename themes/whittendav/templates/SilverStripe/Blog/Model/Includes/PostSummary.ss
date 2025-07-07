<div class="col-lg-3 col-sm-6 col-12 mb-5">
    <div class="card-wrapper">
        <a href="$Link">
            <div class="box-services">
                <div class="featured-img-aspect">
                    <img class="post-summary-img" src="{$FeaturedImage.ScaleWidth(500).LINK}" alt="$FeaturedImage.TITLE">
                </div>

                <% include SilverStripe\Blog\Model\Includes\EntryMeta %>

                <h3 class="post-title mt-2">
                    <% if $MenuTitle %>
                        $MenuTitle
                    <% else %>
                        <p class="font-weight-bold">$Title</p>
                    <% end_if %>
                </h3>

                <div class="description">
                    <% if $Excerpt %>
                        <div class="mb-3">
                            <p class="text-md"><% if $Summary %>$Summary<% else %>$Excerpt<% end_if %></p>
                        </div>
                    <% end_if %>
                </div>
            </div>
        </a>
    </div>
</div>



