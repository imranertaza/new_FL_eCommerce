<section class="section-footer">
    <div class="massager">

        <?php
            $modulId = get_data_by_id('module_id','cc_modules','module_key','contact_with_whatsapp');
            $modulIdTelegram = get_data_by_id('module_id','cc_modules','module_key','telegram');

        ?>

        <a type="button"  id="message_social">
            <i class="fas fa-4x fa-comment-dots" style="color:#0594eb;"></i>
        </a>

        <div class="content_mess" id="content_mess" style="display:none;">
            <a target="_blank" href="https://wa.me/<?php echo get_model_settings_value_by_modelId_or_label($modulId, 'whatsapp_number');?>" ><i class="fa-brands fa-square-whatsapp"></i> Whatsapp</a><br>
            <a target="_blank" href="https://t.me/<?php echo get_model_settings_value_by_modelId_or_label($modulIdTelegram, 'telegram_user');?>"><i class="fa-brands fa-telegram"></i> Telegram</a>
        </div>

    </div>




    <div class="newsletter">
        <div class="container">
            <div class="row gx-0 align-items-center">
                <div class="col-md-6">
                    <h2>Subscribe Our Newsletter!</h2>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" name="subscribe_email" id="subscribe_email"  class="form-control" placeholder="Enter your Email address" aria-label="Search" aria-describedby="search-addon" />
                        <button type="button" class="btn btn-subscribe" onclick="subscribe('subscribe_email')" >Subscribe Now</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="footer-box">
            <div class="container">
                <div class="border p-4">
                    <div class="row gx-4">
                        <div class="col-sm-6 col-lg-3 col-12 mb-3 mb-lg-0">
                            <div class="d-flex flex-row gap-2 border-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                    <g clip-path="url(#clip0_3337_1059)">
                                        <path d="M36.908 2.19177H3.09198C1.38708 2.19177 0 3.57886 0 5.28375V25.3229C0 27.0278 1.38708 28.4149 3.09198 28.4149H16.8689C17.1931 28.4149 17.456 28.152 17.456 27.8278C17.456 27.5036 17.1931 27.2407 16.8689 27.2407H3.09198C2.03452 27.2407 1.17417 26.3803 1.17417 25.3229V5.28375C1.17417 4.22629 2.03452 3.36594 3.09198 3.36594H36.908C37.9655 3.36594 38.8258 4.22629 38.8258 5.28375V25.3229C38.8258 25.6471 39.0887 25.91 39.4129 25.91C39.7371 25.91 40 25.6471 40 25.3229V5.28375C40 3.57886 38.6129 2.19177 36.908 2.19177Z" fill="black"/>
                                        <path d="M4.97087 24.0313H16.8691C17.1933 24.0313 17.4562 23.7685 17.4562 23.4443C17.4562 23.12 17.1933 22.8572 16.8691 22.8572H4.97087C4.64665 22.8572 4.38379 23.12 4.38379 23.4443C4.38379 23.7685 4.64665 24.0313 4.97087 24.0313Z" fill="black"/>
                                        <path d="M11.8202 12.1722V9.66729C11.8202 8.65296 10.995 7.82776 9.98066 7.82776H6.22332C5.20899 7.82776 4.38379 8.65296 4.38379 9.66729V12.1722C4.38379 13.1865 5.20899 14.0117 6.22332 14.0117H9.98066C10.995 14.0117 11.8202 13.1865 11.8202 12.1722ZM5.55796 12.1722V11.5068H6.22332C6.54755 11.5068 6.8104 11.244 6.8104 10.9197C6.8104 10.5955 6.54755 10.3327 6.22332 10.3327H5.55796V9.66729C5.55796 9.3004 5.85643 9.00193 6.22332 9.00193H7.5149V12.8375H6.22332C5.85643 12.8375 5.55796 12.5391 5.55796 12.1722ZM9.98066 12.8375H8.68907V9.00193H9.98066C10.3475 9.00193 10.646 9.3004 10.646 9.66729V10.3327H9.98066C9.65643 10.3327 9.39357 10.5955 9.39357 10.9197C9.39357 11.244 9.65643 11.5068 9.98066 11.5068H10.646V12.1722C10.646 12.5391 10.3475 12.8375 9.98066 12.8375Z" fill="black"/>
                                        <path d="M4.38379 19.6868C4.38379 20.011 4.64665 20.2739 4.97087 20.2739C5.2951 20.2739 5.55796 20.011 5.55796 19.6868V18.4344C5.55796 18.1101 5.2951 17.8473 4.97087 17.8473C4.64665 17.8473 4.38379 18.1101 4.38379 18.4344V19.6868Z" fill="black"/>
                                        <path d="M6.26221 18.4344V19.6868C6.26221 20.011 6.52506 20.2739 6.84929 20.2739C7.17352 20.2739 7.43638 20.011 7.43638 19.6868V18.4344C7.43638 18.1101 7.17352 17.8473 6.84929 17.8473C6.52506 17.8473 6.26221 18.1101 6.26221 18.4344Z" fill="black"/>
                                        <path d="M8.14111 18.4344V19.6868C8.14111 20.011 8.40397 20.2739 8.7282 20.2739C9.05242 20.2739 9.31528 20.011 9.31528 19.6868V18.4344C9.31528 18.1101 9.05242 17.8473 8.7282 17.8473C8.40397 17.8473 8.14111 18.1101 8.14111 18.4344Z" fill="black"/>
                                        <path d="M10.0195 18.4344V19.6868C10.0195 20.011 10.2824 20.2739 10.6066 20.2739C10.9308 20.2739 11.1937 20.011 11.1937 19.6868V18.4344C11.1937 18.1101 10.9308 17.8473 10.6066 17.8473C10.2824 17.8473 10.0195 18.1101 10.0195 18.4344Z" fill="black"/>
                                        <path d="M13.6986 19.6868V18.4344C13.6986 18.1101 13.4357 17.8473 13.1115 17.8473C12.7873 17.8473 12.5244 18.1101 12.5244 18.4344V19.6868C12.5244 20.011 12.7873 20.2739 13.1115 20.2739C13.4357 20.2739 13.6986 20.011 13.6986 19.6868Z" fill="black"/>
                                        <path d="M15.5775 19.6868V18.4344C15.5775 18.1101 15.3146 17.8473 14.9904 17.8473C14.6662 17.8473 14.4033 18.1101 14.4033 18.4344V19.6868C14.4033 20.011 14.6662 20.2739 14.9904 20.2739C15.3146 20.2739 15.5775 20.011 15.5775 19.6868Z" fill="black"/>
                                        <path d="M16.8688 17.8473C16.5446 17.8473 16.2817 18.1101 16.2817 18.4344V19.6868C16.2817 20.011 16.5446 20.2739 16.8688 20.2739C17.193 20.2739 17.4559 20.011 17.4559 19.6868V18.4344C17.4559 18.1101 17.193 17.8473 16.8688 17.8473Z" fill="black"/>
                                        <path d="M19.3348 19.6868V18.4344C19.3348 18.1101 19.072 17.8473 18.7477 17.8473C18.4235 17.8473 18.1606 18.1101 18.1606 18.4344V19.6868C18.1606 20.011 18.4235 20.2739 18.7477 20.2739C19.072 20.2739 19.3348 20.011 19.3348 19.6868Z" fill="black"/>
                                        <path d="M32.5246 14.0117C34.2295 14.0117 35.6166 12.6246 35.6166 10.9197C35.6166 9.21484 34.2295 7.82776 32.5246 7.82776H28.7673C27.0624 7.82776 25.6753 9.21484 25.6753 10.9197C25.6753 12.6246 27.0624 14.0117 28.7673 14.0117H32.5246ZM26.8495 10.9197C26.8495 9.86228 27.7098 9.00193 28.7673 9.00193H32.5246C33.5821 9.00193 34.4424 9.86228 34.4424 10.9197C34.4424 11.9772 33.5821 12.8375 32.5246 12.8375H28.7673C27.7098 12.8375 26.8495 11.9772 26.8495 10.9197Z" fill="black"/>
                                        <path d="M37.0865 21.5224C36.953 21.4301 36.7873 21.3972 36.6287 21.4313C36.0952 21.5463 35.557 21.6047 35.0292 21.6047C32.4225 21.6047 30.033 20.2807 28.6377 18.0629C28.5302 17.8921 28.3426 17.7885 28.1408 17.7885C27.939 17.7885 27.7513 17.8921 27.6438 18.0629C26.2485 20.2807 23.8591 21.6047 21.2524 21.6047C20.7246 21.6047 20.1865 21.5463 19.6528 21.4313C19.4944 21.3971 19.3285 21.43 19.1951 21.5224C19.0616 21.6147 18.9723 21.7582 18.9484 21.9186C18.841 22.6388 18.7866 23.3628 18.7866 24.0705C18.7866 30.2243 22.6418 35.9889 27.9534 37.7776C28.0142 37.798 28.0775 37.8083 28.1408 37.8083C28.2042 37.8083 28.2674 37.798 28.3282 37.7776C33.6399 35.9889 37.495 30.2243 37.495 24.0705C37.495 23.3628 37.4406 22.6388 37.3332 21.9186C37.3093 21.7581 37.22 21.6147 37.0865 21.5224ZM22.3289 31.8619C20.8018 29.5565 19.9608 26.7895 19.9608 24.0705C19.9608 23.6164 19.9853 23.1547 20.0337 22.6915C20.4413 22.7496 20.8492 22.7789 21.2524 22.7789C23.6697 22.7789 25.9242 21.7939 27.5537 20.0816V36.3668C25.5217 35.4886 23.6881 33.9138 22.3289 31.8619ZM33.9528 31.8619C32.5936 33.9138 30.7601 35.4886 28.7279 36.3669V20.0816C30.3574 21.7939 32.612 22.7789 35.0293 22.7789C35.4325 22.7789 35.8404 22.7495 36.2479 22.6915C36.2964 23.1547 36.3209 23.6164 36.3209 24.0705C36.3209 26.7895 35.4799 29.5565 33.9528 31.8619Z" fill="black"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_3337_1059">
                                            <rect width="40" height="40" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                                <div class="icon-box">
                                    <h6 class="mb-0">Secure Payment Gateway</h6>
                                    <p>Your money is protected</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 col-12 mb-3 mb-lg-0">
                            <div class="d-flex flex-row gap-2 border-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                    <g clip-path="url(#clip0_3336_1047)">
                                        <path d="M25.9297 0.191431C25.6118 0.186992 25.3084 0.21153 25.0078 0.257838C23.8054 0.443069 22.7986 0.877626 20.832 1.21487C19.0257 1.52463 17.8001 1.07612 16.2695 0.687525C14.7389 0.298931 12.8807 0.0510197 10.5859 1.08987C10.0251 1.34512 9.82627 2.04193 10.168 2.55471L13.7148 7.87112C12.9598 8.58975 10.7722 10.7178 8.19922 14.1485C5.13912 18.2286 2 23.5994 2 29C2 34.3005 4.61757 37.3286 8.14062 38.6836C11.6637 40.0386 16 40 20 40C24 40 28.3363 40.0386 31.8594 38.6836C35.3824 37.3286 38 34.3005 38 29C38 23.5994 34.8609 18.2286 31.8008 14.1485C29.2278 10.7178 27.0402 8.58975 26.2852 7.87112L29.832 2.55471C30.1779 2.03488 29.9681 1.32876 29.3945 1.08206C27.9573 0.466228 26.8834 0.204748 25.9297 0.191431ZM25.3125 2.2344C25.8456 2.15228 26.662 2.47265 27.3594 2.66018L24.4648 7.00002H15.5352L12.6094 2.6094C13.7593 2.33403 14.7279 2.3625 15.7773 2.62893C17.1844 2.98617 18.8808 3.57974 21.168 3.18753C23.2949 2.82279 24.455 2.3665 25.3125 2.2344ZM15.4141 9.00002H24.5859C24.9607 9.34969 27.4689 11.7111 30.1992 15.3516C33.1391 19.2715 36 24.4007 36 29C36 33.6996 34.1176 35.6715 31.1406 36.8164C28.1637 37.9614 24 38 20 38C16 38 11.8363 37.9614 8.85938 36.8164C5.88243 35.6715 4 33.6996 4 29C4 24.4007 6.86088 19.2715 9.80078 15.3516C12.5311 11.7111 15.0393 9.34969 15.4141 9.00002ZM19 18V20C17.355 20 16 21.355 16 23C16 24.645 17.355 26 19 26H21C21.5641 26 22 26.4359 22 27C22 27.5642 21.5641 28 21 28H19H16V30H19V32H21V30C22.645 30 24 28.645 24 27C24 25.355 22.645 24 21 24H19C18.4359 24 18 23.5642 18 23C18 22.4359 18.4359 22 19 22H21H24V20H21V18H19Z" fill="#222222"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_3336_1047">
                                            <rect width="40" height="40" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                                <div class="icon-box">
                                    <h6 class="mb-0">Monthly Promo</h6>
                                    <p>Save as you buy</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 col-12 mb-3 mb-lg-0">
                            <div class="d-flex flex-row gap-2 border-end">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                    <path d="M39.664 20.8913L35.664 14.8906C35.2933 14.3339 34.6687 13.9999 34 13.9999H24V25.9999H0V30C0 31.1046 0.895313 32 2 32H7.10133C7.56602 34.2793 9.58531 36 12 36C14.4147 36 16.434 34.2793 16.8987 32H26.1013C26.566 34.2793 28.5853 36 31 36C33.4147 36 35.434 34.2793 35.8987 32H38C39.1047 32 40 31.1046 40 30V22.0006C40 21.606 39.8834 21.22 39.664 20.8913ZM7.10133 30H2V28H8.02398C7.58266 28.5839 7.25266 29.2573 7.10133 30ZM12 34C10.3434 34 9 32.6566 9 31C9 29.3433 10.3434 28 12 28C13.6566 28 15 29.3433 15 31C15 32.6566 13.6566 34 12 34ZM24 30H16.8987C16.7473 29.2573 16.4173 28.5839 15.976 28H24V30ZM26 16H34L37.5747 21.362L32.2427 20.0286C32.1634 20.01 32.082 20 32 20H26V16ZM31 34C29.3434 34 28 32.6566 28 31C28 29.3433 29.3434 28 31 28C32.6566 28 34 29.3433 34 31C34 32.6566 32.6566 34 31 34ZM38 25H36V27H38V30H35.8987C35.434 27.7207 33.4147 26 31 26C28.5853 26 26.566 27.7207 26.1013 30H26V22H31.8766L38 23.5313V25Z" fill="black"/>
                                    <path d="M20 4H4C2.89531 4 2 4.89531 2 6V22C2 23.1047 2.89531 24 4 24H20C21.1047 24 22 23.1047 22 22V6C22 4.89531 21.1047 4 20 4ZM11 6H13V10H11V6ZM13 22H11V18H13V22ZM20 22H15V16H9V22H4V6H9V12H15V6H20V22Z" fill="black"/>
                                </svg>
                                <div class="icon-box">
                                    <h6 class="mb-0">Reputable Courier</h6>
                                    <p>Address protect from custom</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 col-12 mb-3 mb-lg-0">
                            <div class="d-flex flex-row gap-2">
                                <svg fill="#000000" width="40px" viewBox="0 0 32 32" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"  xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="Icon">
                                    <path d="M4.019,15.977c0,2.543 0,9.011 0,9.011c0,0.795 0.316,1.558 0.879,2.121c0.563,0.563 1.326,0.879 2.121,0.879c0.638,-0 1.343,-0 1.981,-0c0.796,-0 1.559,-0.316 2.121,-0.879c0.563,-0.563 0.879,-1.326 0.879,-2.121c0,-1.486 0,-3.503 -0,-4.988c0,-0.796 -0.316,-1.559 -0.879,-2.121c-0.562,-0.563 -1.325,-0.879 -2.121,-0.879l-2.981,0l0,-1.023c0,-5.497 4.456,-9.952 9.952,-9.952l0.077,-0c5.496,-0 9.952,4.455 9.952,9.952l0,1.011l-2.981,-0c-0.795,-0 -1.558,0.316 -2.121,0.878c-0.563,0.563 -0.879,1.326 -0.879,2.122c0,1.491 0,3.52 0,5.012c0,0.796 0.316,1.559 0.879,2.121c0.563,0.563 1.326,0.879 2.121,0.879c0.638,0 1.343,0 1.981,0c0.796,0 1.559,-0.316 2.121,-0.879c0.563,-0.562 0.879,-1.325 0.879,-2.121c-0,-0 0,-6.48 0,-9.023c-0,-6.601 -5.351,-11.952 -11.952,-11.952l-0.077,-0c-6.601,-0 -11.952,5.351 -11.952,11.952Zm21.981,3.011l-0,6.012c0,0.265 -0.105,0.52 -0.293,0.707c-0.187,0.188 -0.442,0.293 -0.707,0.293l-1.981,0c-0.265,0 -0.519,-0.105 -0.707,-0.293c-0.187,-0.187 -0.293,-0.442 -0.293,-0.707l0,-5.012c0,-0.266 0.106,-0.52 0.293,-0.707c0.188,-0.188 0.442,-0.293 0.707,-0.293l2.981,-0Zm-19.981,0.012l2.981,-0c0.265,-0 0.52,0.105 0.707,0.293c0.188,0.187 0.293,0.442 0.293,0.707l0,4.988c0,0.265 -0.105,0.519 -0.293,0.707c-0.187,0.187 -0.442,0.293 -0.707,0.293l-1.981,-0c-0.265,-0 -0.519,-0.106 -0.707,-0.293c-0.187,-0.188 -0.293,-0.442 -0.293,-0.707l0,-5.988Z"/>
                                    </g>
                                    </svg>
                                <div class="icon-box">
                                    <h6 class="mb-0">Support 24/7</h6>
                                    <p>Contact us 24 hours a day</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="footer-middle">
            <div class="container">  
                <div class="row">
                    <div class="col-md-3 col-12">
                        <h4 class="f-title toggleButton">Customer Service</h4>
                        <div class="elementToToggle d-none d-md-block">
                            <ul class="list-unstyled ul-link mt-md-4">
                                <?php $returns = get_data_by_id('slug','cc_pages','page_id','6'); ?>
                                <li><a href="<?php echo base_url('page/'.$returns) ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Returns
                                </a></li>
                                <?php $contact = get_data_by_id('slug','cc_pages','page_id','1'); ?>
                                <li><a href="<?php echo base_url('page/'.$contact) ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Contact us
                                </a></li>
                                <?php $siteMap = get_data_by_id('slug','cc_pages','page_id','14'); ?>
                                <li>
                                    <a href="<?php echo base_url('page/'.$siteMap)?>" >
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Site Map</a>
                                </li>
                            </ul>
                            <div class="footer-logo">
                                <img src="<?php echo base_url() ?>/assets/assets_fl/img/logo-footer.png" class="img-fluid" alt="Logo">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12">
                        <h4 class="f-title toggleButton">Information</h4>
                        <div class="elementToToggle d-none d-md-block">
                            <ul class="list-unstyled ul-link mt-md-4">
                                <?php $ourCoreValues = get_data_by_id('slug','cc_pages','page_id','11'); ?>
                                <li><a href="<?php echo base_url('page/'.$ourCoreValues) ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Our Core Values</a></li>
                                <?php $about = get_data_by_id('slug','cc_pages','page_id','2'); ?>
                                <li><a href="<?php echo base_url('page/'.$about) ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    About Us</a></li>
                                <?php $privacy = get_data_by_id('slug','cc_pages','page_id','4'); ?>
                                <li><a href="<?php echo base_url('page/'.$privacy) ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Privacy Policy</a></li>
                                <?php $refunds = get_data_by_id('slug','cc_pages','page_id','12'); ?>
                                <li><a href="<?php echo base_url('page/'.$refunds) ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                        FAQ</a></li>
                                <?php $conditions = get_data_by_id('slug','cc_pages','page_id','5'); ?>
                                <li><a href="<?php echo base_url('page/'.$conditions) ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Terms & conditions</a></li>
                            </ul>
                        </div>                    
                    </div>
                    <div class="col-md-3 col-12">
                        <h4 class="f-title toggleButton">Extras</h4>
                        <div class="elementToToggle d-none d-md-block">
                            <ul class="list-unstyled ul-link mt-md-4">
                                <li><a href="<?php echo base_url('category/59') ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Brands</a></li>
                                <li><a href="<?php echo base_url('dashboard') ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    My Account</a></li>
                                <li><a href="<?php echo base_url('my_order'); ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Order History</a></li>
                                <li><a href="<?php echo base_url('favorite'); ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Wish List</a></li>
                                <?php $newsletter = get_data_by_id('slug','cc_pages','page_id','13'); ?>
                                <li><a href="<?php echo base_url('page/'.$newsletter) ?>">
                                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                    </svg>
                                    Newsletter</a></li>
                                <li><a href="<?php echo base_url('offers') ?>">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.11523 2.68945L4.32422 3.49805L9.82617 9L4.32422 14.502L5.11523 15.3105L11.4258 9L5.11523 2.68945ZM9.05273 2.68945L8.26172 3.49805L13.7637 9L8.26172 14.502L9.05273 15.3105L15.3633 9L9.05273 2.68945Z" fill="white"/>
                                        </svg>
                                        Offers</a></li>
                            </ul>
                        </div>                        
                    </div>
                    <?php $settings = get_settings();?>
                    <div class="col-md-3 col-12">
                        <h4 class="f-title toggleButton">Contact Us</h4>
                        <div class="elementToToggle d-none d-md-block">
                            <ul class="list-unstyled ul-link-2 mt-md-4">                                
                                <li class="d-flex fot-about">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"
                                            fill="none">
                                        <path d="M16.95 18C14.8 18 12.7043 17.5207 10.663 16.562C8.621 15.604 6.81267 14.3373 5.238 12.762C3.66267 11.1873 2.396 9.379 1.438 7.337C0.479334 5.29567 0 3.2 0 1.05C0 0.75 0.0999999 0.5 0.3 0.3C0.5 0.0999999 0.75 0 1.05 0H5.1C5.33333 0 5.54167 0.0749999 5.725 0.225C5.90833 0.375 6.01667 0.566667 6.05 0.8L6.7 4.3C6.73333 4.53333 6.72933 4.74567 6.688 4.937C6.646 5.129 6.55 5.3 6.4 5.45L3.975 7.9C4.675 9.1 5.55433 10.225 6.613 11.275C7.671 12.325 8.83333 13.2333 10.1 14L12.45 11.65C12.6 11.5 12.796 11.3873 13.038 11.312C13.2793 11.2373 13.5167 11.2167 13.75 11.25L17.2 11.95C17.4333 12 17.625 12.1123 17.775 12.287C17.925 12.4623 18 12.6667 18 12.9V16.95C18 17.25 17.9 17.5 17.7 17.7C17.5 17.9 17.25 18 16.95 18ZM3.025 6L4.675 4.35L4.25 2H2.025C2.10833 2.68333 2.225 3.35833 2.375 4.025C2.525 4.69167 2.74167 5.35 3.025 6ZM11.975 14.95C12.625 15.2333 13.2877 15.4583 13.963 15.625C14.6377 15.7917 15.3167 15.9 16 15.95V13.75L13.65 13.275L11.975 14.95Z"
                                            fill="#FFFFFF"/>
                                        </svg></span>
                                    <a href="tel:<?php echo $settings['phone']; ?>" class="f-text-add">(+1) <?php echo $settings['phone']; ?></a>
                                </li>

                                <li class="d-flex fot-about">
                                    <span><svg xmlns="http://www.w3.org/2000/svg" width="20" height="16" viewBox="0 0 20 16"
                                            fill="none">
                                        <path d="M20 2C20 0.9 19.1 0 18 0H2C0.9 0 0 0.9 0 2V14C0 15.1 0.9 16 2 16H18C19.1 16 20 15.1 20 14V2ZM18 2L10 7L2 2H18ZM18 14H2V4L10 9L18 4V14Z"
                                            fill="#FFFFFF"/>
                                        </svg></span>
                                    <a href="mailto:<?php echo $settings['email']; ?>" class="f-text-add"><?php echo $settings['email']; ?></a>
                                </li>

                                <li class="d-flex fot-about">
                                    <span> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="20" viewBox="0 0 16 20"
                                                fill="none">
                                        <path d="M8 10C8.55 10 9.021 9.804 9.413 9.412C9.80433 9.02067 10 8.55 10 8C10 7.45 9.80433 6.979 9.413 6.587C9.021 6.19567 8.55 6 8 6C7.45 6 6.97933 6.19567 6.588 6.587C6.196 6.979 6 7.45 6 8C6 8.55 6.196 9.02067 6.588 9.412C6.97933 9.804 7.45 10 8 10ZM8 17.35C10.0333 15.4833 11.5417 13.7873 12.525 12.262C13.5083 10.7373 14 9.38333 14 8.2C14 6.38333 13.4207 4.89567 12.262 3.737C11.104 2.579 9.68333 2 8 2C6.31667 2 4.89567 2.579 3.737 3.737C2.579 4.89567 2 6.38333 2 8.2C2 9.38333 2.49167 10.7373 3.475 12.262C4.45833 13.7873 5.96667 15.4833 8 17.35ZM8 20C5.31667 17.7167 3.31267 15.5957 1.988 13.637C0.662666 11.679 0 9.86667 0 8.2C0 5.7 0.804333 3.70833 2.413 2.225C4.021 0.741667 5.88333 0 8 0C10.1167 0 11.979 0.741667 13.587 2.225C15.1957 3.70833 16 5.7 16 8.2C16 9.86667 15.3377 11.679 14.013 13.637C12.6877 15.5957 10.6833 17.7167 8 20Z"
                                            fill="#FFFFFF"/>
                                    </svg> </span>
                                    <span class="f-text-add">
                                        <?php echo $settings['address']; ?>
                                    </span>
                                </li>    
                                <?php if(modules_key_by_access('contact_with_whatsapp') ==1){ $modulId = get_data_by_id('module_id','cc_modules','module_key','contact_with_whatsapp');?>
                                <li class="d-flex fot-about">
                                    <a target="_blank" href="https://wa.me/<?php echo get_model_settings_value_by_modelId_or_label($modulId, 'whatsapp_number');?>" ><span>
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#ffffff" width="20" height="20" version="1.1" id="Layer_1" viewBox="0 0 308 308" xml:space="preserve">
                                        <g id="XMLID_468_">
                                            <path id="XMLID_469_" d="M227.904,176.981c-0.6-0.288-23.054-11.345-27.044-12.781c-1.629-0.585-3.374-1.156-5.23-1.156   c-3.032,0-5.579,1.511-7.563,4.479c-2.243,3.334-9.033,11.271-11.131,13.642c-0.274,0.313-0.648,0.687-0.872,0.687   c-0.201,0-3.676-1.431-4.728-1.888c-24.087-10.463-42.37-35.624-44.877-39.867c-0.358-0.61-0.373-0.887-0.376-0.887   c0.088-0.323,0.898-1.135,1.316-1.554c1.223-1.21,2.548-2.805,3.83-4.348c0.607-0.731,1.215-1.463,1.812-2.153   c1.86-2.164,2.688-3.844,3.648-5.79l0.503-1.011c2.344-4.657,0.342-8.587-0.305-9.856c-0.531-1.062-10.012-23.944-11.02-26.348   c-2.424-5.801-5.627-8.502-10.078-8.502c-0.413,0,0,0-1.732,0.073c-2.109,0.089-13.594,1.601-18.672,4.802   c-5.385,3.395-14.495,14.217-14.495,33.249c0,17.129,10.87,33.302,15.537,39.453c0.116,0.155,0.329,0.47,0.638,0.922   c17.873,26.102,40.154,45.446,62.741,54.469c21.745,8.686,32.042,9.69,37.896,9.69c0.001,0,0.001,0,0.001,0   c2.46,0,4.429-0.193,6.166-0.364l1.102-0.105c7.512-0.666,24.02-9.22,27.775-19.655c2.958-8.219,3.738-17.199,1.77-20.458   C233.168,179.508,230.845,178.393,227.904,176.981z"/>
                                            <path id="XMLID_470_" d="M156.734,0C73.318,0,5.454,67.354,5.454,150.143c0,26.777,7.166,52.988,20.741,75.928L0.212,302.716   c-0.484,1.429-0.124,3.009,0.933,4.085C1.908,307.58,2.943,308,4,308c0.405,0,0.813-0.061,1.211-0.188l79.92-25.396   c21.87,11.685,46.588,17.853,71.604,17.853C240.143,300.27,308,232.923,308,150.143C308,67.354,240.143,0,156.734,0z    M156.734,268.994c-23.539,0-46.338-6.797-65.936-19.657c-0.659-0.433-1.424-0.655-2.194-0.655c-0.407,0-0.815,0.062-1.212,0.188   l-40.035,12.726l12.924-38.129c0.418-1.234,0.209-2.595-0.561-3.647c-14.924-20.392-22.813-44.485-22.813-69.677   c0-65.543,53.754-118.867,119.826-118.867c66.064,0,119.812,53.324,119.812,118.867   C276.546,215.678,222.799,268.994,156.734,268.994z"/>
                                        </g>
                                    </svg>
                                    </span>
                                    <span class="f-text-add">
                                        Contact With Whatsapp
                                    </span></a>
                                </li>      
                                <?php } ?>                      
                            </ul>
                        </div>
                        
                    </div>
    
                </div>
            </div>
        </div>
<!--        <div class="footer-social">-->
<!--            <div class="container text-center">-->
<!--                <a class="facebook" target="_blank" href="--><?php //echo $settings['fb_url']; ?><!--"><i-->
<!--                    class="fa-brands fa-facebook-f"></i></a>-->
<!--                <a class="ms-4 twitter" target="_blank" href="--><?php //echo $settings['twitter_url']; ?><!--"><i-->
<!--                            class="fa-brands fa-twitter"></i></a>-->
<!--                <a class="ms-4 tiktok" target="_blank" href="--><?php //echo $settings['tiktok_url']; ?><!--"><i-->
<!--                            class="fa-brands fa-tiktok"></i></a>-->
<!--                <a class="ms-4 instagram" target="_blank" href="--><?php //echo $settings['instagram_url']; ?><!--"><i-->
<!--                            class="fa-brands fa-instagram"></i></a>-->
<!--            </div>-->
<!--        </div>-->
        <div class="copyright">
            <div class="container">
                Copyright © Finerlabels 2015 | All Rights Reserved
            </div>
        </div>
    </section>



<script src="<?php echo base_url() ?>/assets/assets_fl/script.min.js"></script>
<script src="<?php echo base_url() ?>/assets/assets_fl/slick/slick.min.js" type="text/javascript" charset="utf-8"> </script>
<script src="<?php echo base_url() ?>/admin_assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo base_url() ?>/assets/assets_fl/datatable/datatables.min.js" ></script>


<script>

    function toggleDiv() {
        var div = document.getElementById("catBox");
        if (div.style.display === "none") {
            div.style.display = "block";
        } else {
            div.style.display = "none";
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        // Add a class to the body to indicate the page is loaded
        document.body.classList.add('loaded');
        const div = document.getElementById('catBox');
        const navbar = document.getElementById('menu-sticky');
        const navbarOffsetTop = navbar.offsetTop;
        window.addEventListener('scroll', function () {
            if (window.scrollY > navbarOffsetTop) {
                document.getElementById('menu-sticky').classList.add('fixed-top');
                // add padding top to show content behind navbar
                navbar_height = document.querySelector('#menu-sticky').offsetHeight;
                document.body.style.paddingTop = navbar_height + 'px';
                // div.style.display = "none";
            } else {
                document.getElementById('menu-sticky').classList.remove('fixed-top');
                // remove padding top from body
                document.body.style.paddingTop = '0';
                // div.style.display = "block";

            }
        });
    });

    const scrollToTopBtn = document.getElementById("scrollToTopBtn");

    window.onscroll = function () {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            scrollToTopBtn.classList.add("show");
        } else {
            scrollToTopBtn.classList.remove("show");
        }
    };

    scrollToTopBtn.addEventListener("click", function () {
        window.scrollTo({ top: 0, behavior: "smooth" });
    });

    new DataTable('#tableReload', { });

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4',
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),
    })

    //social chat script (start)
    var chatBtn = document.getElementById("message_social");
    chatBtn.addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
            content.style.display = "none";
        } else {
            content.style.display = "block";
        }
    });
    //social chat script (end)

    function watermark_image_download(condition){
        var activeImage = $('.slick-active').children().children().children('img').attr('src');
        if (condition == 'watermark') {
            var newName = activeImage.replace("437_wm_pro_", 'wm_');
        }else{
            var newName = activeImage.replace("437_wm_pro_", '');
        }
        var a = $("<a>").attr("href", newName).attr("download", "download_img.jpg").appendTo("body");
        a[0].click();
        a.remove();
        $('.dw-btn-group').hide();
    }



    function myFunction() {
        var dots = document.getElementById("dots");
        var moreText = document.getElementById("more");
        var btnText = document.getElementById("myBtn");

        if (dots.style.display === "none") {
            dots.style.display = "inline";
            btnText.innerHTML = "See more";
            moreText.style.display = "none";
        } else {
            dots.style.display = "none";
            btnText.innerHTML = "See less";
            moreText.style.display = "inline";
        }
    }

    $('.slider-for').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        fade: true,
        asNavFor: '.slider-nav'
    });
    $('.slider-nav').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        vertical: true,
        asNavFor: '.slider-for',
        dots: false,
        focusOnSelect: true,
        verticalSwiping: true,
        responsive: [{
                breakpoint: 992,
                settings: {
                    vertical: true,
                    slidesToShow: 5,
                }
            },
            {
                breakpoint: 768,
                settings: {
                    vertical: true,
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 575,
                settings: {
                    vertical: true,
                    slidesToShow: 4,
                }
            },
            {
                breakpoint: 400,
                settings: {
                    vertical: true,
                    slidesToShow: 5
                }
            }
        ]
    });
