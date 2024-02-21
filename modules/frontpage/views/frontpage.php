<!-- Header -->
<header class="header">
    <div class="brand">
        <svg width="31" height="57" viewBox="0 0 31 57" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M30.3669 24.3717C30.5949 24.7097 30.5949 25.1522 30.3669 25.4902L18.0082 43.8105C17.4565 44.6284 16.1792 44.2378 16.1792 43.2513L16.1792 6.61065C16.1792 5.62406 17.4565 5.23352 18.0082 6.05141L30.3669 24.3717Z"
                  fill="#3E50B4"/>
            <path d="M0.377257 32.0509C0.149267 31.713 0.149267 31.2704 0.377258 30.9325L12.7359 12.6122C13.2877 11.7943 14.5649 12.1848 14.5649 13.1714L14.5649 49.812C14.5649 50.7986 13.2877 51.1891 12.7359 50.3712L0.377257 32.0509Z"
                  fill="#CA4164"/>
        </svg>
        <span class="name"><?= $text_name ?></span>
    </div>

    <div class="language-switcher-component absolute topright z-5 margin-top-1 margin-right-1">

        <div class="dropdown relative" x-data="{flagDropdownOpen: false}">

            <button class="transparent padding-0 border-2 border-gray round"
                    style="    display: flex;
    align-items: center; color: white; margin-bottom: 6px;"
                    type="button"
                    aria-expanded="false"
                    @click="flagDropdownOpen = ! flagDropdownOpen"
            >

                <img class="round" style="height: 16px;"
                     src="<?= 'frontpage_module/images/flags/'.$language.'-flag.jpg' ?>"
                     alt="<?= $languages[$language] ?>">

                <svg aria-hidden="true"
                     focusable="false"
                     data-prefix="fas"
                     data-icon="caret-down"
                     style="margin-left: 2px;width: 12px; height: 12px;"
                     role="img"
                     xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 320 512"
                >
                    <path fill="currentColor"
                          d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z">
                    </path>
                </svg>
            </button>

            <ul x-show="flagDropdownOpen" class="dropdown-content no-bullets margin-0 padding-0"
                @click.outside="flagDropdownOpen = false" aria-labelledby="dropdownMenuButton">
                <?php foreach ($languages as $locale_name => $available_locale) {
                    if ($locale_name !== $language) { ?>
                        <li class="padding-0 transparent">
                            <a class="" title="<?= $locale_name ?>"
                               href="<?= BASE_URL.'localization/language/'.$locale_name ?>">
                                <img class="round" style="height: 16px; margin-left: 2px;"
                                     src="<?= 'frontpage_module/images/flags/'.$locale_name.'-flag.jpg' ?>"
                                     alt="<?= $available_locale ?>">
                            </a>
                        </li>
                    <?php }
                } ?>
            </ul>
        </div>

    </div>

    <div class="hero-text">
        <h1><?= $text_title ?></h1>
        <p class="subtitle"><?= $text_subtitle ?></p>

        <div class="under-construction">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
            </svg>
            <span class="inline-block ml-1"><?= $text_construction ?></span>
        </div>

        <div class="action-buttons mt-6">
            <nav>
                <a href="<?= MY_CV_LINK ?>" download class="button download-link">
                    <svg class="margin-right-0-5" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_672_923)">
                            <path d="M17.4163 8.25H13.7497V2.75H8.24967V8.25H4.58301L10.9997 14.6667L17.4163 8.25ZM4.58301 16.5V18.3333H17.4163V16.5H4.58301Z"
                                  fill="white" fill-opacity="0.9"></path>
                        </g>
                        <defs>
                            <clipPath id="clip0_672_923">
                                <rect width="22" height="22" fill="white"></rect>
                            </clipPath>
                        </defs>
                    </svg>
                    <span><?= $text_download ?></span></a>
                <a href="mailto:<?= $email_address ?>" class="button contact-link">
                    <svg class="margin-right-0-5" aria-hidden="true" focusable="false" viewBox="0 0 22 22" fill="none"
                         xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_672_926)">
                            <path d="M18.333 3.66667H3.66634C2.65801 3.66667 1.84217 4.49167 1.84217 5.5L1.83301 16.5C1.83301 17.5083 2.65801 18.3333 3.66634 18.3333H18.333C19.3413 18.3333 20.1663 17.5083 20.1663 16.5V5.5C20.1663 4.49167 19.3413 3.66667 18.333 3.66667ZM18.333 7.33333L10.9997 11.9167L3.66634 7.33333V5.5L10.9997 10.0833L18.333 5.5V7.33333Z"
                                  fill="white" fill-opacity="0.9"></path>
                        </g>
                        <defs>
                            <clipPath id="clip0_672_926">
                                <rect width="22" height="22" fill="white"></rect>
                            </clipPath>
                        </defs>
                    </svg>
                    <span><?= $text_send ?></span>
                </a>
            </nav>
        </div>
    </div>

    <div class="header-image">
        <img src="frontpage_module/images/header.jpg" class="object-cover" style="object-fit: cover"
             alt="darkblue illustration background">
    </div>

