<div class="home-page" id="home">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="center-piece">
                <h1>
                    <%if $First %>$First&nbsp;<% end_if %><%if $Middle %>$Middle&nbsp;<% end_if %><%if $Last %>$Last<% end_if %>
                </h1>
                <% if $Sub %>
                    <h2 class="sub">
                        {$Sub}
                    </h2>
                <% end_if %>
                <% if $Content %>
                    <div class="body">
                        {$Content}
                    </div>
                <% end_if %>
            </div>
        </div>
    </div>
</div>