</script>
<script>

    
     function addToCompare(pro_id) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('addtoCompare') ?>",
            data: {
                product_id: pro_id
            },
            success: function(response) {
                $('#mesVal').html(response);
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
            }
        });
    }

    function removeToCompare(key_id) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('removeToCompare') ?>",
            data: {
                key_id: key_id
            },
            success: function(response) {
                $('#compReload').load(location.href + " #compReload");
                $('#mesVal').html(response);
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
            }
        });
    }

    function addToWishlist(pro_id) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('addtoWishlist') ?>",
            data: {
                product_id: pro_id
            },
            success: function(response) {
                $('#mesVal').html(response);
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
            }
        });
    }

    function removeToWishlist(proId) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('removeToWishlist') ?>",
            data: {
                product_id: proId
            },
            success: function(response) {
                $('#reloadDiv').load(location.href + " #reloadDiv");
                $('#mesVal').html(response);
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
            }
        });
    }



    function addToCart(pro_id) {
        var size = $("input[name='size']:checked").val();
        var color = $("input[name='color']:checked").val();

        $.ajax({
            method: "POST",
            url: "<?php echo base_url('checkoption') ?>",
            data: {
                product_id: pro_id
            },
            success: function(response) {
                if (response == true) {
                    adtocartAction(pro_id);
                } else {
                    if (size == null || color == null) {
                        $('.mes-1').html('Required field');
                        $('.mes-2').html('Required field');
                    } else {
                        $('.mes-1').html('');
                        $('.mes-2').html('');
                        adtocartAction(pro_id);
                    }
                }
            }
        });
    }

    function adtocartAction(pro_id) {
        var qty = $('#qty_input').val();
        if (qty == null) {
            qty = '1';
        }
        var size = $("input[name='size']:checked").val();
        if (size == null) {
            size = '';
        }
        var color = $("input[name='color']:checked").val();
        if (color == null) {
            color = '';
        }
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('addtocart') ?>",
            data: {
                product_id: pro_id,
                qtyall: qty,
                size: size,
                color: color
            },
            success: function(response) {
                $('#cartReload').load(location.href + " #cartReload");
                $('#cartReload2').load(location.href + " #cartReload2");
                $('#mesVal').html(response);
                $('.btn-count').load(location.href + " .btn-count");
                $('.body-count').load(location.href + " .body-count");
                $('#carticon2').css('transform', 'rotate(90deg)');
                $('#collapseExample').addClass('show');
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
            }
        });
    }

    // function addToCartdetail() {

        $("#addto-cart-form").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $('#cartReload').load(location.href + " #cartReload");
                    $('#cartReload2').load(location.href + " #cartReload2");
                    $('#mesVal').html(response);
                    $('.btn-count').load(location.href + " .btn-count");
                    $('.body-count').load(location.href + " .body-count");
                    $('#carticon2').css('transform', 'rotate(90deg)');
                    $('#collapseExample').addClass('show');
                    $('.message_alert').show();
                    setTimeout(function() {
                        $("#messAlt").fadeOut(1500);
                    }, 600);

                }
            });
        }));

    // };

    function checkoption(pro_id) {
        var result;
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('checkoption') ?>",
            data: {
                product_id: pro_id
            },
            success: function(response) {
                result = response;
            }
        });
        return result;
    }



    function minusItem(rowid) {
        var quantity = parseInt($('.item_' + rowid).val());
        if (quantity > 1) {
            $('.item_' + rowid).val(quantity - 1);
        }
        $('#btn_' + rowid).show();
    }

    function plusItem(rowid) {
        var quantity = parseInt($('.item_' + rowid).val());
        $('.item_' + rowid).val(quantity + 1);
        $('#btn_' + rowid).show();

    }

    function updateQty(rowid) {
        var qty = $('.item_' + rowid).val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('updateToCart') ?>",
            data: {
                rowid: rowid,
                qty: qty
            },
            dataType: 'json',
            success: function(response) {
                $('#cartReload').load(location.href + " #cartReload");
                $('#tableReload').load(location.href + " #tableReload");
                $('#tableReload2').load(location.href + " #tableReload2");
                $('#cartReload2').load(location.href + " #cartReload2");
                $('#mesVal').html(response.message);
                $('.btn-count').load(location.href + " .btn-count");
                $('.body-count').load(location.href + " .body-count");
                $('#collapseExample').addClass('show');
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
                $('#btn_' + rowid).hide();
                // checkout_data_calculate(response.cartTotal);
                shippingCharge(response.cartTotal);
            }
        });
    }

    function removeCart(rowid,div) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('removeToCart') ?>",
            data: {
                rowid: rowid
            },
            success: function(response) {
                $('#cartReload').load(location.href + " #cartReload");
                $('#cartReload2').load(location.href + " #cartReload2");
                $('#tableReload').load(location.href + " #tableReload");
                $('#tableReload2').load(location.href + " #tableReload2");
                $('#mesVal').html('Successfully remove to cart');
                $('.btn-count').load(location.href + " .btn-count");
                $('.body-count').load(location.href + " .body-count");
                $('#collapseExample').addClass('show');
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
                // checkout_data_calculate(response);
                shippingCharge(response);
                $(div).parent().parent().remove();

                $.ajax({
                    method: "GET",
                    url: "<?php echo base_url('cart_empty_check') ?>",
                    data: {},
                    success: function(result) {
                        if (result == false){
                            location.reload();
                        }
                    }
                });
            }
        });
    }

    function checkout_data_calculate(data){
        <?php $symbol = $settings['currency_symbol']; ?>

        var total = Number(data);

        $('#check_total').html('<?php echo $symbol ?>'+ total );
        $('#totalamo').val(total);

        var shipping_charge = $('#shipping_charge').val();
        var total_with_shipping = Number(total) + Number(shipping_charge);

        $('#total').html('<?php echo $symbol; ?> ' + total_with_shipping);
        $('#shipping_tot').val(total_with_shipping);
    }


    function pass_show(val) {
        var html = `<h6 class="mt-2">Change information</h6><div class="form-group mt-4"><label>Current password</label><input type="password" name="current_password" id="current_password" class="form-control in_err fw-bolder" placeholder="Current password" required><span class="text-danger d-inline-block err text-capitalize" id="password_err_mess"></span></div><div class="form-group "><label>New password</label><input type="password" name="new_password" class="form-control in_err fw-bolder" id="new_password" placeholder="New password" required><span class="text-danger d-inline-block err text-capitalize mb-4" id="new_password_err_mess"></span></div><div class="form-group "><label>Confirm password</label><input type="password" name="confirm_password" class="form-control in_err fw-bolder" id="confirm_password" placeholder="Confirm password" required> <span class="text-danger d-inline-block err text-capitalize mb-4" id="confirm_password_err_mess"></span></div>`;
        
        if (val == '1') {
            $('#passReset').val(0);
            $('#pass-data').html(html);
        } else {
            $('#passReset').val(1);
            $('#pass-data').html('');
        }
    }

    function selectState(country_id, id) {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('checkout_country_zoon') ?>",
            data: {
                country_id: country_id
            },
            success: function(data) {
                $('#' + id).html(data);
            }
        });
    }

    function user_create() {

        var createNew = $('#createNew').val();
        var html =
            '<div class="row"><div class="col-lg-6"><div class="form-group mb-4"><label class="w-100" for="password">Password</label><input class="form-control rounded-0" type="password" name="password" id="password" placeholder="Password"  required></div></div> <div class="col-lg-6"><div class="form-group mb-4"><label class="w-100" for="password">Confirm Password</label><input class="form-control rounded-0" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"  required></div></div></div>'
        if (createNew == 0) {
            $('#createNew').val(1);
            $('#regData').html(html);
        } else {
            $('#createNew').val(0);
            $('#regData').html('');
        }
    }


    function shippingCharge(tA) {
        var paymethod = $('#shipping_method:checked').val();
        var cityId = $('#stateView').val();
        if (tA == undefined) {
            var totalAmount = $('#totalamo').val();
        }else{
            var totalAmount = tA;
        }
        var shipcityId = $('#sh_stateView').val();


        $('#totalamo').val(totalAmount);
        $('#total').html('<?php echo $symbol; ?> ' + totalAmount);

        <?php $symbol = $settings['currency_symbol']; ?>
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('shipping_rate') ?>",
            data: {
                amount: totalAmount,
                city_id: cityId,
                shipCityId: shipcityId,
                paymethod: paymethod
            },
            dataType: 'json',
            success: function(result) {
                var charge = Number(result.charge);

                var dis = Number(result.discount);

                var total = Number(totalAmount);
                var amount = Number(total) + Number(charge) - dis;

                $('#discount_charge').val(dis);
                $('#chargeDisSh').html('<?php echo $symbol; ?> ' + dis);
                $('#chargeShip').html('<?php echo $symbol; ?> ' + result.charge);
                $('#total').html('<?php echo $symbol; ?> ' + parseFloat(amount.toFixed(2)));
                $('#totalamo').val(total);
                $('#shipping_charge').val(charge);
                $('#shipping_tot').val(parseFloat(amount.toFixed(2)));
                if (amount < 0){
                    $('#orderBtn').hide();
                    $('#wMessage').show();
                }else{
                    $('#orderBtn').show();
                    $('#wMessage').hide();
                }
            }
        });
    }

    function viewStyle(view) {
        if (view == 'list') {
            $("#list-btn").addClass('active-view');
            $("#gird-btn").removeClass('active-view');
            $("#grid-view").hide();
            $("#list-view").show();
        }
        if (view == 'gird') {
            $("#gird-btn").addClass('active-view');
            $("#list-btn").removeClass('active-view');
            $("#grid-view").show();
            $("#list-view").hide();
        }
    }

    function formSubmit() {
        $("#searchForm").submit();
    }

    function subscription() {
        var val = 'unchecked';
        var checkBox = document.getElementById("flexCheckDefault");

        if (checkBox.checked) {
            val = 'checked';
        }

        $.ajax({
            method: "POST",
            url: "<?php echo base_url('newsletter_action'); ?>",
            data: { value: val },
            success: function(response) {
                $("#message").html(response);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", error);
                alert("Something went wrong!");
            }
        });

    }

    function bothPriceCalculat() {

        var formData = $('#both-product').serialize();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url('both_product_price') ?>',
            data: formData,
            success: function(data) {
                $('#price-both').html(data);
            }
        });
    }

    function groupAdtoCart() {
        var formData = $('#both-product').serialize();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('addtocartgroup') ?>",
            data: formData,
            success: function(response) {
                $('#cartReload').load(location.href + " #cartReload");
                $('#cartReload2').load(location.href + " #cartReload2");
                $('#mesVal').html(response);
                $('.btn-count').load(location.href + " .btn-count");
                $('.body-count').load(location.href + " .body-count");
                $('#collapseExample').addClass('show');
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
            }
        });
    }

    function subscribe(emailID) {
        var email = $('#'+emailID).val();

        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

        if (!emailRegex.test(email)) {
            $('#mesVal').html('Email required');
            $('.message_alert').show();
            setTimeout(function() {
                $("#messAlt").fadeOut(1500);
            }, 600);
        } else {
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('user_subscribe') ?>",
                data: {
                    email: email
                },
                success: function(response) {
                    $('#'+emailID).val('');
                    $('#mesVal').html(response);
                    $('.message_alert').show();
                    $('.dw-input-group').hide();
                    $('.dw-btn-group').hide();
                    setTimeout(function() {
                        $("#messAlt").fadeOut(1500);
                    }, 600);
                }
            });
        }
    }

    function optionPriceCalculate(product_id) {
        <?php foreach (get_all_data_array('cc_option') as $v) {
            $fildName = str_replace(' ','',$v->name);
            if ($v->type == 'radio') { ?>
                var <?php echo strtolower($fildName); ?> = $('input[name="<?php echo strtolower($fildName); ?>"]:checked').val();
            <?php }
            if ($v->type == 'select') { ?>
                var <?php echo strtolower($fildName); ?> = $('[name="<?php echo strtolower($fildName); ?>"]').val();
        <?php }
        } ?>
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('optionPriceCalculate') ?>",
            data: {
                product_id: product_id,
                <?php foreach (get_all_data_array('cc_option') as $vl) { $fildName2 = str_replace(' ','',$vl->name); ?>
                    <?php echo strtolower($fildName2); ?>: <?php echo strtolower($fildName2); ?>,
                <?php } ?>
            },
            success: function(data) {
                $('#priceVal').html(data);
            }
        });
    }

    function video_close() {
        $("#sample_video")[0].src += "?autoplay=0";
    }

    function topSearchValidation(formId, catId, keyId, validId) {

        var cat = $('#' + catId).val();
        var key = $('#' + keyId).val();

        if ((cat == '') && (key == '')) {
            $('#' + validId).css('border', '1px solid #ff0000');
            $('#' + keyId).attr("placeholder", "Please type something to search....");
        } else {
            $('#' + formId).submit();
        }

        // border: 1px solid red;
    }

    function livenameView(newVal, viewId) {
        var f = $('#fname').val();
        var l = $('#lname').val();
        $('#' + viewId).html(f + ' ' + l);
    }

    function livename1View(newVal, viewId) {
        var f = $('#fname1').val();
        var l = $('#lname1').val();
        $('#' + viewId).html(f + ' ' + l);
    }

    function liveTextView(newVal, viewId) {

        $('#' + viewId).html(newVal);

    }

    function liveView(val, viewId) {
        // var data = $(val).attr(option);
        var data = $(val).find('option:selected').html();
        $('#' + viewId).html(data);
    }


    $(document).ready(function() {
        $('.toggleButton').click(function() {
            $(this).toggleClass('active');
            $(this).siblings('.elementToToggle').slideToggle();
            $(this).siblings('.elementToToggle').removeClass('d-none');
        });
    });



    var btnCartElements = document.getElementsByClassName('btn-cart');
    // Get the Mini Cart element
    var miniCart = document.getElementById('miniCart');
    for (var i = 0; i < btnCartElements.length; i++) {
        var btnCartElement = btnCartElements[i];
        btnCartElement.addEventListener('click', function() {
            // Show the Mini Cart
            miniCart.classList.add('show');
            setTimeout(function() {
                miniCart.classList.remove('show');
            }, 5000);
        });
    }

    function instruction_view(id, code) {
        if (code == 'paypal') {
            $('#checkout-form').attr('action', '<?php echo base_url('payment_paypal'); ?>');
            $('#checkout-form').attr('method', 'GET');
        }else if(code == 'stripe'){
            $('#checkout-form').attr('action', '<?php echo base_url('payment_stripe'); ?>');
            $('#checkout-form').attr('method', 'POST');
        }else if(code == 'oisbizcraft'){
            $('#checkout-form').attr('action', '<?php echo base_url('payment_oisbizcraft'); ?>');
            $('#checkout-form').attr('method', 'POST');
        } else {
            $('#checkout-form').attr('action', '<?php echo base_url('checkout_action'); ?>');
            $('#checkout-form').attr('method', 'POST');
        }
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('payment_instruction') ?>",
            data: {
                id: id
            },
            success: function(response) {
                $('#instruction').html(response);
                if (code != 'credit_card') {
                    $('#cardForm').html('');
                }
            }
        });
    }

    function cardForm(code) {
        var view =
            '<div class="title-checkout"><label class="btn bg-custom-color text-white w-100 rounded-0"><span class="text-label">Credit Card</span></label></div><div class="payment-method group-check mb-4 pb-4"><div class="row px-5 py-2"><div class="form-group mb-4 col-md-12"><label class="w-100" for="name">Card Name</label><input class="form-control rounded-0" type="text" id="card_name" name="card_name" placeholder="" required=""></div><div class="form-group mb-4 col-md-12"><label class="w-100" for="name">Card Number</label><input class="form-control rounded-0" type="number" id="card_number" name="card_number" placeholder="" required=""></div><div class="form-group mb-4 col-md-6"><label class="w-100" for="name">Expiration (mmyy)</label><input class="form-control rounded-0" type="text"   id="card_expiration" name="card_expiration" placeholder="" required="" pattern="[0-9]*" inputmode="numeric"></div><div class="form-group mb-4 col-md-6"><label class="w-100" for="name">CVC</label><input class="form-control rounded-0" type="number" id="card_cvc" name="card_cvc" placeholder="" required=""></div></div></div>';
        if (code == 'credit_card') {
            $('#cardForm').html(view);
        }
    }

    function contactFormSubmit(){
        if (contactForm() == true) {

            let inputcaptchavalue = $('#captcha_form').val();
            let captchaValue = $('#genaretCapt').val();
            if (inputcaptchavalue === captchaValue) {

                let email = $('#email').val();
                let message = $('#message').val();

                $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('contact_form_action') ?>",
                    data: {
                        email: email,
                        message: message,
                    },
                    success: function (response) {
                        // alert(response);
                        $('#email').val('');
                        $('#message').val('');
                        $('#mesVal').html('Your message was successfully submitted');
                        $('.message_alert').show();
                        setTimeout(function () {
                            $("#messAlt").fadeOut(1500);
                        }, 600);
                        location.reload();
                    }
                })
            } else {
                error("#messageRecaptcha", "Please Enter Valid Captcha");
                return false;
            }
        }
    }






    function download_btn_show(){
        $('.dw-btn-group').show();
    }
    function show_form(){
        $('.dw-input-group').show();
    }



    //QC Pictures query(start)
    function submitQueryForm(){
        var email = $('#email').val();
        var albumId = $('#album_id').val();
        if (email == ''){
            $('#errMss').html('Please input email');
        }else {
             if (validateEmail(email) == true ) {
                 submitQueryQcpictures(email,albumId);
             }else {
                 $('#errMss').html('Please input valid email');
             }
        }
    }

     function validateEmail($email) {
         var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
         return emailReg.test( $email );
     }

    function submitQueryQcpictures(email,albumId){
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('qc-picture-query') ?>",
            data: {
                email: email,
                album_id: albumId,
            },
            success: function (response) {
                $('#email').val('');
                $('#queryModal').modal('hide');
                $('#mesVal').html(response);
                $('.message_alert').show();
                setTimeout(function() {
                    $("#messAlt").fadeOut(1500);
                }, 600);
            }
        });
    }
    //QC Pictures query(end)


     function album_download_btn_show(proId){
         $('.album-btn-group_'+proId).show();
     }

     function show_form_alb(proId){
         $('.album-btn-group_form_'+proId).show();
         $('.album-btn-group_'+proId).hide();
     }

     function album_watermark_image_download(condition,imgId){

         var activeImage = $('#'+imgId).attr('src');

         if (condition == 'watermark') {
             var newName = activeImage.replace("261_wm_pro_", 'wm_');
         }else{
             var newName = activeImage.replace("261_wm_pro_", '');
         }
         var a = $("<a>").attr("href", newName).attr("download", "download_img.jpg").appendTo("body");
         a[0].click();
         a.remove();
         $('.btn-group-al').hide();
     }

     function subscribe_album(emailID,proId) {
         var email = $('#'+emailID+proId).val();

         var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;

         if (!emailRegex.test(email)) {
             $('#mesVal').html('Email required');
             $('.message_alert').show();
             setTimeout(function() {
                 $("#messAlt").fadeOut(1500);
             }, 600);
         } else {
             $.ajax({
                 method: "POST",
                 url: "<?php echo base_url('user_subscribe') ?>",
                 data: {
                     email: email
                 },
                 success: function(response) {
                     $('#'+emailID+proId).val('');
                     $('#mesVal').html(response);
                     $('.message_alert').show();
                     $('.album-btn-group_form_'+proId).hide();
                     $('.album-btn-group_'+proId).hide();
                     setTimeout(function() {
                         $("#messAlt").fadeOut(1500);
                     }, 600);
                 }
             });
         }
     }

     $('#commentForm').on('submit', function(event) {
         event.preventDefault();
         $.ajax({
             url: $(this).attr('action'),
             type: "POST",
             data: new FormData(this),
             contentType: false,
             cache: false,
             processData: false,
             success: function(response) {
                 $('#commentForm')[0].reset();
                 $('#mesVal').html(response);
                 $('#commentBoxReload').load(document.URL + ' #commentBoxReload');
                 $('.message_alert').show();
                 setTimeout(function() {
                     $("#messAlt").fadeOut(1500);
                 }, 600);

             }
         });
     });

    function commentReply(show,id){
        var formID = "'commentReply_" + id+"'" ;
        var html = '<form id="commentReply_'+id+'" action="<?php echo base_url('blog-comment-reply-action')?>" method="post"><div class="d-flex" > <input type="hidden" name="comment_id" class="comment_id" value="'+id+'" required> <input type="text" name="com_name" placeholder="Name" class="input-c" required> <input type="text" name="com_email" placeholder="Email" class="input-c"> </div> <div class="mt-1"> <input type="text" name="com_text" placeholder="Text" class="input-c input-te" required> <br><button type="button" class="btn btn-reply mt-1" onclick="commentReplyAction('+formID+')" >Reply  Comment</button> </div></form>';
        $("#"+show).html(html);
    }



    function commentReplyAction(formID){
        var form = document.getElementById(formID);
        $.ajax({
            url: $(form).prop('action'),
            type: "POST",
            data: new FormData(form),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#'+formID)[0].reset();
                $('#'+formID).hide();
                $('#commentBoxReload').load(document.URL + ' #commentBoxReload');
                $('#mesVal').html(response);
                $('.message_alert').show();
                setTimeout(function () {
                    $("#messAlt").fadeOut(1500);
                }, 600);

            }
        });
    }

</script>

<script src="<?php echo base_url() ?>/assets/assets_fl/validation.min.js " type="text/javascript"> </script>
</body>
</html>