</header><!-- Header END -->


<!-- Introduction -->
<section class="introduction">

    <div class="greeting-box">

        <img src="frontpage_module/images/andras.gulacsi.png" alt="András Gulácsi's profile photo">

        <div class="introduction-text">
            <h2><?= $text_greeting ?></h2>
            <div><?= $text_introduction ?></div>
        </div>
    </div>
</section><!-- Introduction END -->


<!-- Skills -->
<section class="skills mb-12 sm:mb-20">

    <div class="text-center margin-top-2">

        <!-- Decoration -->
        <svg width="38" height="15" viewBox="0 0 38 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M19.3581 14.2496C19.0201 14.4776 18.5776 14.4776 18.2396 14.2496L0.551311 2.31733C-0.266575 1.76559 0.123966 0.48832 1.11055 0.48832L36.4871 0.48832C37.4737 0.48832 37.8643 1.76559 37.0464 2.31733L19.3581 14.2496Z"
                  fill="#CA4164"/>
        </svg>

        <h2 class="skills-title text-center"><?= $text_skills_heading ?></h2>
    </div>


    <div class="skills-grid">
        <!-- Skill list as grid -->
        <?php foreach ($skills as $skill) { ?>
            <div class="skill-box card rounded shadow <?= $skill->bg_color ?>">
                <h3 class="box-heading"><?= $skill->title ?></h3>
                <div class="margin-left-2 margin-top-1 margin-right-1"><?= $skill->content ?></div>
            </div>
        <?php } ?>
    </div>

</section><!-- Skills END -->


