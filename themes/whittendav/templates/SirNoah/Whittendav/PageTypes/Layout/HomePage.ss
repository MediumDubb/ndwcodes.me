<div class="home-page page full-window">
    <div class="container">
        <div class="d-flex align-items-center justify-content-center">
            <div class="content-area center">
                <h1>
                        <%if $First %>
                            <span class="d-inline-block" data-aos="fade-down" data-aos-delay="500">
                                $First
                            </span>
                        <% end_if %>
                        <% if $Middle %>
                            <span class="d-inline-block" data-aos="fade-down" data-aos-delay="1000">
                                $Middle
                            </span>
                        <% end_if %>
                        <%if $Last %>
                            <span class="d-inline-block" data-aos="fade-down" data-aos-delay="1500">
                                $Last
                            </span>
                        <% end_if %>
                </h1>
                <% if $Sub %>
                    <h2 class="sub" data-aos="fade" data-aos-delay="1900">
                        {$Sub}
                    </h2>
                <% end_if %>
                <% if $FrontEndCopy %>
                    <div class="body"
                         data-aos="fade"
                         data-aos-easing="ease-in-back"
                         data-aos-delay="2200">
                        {$FrontEndCopy}
                    </div>
                <% end_if %>
            </div>
        </div>
    </div>
</div>
