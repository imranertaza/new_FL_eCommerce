<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>
    <meta name="description" content="<?php echo $description;?>">
    <meta name="keywords" content="<?php echo $keywords;?>">

    <link rel="shortcut icon" href="<?php echo base_url() ?>/uploads/logo/<?php echo get_lebel_by_value_in_theme_settings('favicon');?>">

    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/assets_fl/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/assets_fl/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/assets_fl/slick/slick.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/assets_fl/slick/slick-theme.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="<?php echo base_url() ?>/assets/assets_fl/style.min.css">

    <script src="<?php echo base_url() ?>/assets/assets_fl/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/assets_fl/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/assets_fl/swiper-bundle.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/assets_fl/jquery.star-rating.min.js"></script>
    <script src="<?php echo base_url() ?>/assets/assets_fl/jquery-ui.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;700&display=swap" rel="stylesheet">

<!--    <script src="https://www.google.com/recaptcha/api.js" async defer></script>-->



</head>
<body>
    <div class="message_alert" id="messAlt">
        <div class="alert-success_web py-2 px-3 border-0 text-white fs-5 text-capitalize" id="mesVal">
            <?php print 'Successfully update to cart'; ?> </div>
    </div>
    <?php
        $settings = get_settings();
        $modules = modules_access();
    ?>
    <header class="header bg-white">
        <div class="topbar py-1 py-md-3">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-sm-4 col-md-7 d-flex flex-row align-items-center justify-content-center gap-3 mb-2 mb-sm-0">
                        <div class="currency-switcher">
                            <div class="input-group">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="currencyDropdown"><?php echo get_lebel_by_value_in_settings('currency_symbol'); ?> <?php echo get_lebel_by_value_in_settings('currency'); ?></button>
                                <!-- <ul class="dropdown-menu"> -->
                                    <!-- <li><a class="dropdown-item" href="#" data-currency="USD">USD</a></li> -->
                                    <!-- <li><a class="dropdown-item" href="#" data-currency="GBP">GBP</a></li>
                                    <li><a class="dropdown-item" href="#" data-currency="EUR">EUR</a></li> -->
                                <!-- </ul> -->
                            </div>
                        </div>
                        <div class="vr"></div>
                        <div class="top-tel d-flex flex-sm-column flex-md-row gap-2">                            
                            <a href="tel:<?php echo $settings['phone']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 18 18" fill="none">
                                    <path d="M16.95 18C14.8 18 12.7043 17.5207 10.663 16.562C8.621 15.604 6.81267 14.3373 5.238 12.762C3.66267 11.1873 2.396 9.379 1.438 7.337C0.479334 5.29567 0 3.2 0 1.05C0 0.75 0.0999999 0.5 0.3 0.3C0.5 0.0999999 0.75 0 1.05 0H5.1C5.33333 0 5.54167 0.0749999 5.725 0.225C5.90833 0.375 6.01667 0.566667 6.05 0.8L6.7 4.3C6.73333 4.53333 6.72933 4.74567 6.688 4.937C6.646 5.129 6.55 5.3 6.4 5.45L3.975 7.9C4.675 9.1 5.55433 10.225 6.613 11.275C7.671 12.325 8.83333 13.2333 10.1 14L12.45 11.65C12.6 11.5 12.796 11.3873 13.038 11.312C13.2793 11.2373 13.5167 11.2167 13.75 11.25L17.2 11.95C17.4333 12 17.625 12.1123 17.775 12.287C17.925 12.4623 18 12.6667 18 12.9V16.95C18 17.25 17.9 17.5 17.7 17.7C17.5 17.9 17.25 18 16.95 18ZM3.025 6L4.675 4.35L4.25 2H2.025C2.10833 2.68333 2.225 3.35833 2.375 4.025C2.525 4.69167 2.74167 5.35 3.025 6ZM11.975 14.95C12.625 15.2333 13.2877 15.4583 13.963 15.625C14.6377 15.7917 15.3167 15.9 16 15.95V13.75L13.65 13.275L11.975 14.95Z" fill="#939393"></path>
                                </svg>  
                            </a>
                            <a class="d-none d-md-block" href="tel:<?php echo $settings['phone']; ?>"> <?php echo $settings['phone']; ?></a>
                        </div>
                        <div class="vr"></div>
                        <div class="top-email d-flex flex-sm-column flex-md-row gap-2">
                            <a href="tel:<?php echo $settings['email']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 20 16" fill="none">
                                    <path d="M20 2C20 0.9 19.1 0 18 0H2C0.9 0 0 0.9 0 2V14C0 15.1 0.9 16 2 16H18C19.1 16 20 15.1 20 14V2ZM18 2L10 7L2 2H18ZM18 14H2V4L10 9L18 4V14Z" fill="#939393"></path>
                                </svg>
                            </a>
                            <a class="d-none d-md-block" href="tel:<?php echo $settings['email']; ?>">Email: <?php echo $settings['email']; ?></a>
                        </div>
                    </div>
                    <div class="col-12 col-sm-8 col-md-5 d-flex gap-3 justify-content-center justify-content-sm-end mb-2 mb-sm-0"> 
                    <?php if (!isset(newSession()->isLoggedInCustomer)) { ?>                       
                        <a class="btn" href="<?php echo base_url('login') ?>">Sign In</a>
                        <a class="btn btn-create px-4 py-2" href="<?php echo base_url('register') ?>">Create An Account</a>
                        <?php } else { ?>
                            
                                <a class="dropdown-toggle btn btn-create" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    My Account
                                </a>
                                <ul class="dropdown-menu ">
                                    <li><a class="dropdown-item mt-2 mb-2 " href="<?php echo base_url('dashboard') ?>">Dashboard</a></li>
                                    <li><a href="<?php echo base_url('profile'); ?>" class="dropdown-item mt-2 mb-2">Profile</a></li>
                                    <li><a href="<?php echo base_url('my_order'); ?>" class="dropdown-item mt-2 mb-2">My Order</a></li>
                                    <?php if ($modules['wishlist'] == 1) { ?>
                                    <li><a href="<?php echo base_url('favorite'); ?>" class="dropdown-item mt-2 mb-2">My Wish List</a></li>
                                    <?php } ?>
                                    <li><a href="<?php echo base_url('logout'); ?>" class="dropdown-item mt-2 mb-2">Logout</a></li>
                                </ul>
                            
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-main py-1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12 col-sm-4 col-lg-3 order-1 mb-3 mb-sm-0">
                        <div class="logo text-center text-sm-start">
                        <a href="<?php echo base_url() ?>">
                                <?php $logoImg = get_lebel_by_value_in_theme_settings('side_logo');
                                echo image_view('uploads/logo', '', $logoImg, 'noimage.png', 'img-fluid side_logo'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-7 order-3 order-lg-2">
                        <nav class="navbar-primary navbar navbar-expand-lg justify-content-end">
                            <button class="navbar-toggler" id="navbarPopUp" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="collapse navbar-collapse" id="navbarNav">
                                <button type="button" class="btn-close d-lg-none" id="navClose" aria-label="Close"></button>
                                <ul class="navbar-nav d-flex justify-content-center">
                                  <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="<?php echo base_url() ?>">Home</a>
                                  </li>
                                  <?php echo top_menu(); ?>
                                  <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url('page/about-us') ?>">About Us</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" href="<?php echo base_url('page/contact-us') ?>">Contact Us</a>
                                  </li>
                                </ul>
                              </div>
                          </nav>
                    </div>
                    <div class="col-6 col-sm-4 col-lg-2 order-2 order-lg-3 d-flex justify-content-sm-end">
                        <div class="help-center d-flex align-items-center gap-2">                                                       
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.95 18C12.3 18 12.596 17.879 12.838 17.637C13.08 17.395 13.2007 17.0993 13.2 16.75C13.2 16.4 13.0793 16.104 12.838 15.862C12.5967 15.62 12.3007 15.4993 11.95 15.5C11.6 15.5 11.3043 15.621 11.063 15.863C10.8217 16.105 10.7007 16.4007 10.7 16.75C10.7 17.1 10.821 17.396 11.063 17.638C11.305 17.88 11.6007 18.0007 11.95 18ZM11.05 14.15H12.9C12.9 13.6 12.9627 13.1667 13.088 12.85C13.2133 12.5333 13.5673 12.1 14.15 11.55C14.5833 11.1167 14.925 10.704 15.175 10.312C15.425 9.92 15.55 9.44933 15.55 8.9C15.55 7.96667 15.2083 7.25 14.525 6.75C13.8417 6.25 13.0333 6 12.1 6C11.15 6 10.379 6.25 9.787 6.75C9.195 7.25 8.78267 7.85 8.55 8.55L10.2 9.2C10.2833 8.9 10.471 8.575 10.763 8.225C11.055 7.875 11.5007 7.7 12.1 7.7C12.6333 7.7 13.0333 7.846 13.3 8.138C13.5667 8.43 13.7 8.75067 13.7 9.1C13.7 9.43333 13.6 9.746 13.4 10.038C13.2 10.33 12.95 10.6007 12.65 10.85C11.9167 11.5 11.4667 11.9917 11.3 12.325C11.1333 12.6583 11.05 13.2667 11.05 14.15ZM12 22C10.6167 22 9.31667 21.7373 8.1 21.212C6.88333 20.6867 5.825 19.9743 4.925 19.075C4.025 18.175 3.31267 17.1167 2.788 15.9C2.26333 14.6833 2.00067 13.3833 2 12C2 10.6167 2.26267 9.31667 2.788 8.1C3.31333 6.88333 4.02567 5.825 4.925 4.925C5.825 4.025 6.88333 3.31267 8.1 2.788C9.31667 2.26333 10.6167 2.00067 12 2C13.3833 2 14.6833 2.26267 15.9 2.788C17.1167 3.31333 18.175 4.02567 19.075 4.925C19.975 5.825 20.6877 6.88333 21.213 8.1C21.7383 9.31667 22.0007 10.6167 22 12C22 13.3833 21.7373 14.6833 21.212 15.9C20.6867 17.1167 19.9743 18.175 19.075 19.075C18.175 19.975 17.1167 20.6877 15.9 21.213C14.6833 21.7383 13.3833 22.0007 12 22ZM12 20C14.2333 20 16.125 19.225 17.675 17.675C19.225 16.125 20 14.2333 20 12C20 9.76667 19.225 7.875 17.675 6.325C16.125 4.775 14.2333 4 12 4C9.76667 4 7.875 4.775 6.325 6.325C4.775 7.875 4 9.76667 4 12C4 14.2333 4.775 16.125 6.325 17.675C7.875 19.225 9.76667 20 12 20Z" fill="#F90643"/>
                            </svg>    
                            <a href="<?php echo base_url('page/need-help')?>">Need Help?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-bottom py-2">
            <div class="container">
                <div class="row gx-0 align-items-center">
                    <div class="col-xl-3 col-lg-3 col-sm-3 col-12 mb-2 mb-sm-0">
                    <?php if (isset($home_menu)) {  ?>
                        <div class="allcategory h-100 w-100">
                            <button class="btn btn-secondary text-uppercase dropdown-toggle rounded-0 h-100 bg-blue border-0 text-start w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars me-3"></i>
                                Shop by Categories
                            </button>


                            <!--category start-->
                            <div class="dropdown-menu border accordion-cat cat-drop-menu all-cat-menu btn-cat-show " id="catBox">
                                <div class="accordion">
                                    <?php foreach (getSideMenuArray() as $pcat) { ?>

                             <!--single-->
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header" id=<?="panelsStayOpen-heading-".$pcat->prod_cat_id?> >
                                            <a href="<?php echo base_url('category/' . $pcat->prod_cat_id); ?>" class="accordion-button collapsed py-2 px-2">
                                                <span>
                                                    <svg class="svgIcon-accordion" width="auto" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect width="24" height="24" fill="white"/>
                                                    <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>

                                                </span>
                                                <span><?php echo $pcat->category_name; ?></span>
                                                <?php $pCatAr = getCategoryBySubArray($pcat->prod_cat_id); if (!empty(count($pCatAr))) { ?>
                                                <button class="btn ms-auto button-collapse py-2 collappse-btn"
                                                    id="<?="accordionPanelsStayOpen-".$pcat->prod_cat_id?>" type="button" data-bs-toggle="collapse"
                                                    data-bs-target= <?="#panelsStayOpen-collapse-".$pcat->prod_cat_id?> aria-expanded="false"
                                                    aria-controls=<?="panelsStayOpen-collapse-".$pcat->prod_cat_id?>>
                                                </button>
                                                <?php }?>

                                            </a>
                                        </h2>
                                        <div id="<?="panelsStayOpen-collapse-".$pcat->prod_cat_id?>" class="accordion-collapse collapse"
                                            aria-labelledby=<?="panelsStayOpen-heading-".$pcat->prod_cat_id?> >
                                           
                                            <?php if (!empty(count($pCatAr))) { ?>
                                                <div class="accordion-body p-0">
                                                <?php foreach ($pCatAr as $sCat) { ?>
                                                    <div class="accordion-item border-0">
                                                        <h2 class="accordion-header" id="<?="panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-heading".$sCat->prod_cat_id?>">
                                                            <a href=<?php echo base_url('category/' . $sCat->prod_cat_id); ?> class="accordion-button collapsed py-2 px-2 pl-20">
                                                            <span>
                                                                <svg class="svgIcon-accordion" width="auto" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="24" height="24" fill="white"/>
                                                                <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                                </svg>
                                                            </span>
                                                                <span> <?php echo $sCat->category_name; ?></span>
                                                                <?php $sCatAr = getCategoryBySubArray($sCat->prod_cat_id); if (!empty(count($sCatAr))) { ?>
                                                                <button class="btn ms-auto button-collapse py-2 collappse-btn"
                                                                    id= "<?="accordionPanelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-heading".$sCat->prod_cat_id?>" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target=<?="#panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-collapse".$sCat->prod_cat_id?> aria-expanded="false"
                                                                    aria-controls=<?="#panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-collapse".$sCat->prod_cat_id?> >
                                                                </button>
                                                                <?php }?>
                                                            </a>
                                                        </h2>
                                                        <div id="<?="panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-collapse".$sCat->prod_cat_id?>" class="accordion-collapse collapse"
                                                            aria-labelledby=<?="panelsStayOpen-panelsStayOpen-heading".$pcat->prod_cat_id."-inner-heading".$sCat->prod_cat_id?>>
                                                            <!-- Add your inner accordion content here -->
                                                            <!-- Example: -->
                                                            <?php if (!empty(count($sCatAr))) { ?>
                                                                <div class="accordion-body p-0">
                                                                <?php foreach ($sCatAr as $ssCat) { ?>
                                                                    <div class="accordion-item border-0 ">
                                                                        <h2 class="accordion-header" id="panelsStayOpen-panelsStayOpen-heading-2-inner-heading-2">
                                                                            <a href="<?php echo base_url('category/' . $ssCat->prod_cat_id); ?>" class="accordion-button collapsed py-2 px-2 pl-34">
                                                                            <span>
                                                                                <svg class="svgIcon-accordion" width="auto" height="16px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                                <rect width="24" height="24" fill="white"/>
                                                                                <path d="M9.5 7L14.5 12L9.5 17" stroke="#000000" stroke-linecap="round" stroke-linejoin="round"/>
                                                                                </svg>
                                                                            </span>
                                                                            <span><?php echo $ssCat->category_name; ?></span>
                                                                            <?php if (!empty(count(getCategoryBySubArray($ssCat->prod_cat_id)))) { ?> 
                                                                            <button class="btn ms-auto button-collapse py-2 collappse-btn"
                                                                                id="accordionPanelsStayOpen-panelsStayOpen-heading-2-inner-2" type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#panelsStayOpen-panelsStayOpen-heading-2-inner-collapse-2" aria-expanded="false"
                                                                                aria-controls="panelsStayOpen-panelsStayOpen-heading-2-inner-collapse-2">
                                                                            </button>
                                                                            <?php }?>
                                                                            </a>
                                                                        </h2>
                                                                        <div id="panelsStayOpen-panelsStayOpen-heading-2-inner-collapse-2" class="accordion-collapse collapse"
                                                                        aria-labelledby="anelsStayOpen-panelsStayOpen-heading-2-inner-heading-2">
                                                                        </div>
                                                                    </div>
                                                                    <?php }?>
                                                                </div>
                                                                <?php }?> 
                                                             </div>
                                                        </div>
                                                    <?php }?> 
                                                </div>
                                            <?php }?> 
                                        </div>
                                    </div>
                                    <!--single end-->
                                    <?php } ?>
                                </div>
                            </div>
                        <!--category end-->   
                        </div>
                        <?php } ?>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-sm-5 col-6 d-flex align-items-center justify-content-end">
                    <?php if ($modules['top_search'] == 1) { ?>
                        <form id="first-form-top" action="<?php echo base_url('products/search'); ?>"
                            class="mini-search" method="GET">
                            <div class="input-group">
                                <input type="text" class="form-control" name="keywordTop" placeholder="Search for Products..." value="<?php echo isset($keywordTop) ? $keywordTop : ''; ?>">
                                <span class="input-group-btn">
                                <button class="btn btn-default bg-white rounded-0" onclick="topSearchValidation('first-form-top','first-cat','first-keywordTop','first-valid')" type="button">                                    
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.0002 19L14.6572 14.657M14.6572 14.657C15.4001 13.9141 15.9894 13.0321 16.3914 12.0615C16.7935 11.0909 17.0004 10.0506 17.0004 8.99996C17.0004 7.94936 16.7935 6.90905 16.3914 5.93842C15.9894 4.96779 15.4001 4.08585 14.6572 3.34296C13.9143 2.60007 13.0324 2.01078 12.0618 1.60874C11.0911 1.20669 10.0508 0.999756 9.00021 0.999756C7.9496 0.999756 6.90929 1.20669 5.93866 1.60874C4.96803 2.01078 4.08609 2.60007 3.34321 3.34296C1.84288 4.84329 1 6.87818 1 8.99996C1 11.1217 1.84288 13.1566 3.34321 14.657C4.84354 16.1573 6.87842 17.0002 9.00021 17.0002C11.122 17.0002 13.1569 16.1573 14.6572 14.657Z" stroke="#727272" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>    
                                </button>
                            </span>
                            </div>
                        </form>
                        <?php } ?>  
                    </div>
                    <div class="col-xl-3 col-lg-3 col-sm-4 col-6">
                        <div class="d-flex flex-row align-items-center justify-content-end gap-3 gap-lg-5 h-100">
                        <?php if ($modules['compare'] == 1) { ?>
                            <a  href="<?php echo base_url('compare') ?>">
                                <div class="mini-cart d-flex position-relative" id="comparetReload">                                
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M28.2656 17.9062L24.4922 5.34375H15.8789V3.78516C15.8789 3.36328 15.457 2.92969 15.0234 2.92969C14.6016 2.92969 14.168 3.35156 14.168 3.78516V5.35547H5.55469L1.78125 17.9062H1.69922H1.27734C1.27734 20.7539 3.58594 23.0742 6.44531 23.0742C9.30469 23.0742 11.6133 20.7656 11.6133 17.9062H11.1211H11.0391L7.47656 6.12891H14.2383V24.457H7.54688V27.082H8.40234H15.0234H21.6445H22.5V24.457H15.8086V6.12891H22.5703L19.0078 17.9062H18.9258H18.4336C18.4336 20.7539 20.7422 23.0742 23.6016 23.0742C26.4609 23.0742 28.7695 20.7656 28.7695 17.9062H28.3477H28.2656ZM9.86719 17.9062H3.02344L6.41016 6.48047L9.86719 17.9062ZM20.1797 17.9062L23.6367 6.48047L27.0234 17.9062H20.1797Z" fill="white"/>
                                    </svg>        
                                    <span class="cart-item position-absolute rounded-5 d-flex align-items-center justify-content-center bg-white text-black">0</span>        
                                </div>
                            </a>
                        <?php } ?>
                        
                        <?php if ($modules['wishlist'] == 1) { ?>
                            <a href="<?php echo base_url('favorite') ?>">
                            <div class="mini-cart d-flex position-relative" id="wishlistReload">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.56275 17.3849L14.2535 25.549C14.5529 25.8301 14.7025 25.9707 14.879 26.0053C14.9585 26.021 15.0403 26.021 15.1198 26.0053C15.2963 25.9707 15.4459 25.8301 15.7453 25.549L24.436 17.3849C26.8813 15.0879 27.1782 11.3079 25.1217 8.65719L24.735 8.15878C22.2748 4.98783 17.3364 5.51962 15.6078 9.14166C15.3635 9.6533 14.6353 9.6533 14.391 9.14166C12.6624 5.51962 7.72406 4.98783 5.26384 8.15879L4.87715 8.65719C2.8206 11.3079 3.11754 15.0879 5.56275 17.3849Z" stroke="white" stroke-width="2"/>
                                </svg>    
                                <span class="cart-item position-absolute rounded-5 d-flex align-items-center justify-content-center bg-white text-black">0</span>        
                            </div>

                            </a>
                        <?php } ?>

                            <a href="<?php echo base_url('cart') ?>">
                            <div class="mini-cart d-flex position-relative" id="cartReload">    
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M25.2803 15.6573C24.5478 11.756 24.1828 9.80476 22.7928 8.65226C21.4066 7.49976 19.4216 7.49976 15.4528 7.49976H14.5503C10.5816 7.49976 8.59656 7.49976 7.20781 8.65226C5.82031 9.80476 5.45406 11.756 4.72156 15.6573C3.69406 21.1435 3.17906 23.886 4.67906 25.6935C6.17781 27.4998 8.96781 27.4998 14.5491 27.4998H15.4516C21.0328 27.4998 23.8241 27.4998 25.3228 25.6935C26.1928 24.6435 26.3853 23.281 26.1928 21.2498M11.2503 7.49976V6.24976C11.2503 5.25519 11.6454 4.30137 12.3487 3.59811C13.0519 2.89484 14.0057 2.49976 15.0003 2.49976C15.9949 2.49976 16.9487 2.89484 17.652 3.59811C18.3552 4.30137 18.7503 5.25519 18.7503 6.24976V7.49976" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                                </svg>
                                <span class="cart-item position-absolute rounded-5 d-flex align-items-center justify-content-center"><?php echo count(Cart()->contents()); ?></span>        
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script>

        addEventListener("load", (event) => {
            const bannerSiderParent =  document.querySelector("#bannerSiderParent"),
                catBox = document.querySelector("#catBox");
                if(catBox){
                    catBox.style.height = `${bannerSiderParent.getBoundingClientRect().height}px`;
                }
                
        });
       
       document.querySelectorAll(".collappse-btn").forEach(ele => {
           ele.addEventListener('click', (e) => {
               e.preventDefault();
               
               if(e.target.getAttribute('aria-expanded')==="true"){
                    e.target.style.backgroundPosition = "0 -12px";
                    span = false;
               }else{
                   e.target.style.backgroundPosition = "0 4px";
                   span = true;
               }
           })
       })

   </script>