<!-- Portfolio works -->
<section class="projects relative">

    <div class="text-center padding-top-2 z-5 relative">
        <svg width="38" height="15" viewproject="0 0 38 15" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M19.3581 14.2496C19.0201 14.4776 18.5776 14.4776 18.2396 14.2496L0.551311 2.31733C-0.266575 1.76559 0.123966 0.48832 1.11055 0.48832L36.4871 0.48832C37.4737 0.48832 37.8643 1.76559 37.0464 2.31733L19.3581 14.2496Z"
                  fill="#CA4164"/>
        </svg>
        <h2 class="projects-title z-5 relative"><?= $text_projects_heading ?></h2>
    </div>

    <div class="projects-grid">
        <?php foreach ($projects as $project) { ?>
            <div class="project card">
                <div class="card-header relative">
                    <img class="object-cover round-top" src="<?= BASE_URL.$project->cover_image ?>" alt="Title">
                    <div class="project-description absolute bottomleft">
                        <h3>
                            <?= $project->title ?>
                        </h3>
                        <p class="text-white87pc"> <?= $project->client ?></p>
                    </div>
                </div>

                <div class="card-body padding-1">
                    <div class="text-black">
                        <?= $project->content ?>
                    </div>
                </div>

                <div class="card-footer round-bottom border-top" style="border-top-color:#ccc;">
                    <div class="bar">
                    <?= $project->links ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="projects-image">
        <img src="frontpage_module/images/bg-pattern.jpg" alt="bg pattern">
    </div>

</section><!-- Portfolio works END -->


<!-- Main action buttons -->
<div class="action-buttons-above-footer">
    <nav>
        <a href="<?= MY_CV_LINK ?>" download class="download-link">
            <svg class="margin-right-0-5" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_672_923)">
                    <path d="M17.4163 8.25H13.7497V2.75H8.24967V8.25H4.58301L10.9997 14.6667L17.4163 8.25ZM4.58301 16.5V18.3333H17.4163V16.5H4.58301Z"
                          fill="white" fill-opacity="0.9"></path>
                </g>
                <defs>
                    <clipPath id="clip0_672_923">
                        <rect width="22" height="22" fill="white"></rect>
                    </clipPath>
                </defs>
            </svg>
            <span><?= $text_download ?></span>
        </a>
        <a href="mailto:<?= $email_address ?>" class="contact-link">
            <svg class="margin-right-0-5" aria-hidden="true" focusable="false" viewBox="0 0 22 22" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_672_926)">
                    <path d="M18.333 3.66667H3.66634C2.65801 3.66667 1.84217 4.49167 1.84217 5.5L1.83301 16.5C1.83301 17.5083 2.65801 18.3333 3.66634 18.3333H18.333C19.3413 18.3333 20.1663 17.5083 20.1663 16.5V5.5C20.1663 4.49167 19.3413 3.66667 18.333 3.66667ZM18.333 7.33333L10.9997 11.9167L3.66634 7.33333V5.5L10.9997 10.0833L18.333 5.5V7.33333Z"
                          fill="white" fill-opacity="0.9"></path>
                </g>
                <defs>
                    <clipPath id="clip0_672_926">
                        <rect width="22" height="22" fill="white"></rect>
                    </clipPath>
                </defs>
            </svg>
            <span><?= $text_send ?></span>
        </a>
    </nav>
</div><!-- Main action buttons END -->


