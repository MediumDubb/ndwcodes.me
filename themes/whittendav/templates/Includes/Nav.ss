<nav class="navbar navbar-expand-lg" id="main-nav">
    <div class="container">
        <a class="logo" href="/">
            {$SiteConfig.Title}
        </a>
        <div class="page-links">
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <% if $ChildrenOf('home') %>
                        <% loop $ChildrenOf('home') %>
                            <% if $Children %>
                                <% include BootstrapDropDown %>
                            <% else %>
                                <li class="nav-item top-level fl-blade">
                                    <a class="nav-link top-level active" aria-current="page" href="{$Link}">{$MenuTitle}</a>
                                </li>
                            <% end_if %>
                        <% end_loop %>
                    <% end_if %>
                    <li class="nav-item fl-blade">
                        <% include SearchButton %>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
