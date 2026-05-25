<div class="resume-page">
    <div class="container">
        <div class="inner">
            <div class="head section">
                <div class="holder">
                    <h1>
                        <span class="first d-inline-block" data-aos="fade-right" data-aos-delay="200" data-aos-duration="400">{$First}</span><span class="last d-inline-block" data-aos="fade-left" data-aos-delay="400" data-aos-duration="500">{$Last}</span>
                        <span class="title d-block">{$Title}</span>
                    </h1>
                </div>
                <% if $Resume %>
                    <a href="{$Resume.Link()}" download class="d-inline-block mt-4">
                        <button class="primary">Download Resume PDF</button>
                    </a>
                <% end_if %>
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
                            <li class="break-word" data-aos="fade-down" data-aos-delay="{$Pos(1)}00" data-aos-duration="500">
                                <div class="dates d-flex justify-content-between align-items-center flex-wrap">
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
            <div class="more-info section">
                <div class="accordion" id="moreInfo-accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#moreInfo-1" aria-expanded="false" aria-controls="moreInfo-1">
                                <span class="heading h2">More Information</span>
                            </button>
                        </h2>
                        <div id="moreInfo-1" class="accordion-collapse collapse" data-bs-parent="#moreInfo-accordion">
                            <div class="accordion-body">
                                <div class="acc-section contact">
                                    <% if $ContactHeading %><p class="heading h3">{$ContactHeading}</p><% end_if %>
                                    <% if $Email %><p class="break-word">{$Email}</p><% end_if %>
                                    <% if $LinkedIn %><p class="break-word">{$LinkedIn}</p><% end_if %>
                                </div>
                                <div class="acc-section edu">
                                    <% if $EduHeading %><p class="heading h3">{$EduHeading}</p><% end_if %>
                                    <% if $Education %>
                                        <ul class="row justify-content-start">
                                            <% loop $Education %>
                                                <li class="col-sm-12 col-lg-6 col-xxl-4">
                                                    <p class="m-0">{$YearStart.format('Y')} - {$YearEnd.format('Y')}</p>
                                                    <p>{$Institution}</p>
                                                    {$List}
                                                </li>
                                            <% end_loop %>
                                        </ul>
                                    <% end_if %>
                                </div>
                                <div class="acc-section skills">
                                    <% if $SkillsHeading %><p class="heading h3">{$SkillsHeading}</p><% end_if %>
                                    <% if $SkillList %>
                                        {$SkillList}
                                    <% end_if %>
                                </div>
                                <div class="acc-section language">
                                    <% if $LanguageHeading %><p class="heading h3">{$LanguageHeading}</p><% end_if %>
                                    <% if $LangList %>
                                        {$LangList}
                                    <% end_if %>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