<!-- Footer -->
<footer class="footer relative">
    <small class="text-gray-text"><?= $text_copyright ?></small>

    <a href="<?= $github_link ?>">
        <svg width="37" height="37" viewBox="0 0 37 37" fill="none"
             xmlns="http://www.w3.org/2000/svg">
            <path d="M12.567 28.7184C12.567 28.8629 12.4008 28.9785 12.1912 28.9785C11.9527 29.0002 11.7865 28.8846 11.7865 28.7184C11.7865 28.5738 11.9527 28.4582 12.1623 28.4582C12.3791 28.4365 12.567 28.5521 12.567 28.7184ZM10.3195 28.3932C10.2689 28.5377 10.4135 28.7039 10.6303 28.7473C10.8182 28.8195 11.035 28.7473 11.0783 28.6027C11.1217 28.4582 10.9844 28.292 10.7676 28.227C10.5797 28.1764 10.3701 28.2486 10.3195 28.3932ZM13.5137 28.2703C13.3041 28.3209 13.1596 28.4582 13.1812 28.6244C13.2029 28.7689 13.3908 28.8629 13.6076 28.8123C13.8172 28.7617 13.9617 28.6244 13.94 28.4799C13.9184 28.3426 13.7232 28.2486 13.5137 28.2703ZM18.2688 0.578125C8.24551 0.578125 0.578125 8.1877 0.578125 18.2109C0.578125 26.2252 5.62227 33.0832 12.8271 35.4969C13.7521 35.6631 14.0773 35.0922 14.0773 34.6225C14.0773 34.1744 14.0557 31.7029 14.0557 30.1854C14.0557 30.1854 8.99707 31.2693 7.93477 28.0318C7.93477 28.0318 7.11094 25.9289 5.92578 25.3869C5.92578 25.3869 4.2709 24.2523 6.04141 24.274C6.04141 24.274 7.84082 24.4186 8.83086 26.1385C10.4135 28.9279 13.0656 28.1258 14.099 27.6488C14.2652 26.4926 14.735 25.6904 15.2553 25.2135C11.2156 24.7654 7.13984 24.1801 7.13984 17.2281C7.13984 15.2408 7.68906 14.2436 8.84531 12.9717C8.65742 12.502 8.04316 10.5652 9.0332 8.06484C10.5436 7.59512 14.0195 10.016 14.0195 10.016C15.4648 9.61133 17.0186 9.40176 18.5578 9.40176C20.0971 9.40176 21.6508 9.61133 23.0961 10.016C23.0961 10.016 26.5721 7.58789 28.0824 8.06484C29.0725 10.5725 28.4582 12.502 28.2703 12.9717C29.4266 14.2508 30.1348 15.248 30.1348 17.2281C30.1348 24.2018 25.8783 24.7582 21.8387 25.2135C22.5035 25.7844 23.0672 26.8684 23.0672 28.5666C23.0672 31.002 23.0455 34.0154 23.0455 34.608C23.0455 35.0777 23.3779 35.6486 24.2957 35.4824C31.5223 33.0832 36.4219 26.2252 36.4219 18.2109C36.4219 8.1877 28.292 0.578125 18.2688 0.578125ZM7.60234 25.5025C7.5084 25.5748 7.53008 25.741 7.65293 25.8783C7.76855 25.9939 7.93477 26.0445 8.02871 25.9506C8.12266 25.8783 8.10098 25.7121 7.97813 25.5748C7.8625 25.4592 7.69629 25.4086 7.60234 25.5025ZM6.82188 24.9172C6.77129 25.0111 6.84355 25.1268 6.98809 25.199C7.10371 25.2713 7.24824 25.2496 7.29883 25.1484C7.34941 25.0545 7.27715 24.9389 7.13262 24.8666C6.98809 24.8232 6.87246 24.8449 6.82188 24.9172ZM9.16328 27.4898C9.04766 27.5838 9.09102 27.8006 9.25723 27.9379C9.42344 28.1041 9.63301 28.1258 9.72695 28.0102C9.8209 27.9162 9.77754 27.6994 9.63301 27.5621C9.47402 27.3959 9.25723 27.3742 9.16328 27.4898ZM8.33945 26.4275C8.22383 26.4998 8.22383 26.6877 8.33945 26.8539C8.45508 27.0201 8.6502 27.0924 8.74414 27.0201C8.85977 26.9262 8.85977 26.7383 8.74414 26.5721C8.64297 26.4059 8.45508 26.3336 8.33945 26.4275Z"
                  fill="white" fill-opacity="0.9"/>
        </svg>
    </a>


    <a role="button" id="scroll-to-top" class="button-circle transparent" title="<?= $text_goto_top ?>">
        <svg width="28" height="28" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 21.7969C0 9.75586 9.75586 0 21.7969 0C33.8379 0 43.5938 9.75586 43.5938 21.7969C43.5938 33.8379 33.8379 43.5938 21.7969 43.5938C9.75586 43.5938 0 33.8379 0 21.7969ZM12.6211 24.3369L18.9844 17.7012V33.75C18.9844 34.9189 19.9248 35.8594 21.0938 35.8594H22.5C23.6689 35.8594 24.6094 34.9189 24.6094 33.75V17.7012L30.9727 24.3369C31.79 25.1895 33.1523 25.207 33.9873 24.3721L34.9453 23.4053C35.7715 22.5791 35.7715 21.2432 34.9453 20.4258L23.291 8.7627C22.4648 7.93652 21.1289 7.93652 20.3115 8.7627L8.63965 20.4258C7.81348 21.252 7.81348 22.5879 8.63965 23.4053L9.59766 24.3721C10.4414 25.207 11.8037 25.1895 12.6211 24.3369V24.3369Z"
                  fill="white" fill-opacity="0.5"/>
        </svg>
    </a>

</footer><!-- Footer END -->
