<div class="resume-page">
    <div class="container">
        <div class="inner">
            <div class="head section">
                <div class="holder">
                    <h1>
                        <span class="first">{$First}</span><span class="last">{$Last}</span>
                        <span class="title d-block">{$Title}</span>
                    </h1>
                </div>
            </div>
            <div class="profile section">
                <% if $ProfileHeading %>
                    <p class="heading h2">{$ProfileHeading}</p>
                    <hr />
                <% end_if %>
                <% if $Description %>
                    <p>{$Description}</p>
                <% end_if %>
            </div>
            <div class="experience section">
                <% if $ExpHeading %>
                    <p class="heading h2">{$ExpHeading}</p>
                    <hr />
                <% end_if %>
                <% if $Experiences %>
                    <ul class="list">
                        <% loop $Experiences %>
                            <li data-aos="fade-down" data-aos-delay="{$Pos(1)}00" data-aos-duration="500">
                                <div class="dates d-flex justify-content-between align-items-center">
                                    <p class="name">{$Title}</p>
                                    <p class="start-stop"><span class="begin">{$YearStart.format('Y')}</span><span class="sep">-</span><% if $YearEnd %><span class="end">{$YearEnd.format('Y')}</span><% else_if $Current %><span class="present">PRESENT</span><% end_if %></p>
                                </div>
                                <p class="position-title">{$PositionTitle}</p>
                                {$List}
                            </li>
                        <% end_loop %>
                    </ul>
                <% end_if %>
            </div>
        </div>
    </div>
</div>
