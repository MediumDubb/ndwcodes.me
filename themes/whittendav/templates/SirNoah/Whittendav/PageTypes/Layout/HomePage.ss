<div class="home-page page full-window">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="content-area center"
                 data-aos="fade"
                 data-aos-easing="ease-in-back"
                 data-aos-delay="500">
                <h1>
                    <%if $First %>$First&nbsp;<% end_if %><%if $Middle %>$Middle&nbsp;<% end_if %><%if $Last %>$Last<% end_if %>
                </h1>
                <% if $Sub %>
                    <h2 class="sub">
                        {$Sub}
                    </h2>
                <% end_if %>
                <% if $FrontEndCopy %>
                    <div class="body">
                        {$FrontEndCopy}
                    </div>
                <% end_if %>
            </div>
        </div>
    </div>
</div>
